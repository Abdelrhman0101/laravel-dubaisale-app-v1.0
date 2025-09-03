<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarServiceTypeController extends Controller
{
    /**
     * Display a listing of car service types.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = CarServiceType::query();

        // Filter by active status if provided
        $query->when($request->query('active'), function ($q, $active) {
            return $q->where('is_active', $active === 'true');
        });

        $serviceTypes = $query->ordered()->get();

        return response()->json($serviceTypes);
    }

    /**
     * Get service types for client selection (with 'other' option at the end).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClientOptions()
    {
        $serviceTypes = CarServiceType::getClientOptions();
        
        return response()->json($serviceTypes);
    }

    /**
     * Store a newly created car service type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:car_service_types,name',
            'display_name' => 'required|string|max:150',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // If sort_order is not provided, set it to the next available order
        if (!isset($validatedData['sort_order'])) {
            $maxSortOrder = CarServiceType::max('sort_order') ?? 0;
            $validatedData['sort_order'] = $maxSortOrder + 1;
        }

        // Ensure 'other' option exists
        CarServiceType::ensureOtherOption();

        $serviceType = CarServiceType::create($validatedData);

        return response()->json($serviceType, 201);
    }

    /**
     * Display the specified car service type.
     *
     * @param  \App\Models\CarServiceType  $carServiceType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CarServiceType $carServiceType)
    {
        return response()->json($carServiceType);
    }

    /**
     * Update the specified car service type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarServiceType  $carServiceType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CarServiceType $carServiceType)
    {
        $validatedData = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('car_service_types', 'name')->ignore($carServiceType->id)
            ],
            'display_name' => 'sometimes|required|string|max:150',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $carServiceType->update($validatedData);

        return response()->json($carServiceType);
    }

    /**
     * Remove the specified car service type from storage.
     *
     * @param  \App\Models\CarServiceType  $carServiceType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CarServiceType $carServiceType)
    {
        // Prevent deletion of 'other' option
        if ($carServiceType->name === 'other') {
            return response()->json([
                'error' => 'Cannot delete the "other" option as it is required by the system.'
            ], 400);
        }

        // Check if there are any ads using this service type
        $adsCount = $carServiceType->carServicesAds()->count();
        if ($adsCount > 0) {
            return response()->json([
                'error' => "Cannot delete this service type. It is currently used by {$adsCount} ad(s)."
            ], 400);
        }

        $carServiceType->delete();

        return response()->json(null, 204);
    }

    /**
     * Bulk update service types (for reordering).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'service_types' => 'required|array',
            'service_types.*.id' => 'required|integer|exists:car_service_types,id',
            'service_types.*.sort_order' => 'required|integer|min:0',
            'service_types.*.is_active' => 'sometimes|boolean',
        ]);

        foreach ($validatedData['service_types'] as $serviceTypeData) {
            $serviceType = CarServiceType::find($serviceTypeData['id']);
            $updateData = ['sort_order' => $serviceTypeData['sort_order']];
            
            if (isset($serviceTypeData['is_active'])) {
                $updateData['is_active'] = $serviceTypeData['is_active'];
            }
            
            $serviceType->update($updateData);
        }

        // Ensure 'other' is always at the end
        $otherType = CarServiceType::where('name', 'other')->first();
        if ($otherType) {
            $maxSortOrder = CarServiceType::where('name', '!=', 'other')->max('sort_order') ?? 0;
            $otherType->update(['sort_order' => $maxSortOrder + 1000]);
        }

        $serviceTypes = CarServiceType::ordered()->get();

        return response()->json([
            'message' => 'Service types updated successfully.',
            'service_types' => $serviceTypes
        ]);
    }

    /**
     * Toggle the active status of a service type.
     *
     * @param  \App\Models\CarServiceType  $carServiceType
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleActive(CarServiceType $carServiceType)
    {
        $carServiceType->update([
            'is_active' => !$carServiceType->is_active
        ]);

        return response()->json([
            'message' => 'Service type status updated successfully.',
            'service_type' => $carServiceType
        ]);
    }
}