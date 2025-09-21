<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstateOptions extends Model
{
    //

    protected $fillable = [
        'field_name',
        'display_name',
        'options',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];

}
