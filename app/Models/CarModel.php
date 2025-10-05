<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    /**
     * كل موديل ينتمي إلى شركة مصنعة واحدة
     */
    public function carMake()
    {
        return $this->belongsTo(CarMake::class);
    }

    /**
     * كل موديل لديه العديد من الفئات
     */
    public function carTrims()
    {
        return $this->hasMany(CarTrim::class);
    }
}