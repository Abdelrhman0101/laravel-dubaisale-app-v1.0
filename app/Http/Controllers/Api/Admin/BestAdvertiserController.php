<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BestAdvertiser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BestAdvertiserController extends Controller
{
    protected $allowedCategories = [
        'car_sales', 'real_estate', 'car_rent', 'car_services', 
        'electronics', 'restaurant', 'jobs', 'other_services'
    ];

    public function toggleStatus(Request $request, User $user)
    {
        $data = $request->validate([
            'category' => ['required', Rule::in($this->allowedCategories)]
        ]);

        $categorySlug = $data['category'];
        $record = BestAdvertiser::where('user_id', $user->id)
                                ->where('category_slug', $categorySlug);

        if ($record->exists()) {
            // إذا كان موجودًا، احذفه (إلغاء التمييز)
            $record->delete();
            $message = "User removed from 'The Best' in '{$categorySlug}' category.";
        } else {
            // إذا لم يكن موجودًا، أضفه (تمييز المستخدم)
            BestAdvertiser::create([
                'user_id' => $user->id,
                'category_slug' => $categorySlug
            ]);
            $message = "User marked as 'The Best' in '{$categorySlug}' category.";
        }

        return response()->json(['message' => $message]);
    }
}