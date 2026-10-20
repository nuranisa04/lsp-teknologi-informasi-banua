<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role',
        'nama',
        'foto_profile',
        'email',
        'password',
        'no_whatsapp',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            'id_role',
            'id_role'
        );
    }

    public function mitras(): HasMany
    {
        return $this->hasMany(
            Mitra::class,
            'id_user',
            'id_user'
        );
    }

    public function isAdmin(): bool
    {
        return $this->role?->nama_role === 'Admin LSP';
    }

    public function isPimpinan(): bool
    {
        return $this->role?->nama_role === 'Pimpinan';
    }
}
