<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CarServiceType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active service types.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope a query to order service types by sort order.
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order', 'asc')->orderBy('display_name', 'asc');
    }

    /**
     * Get active service types ordered by sort order.
     */
    public function scopeActiveOrdered(Builder $query): void
    {
        $query->active()->ordered();
    }

    /**
     * Get service types for client selection (with 'other' option at the end).
     */
    public static function getClientOptions()
    {
        $serviceTypes = self::activeOrdered()->get(['name', 'display_name']);
        
        // Ensure 'other' is at the end
        $otherType = $serviceTypes->where('name', 'other')->first();
        $otherTypes = $serviceTypes->where('name', '!=', 'other');
        
        if ($otherType) {
            $otherTypes->push($otherType);
        }
        
        return $otherTypes->values();
    }

    /**
     * Ensure 'other' option exists and is at the end.
     */
    public static function ensureOtherOption()
    {
        $otherExists = self::where('name', 'other')->exists();
        
        if (!$otherExists) {
            $maxSortOrder = self::max('sort_order') ?? 0;
            
            self::create([
                'name' => 'other',
                'display_name' => 'أخرى',
                'is_active' => true,
                'sort_order' => $maxSortOrder + 1000, // Ensure it's at the end
            ]);
        }
    }

    /**
     * Relationship with car services ads.
     */
    public function carServicesAds()
    {
        return $this->hasMany(CarServicesAd::class, 'service_type', 'name');
    }
}