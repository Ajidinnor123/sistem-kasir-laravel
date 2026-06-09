<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'outlet_id',
        'name',
        'type',
        'value',
        'min_purchase',
        'max_usage',
        'usage_count',
        'active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_usage' => 'integer',
        'usage_count' => 'integer',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: Diskon milik Outlet
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Scope: Aktif
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope: Berdasarkan type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check apakah diskon masih bisa digunakan
     */
    public function canBeUsed(): bool
    {
        if (!$this->active) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    /**
     * Hitung nilai diskon
     */
    public function calculateDiscount($amount): float
    {
        if ($amount < $this->min_purchase) {
            return 0;
        }

        return match($this->type) {
            'percentage' => $amount * ($this->value / 100),
            'fixed' => $this->value,
            default => 0
        };
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Get nama type
     */
    public function getTypeName(): string
    {
        return match($this->type) {
            'item' => 'Per Item',
            'transaction' => 'Per Transaksi',
            'percentage' => 'Persentase',
            'fixed' => 'Nominal',
            default => 'Tidak Diketahui'
        };
    }
}
