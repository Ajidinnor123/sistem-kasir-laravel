<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'discount_amount',
        'discount_percent',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: Item milik Transaksi
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi: Item milik Produk
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Hitung subtotal
     */
    public function calculateSubtotal(): float
    {
        $itemTotal = $this->price * $this->quantity;
        return $itemTotal - $this->discount_amount;
    }

    /**
     * Get harga setelah diskon
     */
    public function getPriceAfterDiscount(): float
    {
        if ($this->discount_percent > 0) {
            return $this->price * (1 - $this->discount_percent / 100);
        }
        return $this->price - ($this->discount_amount / $this->quantity);
    }
}
