<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $fillable = [
        'user_id',
        'premium_star_ads',
        'premium_ads',
        'featured_ads',
        'premium_star_used',
        'premium_used',
        'featured_used',
        'days',
        'start_date',
        'expire_date'
    ];

    protected static function booted()
    {
        static::creating(function ($package) {
            if (!$package->expire_date) {
                $package->expire_date = now()->addDays($package->days);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
