<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarMake extends Model
{
    use HasFactory;

    // للسماح بإضافة البيانات بشكل جماعي بدون تحديد كل حقل
    protected $guarded = [];
    
    // لمنع لارافيل من البحث عن created_at و updated_at
    public $timestamps = false;

    /**
     * كل شركة لديها العديد من الموديلات
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
}