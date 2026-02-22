<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    const OWNER = 'owner';
    const ADMIN = 'admin';
    const VENDOR_MANAGER = 'vendor-manager';
    const FINANCE_MANAGER = 'finance-manager';
    const SUPPORT_EXECUTIVE = 'support-executive';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
