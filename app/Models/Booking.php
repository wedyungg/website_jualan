<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'booking_time',
        'location',
        'status',
        'notes',
        'total_price',
        'whatsapp_sent',
        'whatsapp_sent_at'
    ];

    /**
     * Relasi: Siji booking duweke siji paket
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Relasi: Siji booking duweke siji user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Casting kanggo standarisasi tipe data neng Laravel
    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
        'whatsapp_sent' => 'boolean'
    ];

    /**
     * Scope kanggo nggampangke nggoleki booking sing status-e pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}