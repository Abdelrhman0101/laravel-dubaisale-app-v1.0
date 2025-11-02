<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CarSalesAd;
use App\Models\UserContactInfo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'whatsapp',
        'password',
        'referral_code',
        'is_active',
        'email_verified_at',
        'role',
        'advertiser_name',
        'advertiser_type',
        'advertiser_logo',
        'advertiser_location',
        'otp_phone',
        'otp_expires_at',
        'user_type',
        'otp_verified',
        'referral_code_list',
        'latitude',
        'longitude',
        // 'is_active',
        // 'otp_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_code',
        'otp_phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'referral_code_list' => 'array',
        'activation_code_expires_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
        'otp_verified' => 'boolean',
    ];

    /**
     * Get the car sale ads for the user.
     */

    public function carSalesAds()
    {
        return $this->hasMany(CarSalesAd::class);
    }

    public function bestCategories()
    {
        return $this->hasMany(BestAdvertiser::class);
    }

    /**
     * Get the contact information for the user.
     */
    public function contactInfo()
    {
        return $this->hasOne(UserContactInfo::class);
    }
    public function bestAdvertiser()
    {
        return $this->hasOne(BestAdvertiser::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
