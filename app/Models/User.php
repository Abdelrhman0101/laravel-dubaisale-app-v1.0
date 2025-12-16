<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\CarSalesAd;
use App\Models\CarServicesAd;
use App\Models\RestaurantAd;
use App\Models\CarRentAd;
use App\Models\JobAd;
use App\Models\electronicAd;
use App\Models\OtherServiceAds;
use App\Models\RealEstateAd;
use App\Models\UserContactInfo;
use Illuminate\Support\Facades\Storage;


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
        'advertiser_logo'
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
    protected $appends=['advertiser_logo_url', 'total_ads_count'];

    public function getAdvertiserLogoUrlAttribute()
    {
        return $this->advertiser_logo ? Storage::url($this->advertiser_logo) : null;
    }
    public function carSalesAds()
    {
        return $this->hasMany(CarSalesAd::class);
    }

    public function carServicesAds()
    {
        return $this->hasMany(CarServicesAd::class);
    }

    public function restaurantAds()
    {
        return $this->hasMany(RestaurantAd::class);
    }

    public function carRentAds()
    {
        return $this->hasMany(CarRentAd::class);
    }

    public function jobAds()
    {
        return $this->hasMany(JobAd::class);
    }

    public function electronicAds()
    {
        return $this->hasMany(electronicAd::class);
    }

    public function otherServiceAds()
    {
        return $this->hasMany(OtherServiceAds::class);
    }

    public function realEstateAds()
    {
        return $this->hasMany(RealEstateAd::class);
    }

    public function getTotalAdsCountAttribute()
    {
        return $this->car_sales_ads_count +
            $this->car_services_ads_count +
            $this->restaurant_ads_count +
            $this->car_rent_ads_count +
            $this->job_ads_count +
            $this->electronic_ads_count +
            $this->other_service_ads_count +
            $this->real_estate_ads_count;
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
