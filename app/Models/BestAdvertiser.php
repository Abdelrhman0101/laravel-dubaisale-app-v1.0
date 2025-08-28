<?php

namespace App\Models;

// === هذا هو السطر المهم الذي يجب تصحيحه ===
use Illuminate\Database\Eloquent\Factories\HasFactory;
// ===========================================
use Illuminate\Database\Eloquent\Model;

class BestAdvertiser extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the user that this record belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}