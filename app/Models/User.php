<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    const ROLE_OWNER = 'owner';
    const ROLE_ADMIN = 'admin';
    const ROLE_VENDOR = 'vendor';
    const ROLE_VENDOR_MANAGER = 'vendor-manager';
    const ROLE_FINANCE_MANAGER = 'finance-manager';
    const ROLE_SUPPORT_EXECUTIVE = 'support-executive';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role', // Changed from role_id
        'status',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function isOwner()
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN || $this->role === self::ROLE_OWNER;
    }

    public function isVendor()
    {
        return $this->role === self::ROLE_VENDOR;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
