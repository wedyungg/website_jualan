<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'booking_time',
        'location',
        'notes',
        'total_price',
        'down_payment',      // DP 40%
        'remaining_payment', // Sisa 60%
        'status',
        'payment_method',
        'payment_proof',
        'full_payment_proof', // Bukti pelunasan
        'payment_deadline',
        'dp_paid_at',
        'full_paid_at',
        'is_dp_verified',    // Admin verifikasi DP
        'is_full_paid'       // Status lunas
    ];

    protected $casts = [
        'booking_date' => 'date',
        'payment_deadline' => 'datetime',
        'dp_paid_at' => 'datetime',
        'full_paid_at' => 'datetime',
        'is_dp_verified' => 'boolean',
        'is_full_paid' => 'boolean',
        'down_payment' => 'decimal:0',
        'remaining_payment' => 'decimal:0',
        'total_price' => 'decimal:0'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';      // Belum DP
    const STATUS_DP_PAID = 'dp_paid';     // Sudah DP (tunggu verifikasi)
    const STATUS_DP_VERIFIED = 'dp_verified'; // DP diverifikasi admin
    const STATUS_FULL_PAID = 'full_paid'; // Lunas
    const STATUS_CONFIRMED = 'confirmed'; // Siap dieksekusi
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';
    const STATUS_COMPLETED = 'completed';

    // Payment methods
    const PAYMENT_TRANSFER = 'transfer';
    const PAYMENT_CASH = 'cash';

    // Bank account (GANTI DENGAN REKENINGMU)
    const BANK_ACCOUNT = [
        'bank' => 'Bank Jago',
        'number' => '107439846457',
        'name' => 'MUHAMMAD ZIYAN FIRDAUS'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // BOOT: Hitung DP & sisa otomatis
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->calculatePayments();
        });
        
        static::updating(function ($booking) {
            if ($booking->isDirty('total_price')) {
                $booking->calculatePayments();
            }
        });
    }

    // Hitung DP 40% dan sisa 60%
    public function calculatePayments()
    {
        $this->down_payment = $this->total_price * 0.4;
        $this->remaining_payment = $this->total_price * 0.6;
    }

    // Helper methods
    public function canPayDp()
    {
        return $this->status === self::STATUS_PENDING && 
               !$this->isPaymentExpired();
    }

    public function canPayFull()
    {
        return $this->status === self::STATUS_DP_VERIFIED &&
               !$this->isFullPaid();
    }

    public function canBeCancelled()
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_DP_PAID,
            self::STATUS_DP_VERIFIED
        ]);
    }

    public function isPaymentExpired()
    {
        if (!$this->payment_deadline) {
            return false;
        }
        return now()->greaterThan($this->payment_deadline);
    }

    public function isFullPaid()
    {
        return $this->is_full_paid;
    }

    public function getRemainingTime()
    {
        if (!$this->payment_deadline) {
            return null;
        }
        
        $now = now();
        $deadline = Carbon::parse($this->payment_deadline);
        
        if ($now->greaterThan($deadline)) {
            return '00:00:00';
        }
        
        $diff = $now->diff($deadline);
        return sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
    }

    public function getPaymentStatusBadge()
    {
        $badges = [
            self::STATUS_PENDING => '<span class="badge bg-warning">Menunggu DP 40%</span>',
            self::STATUS_DP_PAID => '<span class="badge bg-info">DP Menunggu Verifikasi</span>',
            self::STATUS_DP_VERIFIED => '<span class="badge bg-primary">DP Terverifikasi (Bayar 60%)</span>',
            self::STATUS_FULL_PAID => '<span class="badge bg-success">LUNAS</span>',
            self::STATUS_CONFIRMED => '<span class="badge bg-success">Dikonfirmasi</span>',
            self::STATUS_CANCELLED => '<span class="badge bg-danger">Dibatalkan</span>',
            self::STATUS_EXPIRED => '<span class="badge bg-secondary">Kadaluarsa</span>',
            self::STATUS_COMPLETED => '<span class="badge bg-dark">Selesai</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    // Get bank account info
    public static function getBankAccount()
    {
        return self::BANK_ACCOUNT;
    }

    // Format currency
    public function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}