<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionBanner extends Model
{
    protected $fillable = [
        'category',
        'lang',
        'type',
        'content_type',
        'content',
        'style_options'
    ];

    protected $casts = [
        'style_options' => 'array',
    ];
}
