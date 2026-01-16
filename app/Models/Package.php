<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    // PERBAIKAN: Tambahkan 'category' ke fillable
    protected $fillable = [
        'name',
        'category', // PASTIKAN INI ADA
        'price',
        'description',
        'duration_hours',
        'cover_image',
        'features',
        'is_active'
    ];

    // PERBAIKAN: Casting untuk tipe data
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array' // Karena kolomnya json
    ];
}