<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'vendor_id',
        'category_id',
        'title',
        'description',
        'price',
        'status',
        'rejection_reason',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
