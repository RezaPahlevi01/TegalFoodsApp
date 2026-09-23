<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'umkm_id',
        'kode_order',

        'nama_penerima',
        'nomor_telepon',
        'alamat_pengiriman',
        'metode_pengiriman',

        'subtotal',
        'ongkir',
        'total',
        'status',
        'metode_pembayaran',

        'alasan_penolakan',
        'confirmed_at',
        'paid_at',
        'processed_at',
        'completed_at',
    ];

    protected $casts = [
        'confirmed_at'  => 'datetime',
        'paid_at'       => 'datetime',
        'processed_at'  => 'datetime',
        'completed_at'  => 'datetime',
    ];

    private const TRANSITIONS = [
        'pending_confirmation' => ['waiting_payment', 'rejected', 'cancelled'],
        'waiting_payment'      => ['paid', 'cancelled'],
        'paid'                 => ['processing', 'cancelled'],
        'processing'           => ['ready'],
        'ready'                => ['delivering', 'completed'],
        'delivering'           => ['completed'],
        'completed'            => [],
        'rejected'             => [],
        'cancelled'            => [],
    ];

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::TRANSITIONS[$this->status] ?? [];
        return in_array($newStatus, $allowed, true);
    }

    public function transitionTo(string $newStatus): bool
    {
        if (!$this->canTransitionTo($newStatus)) {
            return false;
        }

        $this->status = $newStatus;

        $now = now();
        match ($newStatus) {
            'waiting_payment' => $this->confirmed_at = $now,
            'paid'            => $this->paid_at = $now,
            'processing'      => $this->processed_at = $now,
            'completed'       => $this->completed_at = $now,
            default           => null,
        };

        $this->save();
        return true;
    }

    public static function allowedStatuses(): array
    {
        return array_keys(self::TRANSITIONS);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
