<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    // Kolom sing entuk diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'duration_hours',
        'cover_image',
        'features',
        'is_active'
    ];

    /**
     * Relasi: Siji paket duwe akeh booking
     * Iki mau sing kleru mergo jeneng fungsine ilang
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Casting tipe data supaya Laravel otomatis ngerubah dadi array utawa boolean
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array' // Fitur bakal dadi array soko JSON neng database
    ];
}