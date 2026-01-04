<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nomer_wa',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Ini bisa dihapus kalau gak pakai email verification
            'password' => 'hashed',
        ];
    }

    // =============== FIX DISINI ===============
    
    // FIX 2.1: Override method untuk set identifier ke nomer_wa
    public function getAuthIdentifierName()
    {
        return 'nomer_wa';
    }
    
    // FIX 2.2: Override method untuk password reset (opsional tapi baik)
    public function getEmailForPasswordReset()
    {
        return $this->nomer_wa;
    }
    
    // FIX 2.3: Tambahkan ini untuk compatibility
    public function getAuthIdentifier()
    {
        return $this->nomer_wa;
    }
    // ==========================================
}