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

    protected $casts = [
        'categories' => 'array',
    ];


    /**
     * Get the user that this record belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function addCategory(string $category): bool
    {
        $categories = $this->categories ?? [];
        if (!in_array($category, $categories)) {
            $categories[] = $category;
            $this->categories = $categories;
            return $this->save();
        }
        return false;
    }

    public function removeCategory(string $category): bool
    {
        $categories = $this->categories ?? [];
        $key = array_search($category, $categories);
        if ($key !== false) {
            unset($categories[$key]);
            $this->categories = array_values($categories); // Re-index
            return $this->save();
        }
        return false;
    }
}
