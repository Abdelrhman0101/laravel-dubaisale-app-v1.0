<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantCategory;
use Illuminate\Http\Request;

class RestaurantCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = RestaurantCategory::query();
        if ($request->boolean('only_active')) {
            $query->where('active', true);
        }
        $items = $query->orderBy('sort_order')->orderBy('name')->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:restaurant_categories,name',
            'active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $sort = $validated['sort_order'] ?? (RestaurantCategory::max('sort_order') + 1);
        $item = RestaurantCategory::create([
            'name' => $validated['name'],
            'active' => $validated['active'] ?? true,
            'sort_order' => $sort,
        ]);

        return response()->json($item, 201);
    }

    public function show(RestaurantCategory $restaurantCategory)
    {
        return response()->json($restaurantCategory);
    }

    public function update(Request $request, RestaurantCategory $restaurantCategory)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100|unique:restaurant_categories,name,' . $restaurantCategory->id,
            'active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $restaurantCategory->update($validated);
        return response()->json($restaurantCategory);
    }

    public function destroy(RestaurantCategory $restaurantCategory)
    {
        $restaurantCategory->delete();
        return response()->json(null, 204);
    }
}