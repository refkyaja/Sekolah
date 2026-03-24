<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Notification extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
        'title',
        'body',
        'data',
        'target_roles',
        'target_user_id',
        'read_at',
    ];

    protected $casts = [
        'data'         => 'array',
        'target_roles' => 'array',
        'read_at'      => 'datetime',
        'created_at'   => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // ==================== RELASI ====================

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    // ==================== SCOPES ====================

    /**
     * Filter notifikasi yang relevan untuk user (berdasarkan role atau personal).
     */
    public function scopeForAuthUser(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $q) use ($user) {
            // Personal: ditujukan langsung ke user ini
            $q->where('target_user_id', $user->id)
              // Atau: role user termasuk dalam target_roles
              ->orWhere(function (Builder $q2) use ($user) {
                  $q2->whereNull('target_user_id')
                     ->where(function (Builder $q3) use ($user) {
                         // target_roles null = semua role bisa lihat
                         $q3->whereNull('target_roles')
                            ->orWhereJsonContains('target_roles', $user->role);
                     });
              });
        });
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeRecent(Builder $query, int $limit = 15): Builder
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }

    // ==================== METHODS ====================

    public function markAsRead(): void
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    // ==================== FACTORY HELPERS (static) ====================

    /**
     * Buat notifikasi untuk role tertentu.
     * Contoh: Notification::forRoles(['admin','operator'], 'ppdb_baru', 'Pendaftaran Baru', '...');
     */
    public static function forRoles(array $roles, string $type, string $title, string $body, array $data = []): static
    {
        return static::create([
            'type'         => $type,
            'title'        => $title,
            'body'         => $body,
            'data'         => $data ?: null,
            'target_roles' => $roles,
        ]);
    }

    /**
     * Buat notifikasi untuk semua role (broadcast ke semua).
     */
    public static function forAll(string $type, string $title, string $body, array $data = []): static
    {
        return static::create([
            'type'  => $type,
            'title' => $title,
            'body'  => $body,
            'data'  => $data ?: null,
        ]);
    }

    /**
     * Buat notifikasi personal untuk user tertentu.
     */
    public static function forUser(int $userId, string $type, string $title, string $body, array $data = []): static
    {
        return static::create([
            'type'           => $type,
            'title'          => $title,
            'body'           => $body,
            'data'           => $data ?: null,
            'target_user_id' => $userId,
        ]);
    }
}
