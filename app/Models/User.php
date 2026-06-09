<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'outlet_id',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: User milik Outlet
     */
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Relasi: User memiliki banyak Transaksi
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope: Aktif
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope: Berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: Berdasarkan outlet
     */
    public function scopeByOutlet($query, $outletId)
    {
        return $query->where('outlet_id', $outletId);
    }

    /**
     * Check apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check apakah user adalah manajer
     */
    public function isManager(): bool
    {
        return $this->role === 'manajer';
    }

    /**
     * Check apakah user adalah kasir
     */
    public function isCashier(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * Get nama role
     */
    public function getRoleName(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'manajer' => 'Manajer',
            'kasir' => 'Kasir',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Check permission
     */
    public function hasPermission($permission): bool
    {
        $permissions = [
            'admin' => ['view_all', 'create', 'edit', 'delete', 'manage_users'],
            'manajer' => ['view_outlet', 'create', 'edit', 'manage_cashiers'],
            'kasir' => ['view_outlet', 'create_transaction'],
        ];

        return in_array($permission, $permissions[$this->role] ?? []);
    }
}
