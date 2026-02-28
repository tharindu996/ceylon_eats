<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'vendor_id',
        'listing_id',
        'title',
        'discount_percentage',
        'start_date',
        'end_date',
        'status',
        'rejection_reason',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
