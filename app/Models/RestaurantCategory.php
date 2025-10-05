<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
    ];
}