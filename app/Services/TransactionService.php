<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Discount;
use App\Models\StockHistory;
use Illuminate\Support\Str;

class TransactionService
{
    /**
     * Buat transaksi baru
     */
    public function createTransaction($outletId, $userId, $customerData, $items, $discountData = [])
    {
        try {
            $transactionNumber = $this->generateTransactionNumber($outletId);
            
            // Hitung totals
            $subtotal = 0;
            $totalDiscount = 0;
            
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                
                // Apply item discount jika ada
                if (isset($item['discount_amount'])) {
                    $totalDiscount += $item['discount_amount'];
                }
                
                $subtotal += $itemTotal;
            }

            // Apply transaction discount
            $transactionDiscount = $discountData['amount'] ?? 0;
            $totalDiscount += $transactionDiscount;

            // Hitung tax
            $taxPercentage = config('payment.tax_percentage', 10);
            $taxAmount = ($subtotal - $totalDiscount) * ($taxPercentage / 100);

            // Create transaction
            $transaction = Transaction::create([
                'transaction_number' => $transactionNumber,
                'outlet_id' => $outletId,
                'user_id' => $userId,
                'customer_name' => $customerData['name'] ?? null,
                'customer_phone' => $customerData['phone'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => $taxAmount,
                'total_amount' => ($subtotal - $totalDiscount + $taxAmount),
                'payment_status' => 'pending',
            ]);

            // Add transaction items
            foreach ($items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'discount_percent' => $item['discount_percent'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock
                $this->reduceStock($item['product_id'], $item['quantity'], $outletId, 'out', 'transaction', $transaction->id);
            }

            return $transaction->load('items', 'payments');

        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Generate nomor transaksi unik
     */
    private function generateTransactionNumber($outletId): string
    {
        $date = now()->format('Ymd');
        $prefix = config('payment.transaction.prefix', 'TXN');
        
        // Get last transaction number today
        $lastTransaction = Transaction::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastTransaction) {
            $lastNumber = substr($lastTransaction->transaction_number, -6);
            $sequence = intval($lastNumber) + 1;
        }

        return $prefix . $date . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Reduce stock setelah transaksi
     */
    private function reduceStock($productId, $quantity, $outletId, $type = 'out', $refType = 'transaction', $refId = null)
    {
        $product = Product::find($productId);
        $product->decrement('stock', $quantity);

        // Catat di stock history
        StockHistory::create([
            'product_id' => $productId,
            'outlet_id' => $outletId,
            'type' => $type,
            'quantity' => -$quantity,
            'reference_type' => $refType,
            'reference_id' => $refId,
        ]);
    }

    /**
     * Update transaksi
     */
    public function updateTransaction($transaction, $data)
    {
        $transaction->update($data);
        return $transaction->refresh();
    }

    /**
     * Cancel transaksi
     */
    public function cancelTransaction($transaction)
    {
        // Restore stock
        foreach ($transaction->items as $item) {
            Product::find($item->product_id)->increment('stock', $item->quantity);

            StockHistory::create([
                'product_id' => $item->product_id,
                'outlet_id' => $transaction->outlet_id,
                'type' => 'in',
                'quantity' => $item->quantity,
                'reference_type' => 'transaction_cancel',
                'reference_id' => $transaction->id,
                'notes' => 'Pembatalan transaksi ' . $transaction->transaction_number,
            ]);
        }

        $transaction->delete();
    }

    /**
     * Get transaction detail
     */
    public function getTransactionDetail($id)
    {
        return Transaction::with(['items', 'payments', 'whatsappMessages'])->find($id);
    }

    /**
     * Hitung total penjualan
     */
    public function calculateDailySales($outletId, $date = null)
    {
        $query = Transaction::where('outlet_id', $outletId)
            ->where('payment_status', 'completed');

        if ($date) {
            $query->whereDate('created_at', $date);
        } else {
            $query->whereDate('created_at', today());
        }

        return [
            'total_amount' => $query->sum('total_amount'),
            'total_transactions' => $query->count(),
            'total_items' => $query->sum('items_count'),
            'average_transaction' => $query->avg('total_amount'),
        ];
    }
}
