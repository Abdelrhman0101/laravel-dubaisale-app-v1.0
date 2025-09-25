<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class electronicAdOptions extends Model
{
    //
    use HasFactory;

    protected $table = 'electronic_ads_options';

    protected $fillable = [
        'field_name',
        'display_name',
        'options',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: Active only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Order by sort_order asc
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Add 'other' option if not already exists
     */
    public function ensureOtherOption()
    {
        $options = $this->options ?? [];

        $hasOther = collect($options)->contains(function ($option) {
            return strtolower($option) === 'other';
        });

        if (!$hasOther) {
            $options[] = 'other';
            $this->options = $options;
        }

        return $this;
    }

    /**
     * Get formatted specifications for client
     */
    public static function getClientSpecs()
    {
        return self::active()
            ->ordered()
            ->get()
            ->map(function ($spec) {
                $spec->ensureOtherOption();
                return [
                    'field_name'   => $spec->field_name,
                    'display_name' => $spec->display_name,
                    'options'      => $spec->options,
                ];
            });
    }
}
