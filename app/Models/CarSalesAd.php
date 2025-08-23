<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSalesAd extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Using guarded instead of fillable for simplicity as we have many fields.
     * Be careful with this in production if you have sensitive fields.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'thumbnail_images' => 'array',
        'warranty' => 'boolean',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}