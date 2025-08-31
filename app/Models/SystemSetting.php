<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * هذا يجعل التعامل مع القيم أسهل (e.g., تحويل '30' إلى integer 30)
     */
    protected $casts = [
        'value' => 'string', // سيتم التعامل مع التحويل في مكان آخر
    ];
}