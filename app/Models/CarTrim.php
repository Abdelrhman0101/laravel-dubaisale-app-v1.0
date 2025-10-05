<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTrim extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    
    /**
     * كل فئة تنتمي إلى موديل واحد
     */
    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}