<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'commission_rate',
        'verification_status',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
