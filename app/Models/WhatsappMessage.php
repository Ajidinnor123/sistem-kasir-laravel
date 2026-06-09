<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'transaction_id',
        'phone_number',
        'message',
        'status',
        'external_id',
        'retry_count',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'retry_count' => 'integer',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: Pesan milik Transaksi
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Scope: Berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Sent
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope: Failed
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Check apakah pesan sudah dikirim
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Mark sebagai sent
     */
    public function markAsSent($externalId = null)
    {
        $this->update([
            'status' => 'sent',
            'external_id' => $externalId,
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark sebagai failed
     */
    public function markAsFailed($errorMessage)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Increment retry count
     */
    public function incrementRetry()
    {
        $this->increment('retry_count');
    }

    /**
     * Get nama status
     */
    public function getStatusName(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'sent' => 'Terkirim',
            'failed' => 'Gagal',
            default => 'Tidak Diketahui'
        };
    }
}
