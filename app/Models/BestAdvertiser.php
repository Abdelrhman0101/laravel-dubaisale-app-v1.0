<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// في ملف BestAdvertiser.php
class BestAdvertiser extends Model
{
    use HasFactory;
    protected $guarded = [];
    // لا نحتاج لتعريف علاقة عكسية هنا حاليًا
}