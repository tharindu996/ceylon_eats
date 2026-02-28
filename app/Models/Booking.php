<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'vendor_id',
        'customer_id',
        'booking_date',
        'booking_time',
        'status',
        'payment_status',
        'subtotal',
        'commission_amount',
        'vendor_payout_amount',
        'total_amount',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
