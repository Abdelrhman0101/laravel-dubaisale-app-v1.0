<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JopAdValues extends Model
{
    //
    protected $table = '_jop_ads_values';
    protected $fillable = [
        'field_name',
        'display_name',
        'options',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // public function ensureOtherOption()
    // {
    //     $options = $this->options ?? [];
    //     $hasOther = collect($options)->contains(fn($opt) => strtolower($opt) === 'other');

    //     if (!$hasOther) {
    //         $options[] = 'Other';
    //         $this->options = $options;
    //     }

    //     return $this;
    // }

    public static function getClientSpecs()
    {
        return self::active()
            ->ordered()
            ->get()
            ->map(function ($spec) {
                // $spec->ensureOtherOption();
                return [
                    'field_name'   => $spec->field_name,
                    'display_name' => $spec->display_name,
                    'options'      => $spec->options,
                ];
            });
    }
}
