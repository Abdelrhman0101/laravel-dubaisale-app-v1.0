<?php

namespace App\Http\Controllers;

use App\Models\electronicAdOptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ElectronicAdOptionController extends Controller
{
    //
    public function getClientSpecs(): JsonResponse
    {
        try {
            $specs = ElectronicAdOptions::getClientSpecs();

            return response()->json([
                'success' => true,
                'data' => $specs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all specifications for admin
     */
    public function getAdminSpecs(): JsonResponse
    {
        try {
            $specs = ElectronicAdOptions::ordered()->get();

            return response()->json([
                'success' => true,
                'data' => $specs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get one specification by field name
     */
    public function getSpecByField(string $fieldName): JsonResponse
    {
        try {
            $spec = ElectronicAdOptions::where('field_name', $fieldName)->first();

            if (!$spec) {
                return response()->json([
                    'success' => false,
                    'message' => 'Specification not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $spec
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a single specification (admin only)
     */
    public function updateSpec(Request $request, string $fieldName): JsonResponse
    {
        try {
            $validated = $request->validate([
                'display_name' => 'required|string|max:255',
                'options' => 'required|array|min:1',
                'options.*' => 'required|string|max:255',
                'is_active' => 'boolean',
                'sort_order' => 'integer|min:0'
            ]);

            $spec = ElectronicAdOptions::where('field_name', $fieldName)->first();

            if (!$spec) {
                return response()->json([
                    'success' => false,
                    'message' => 'Specification not found'
                ], 404);
            }

            // Ensure 'other' is at the end
            $options = collect($validated['options'])
                ->reject(fn($option) => strtolower($option) === 'other')
                ->push('other')
                ->values()
                ->toArray();

            $spec->update([
                'display_name' => $validated['display_name'],
                'options' => $options,
                'is_active' => $validated['is_active'] ?? $spec->is_active,
                'sort_order' => $validated['sort_order'] ?? $spec->sort_order
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Specification updated successfully',
                'data' => $spec->fresh()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update specification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update multiple specifications (admin only)
     */
    public function bulkUpdateSpecs(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'specifications' => 'required|array|min:1',
                'specifications.*.field_name' => 'required|string|max:255',
                'specifications.*.display_name' => 'required|string|max:255',
                'specifications.*.options' => 'required|array|min:1',
                'specifications.*.options.*' => 'required|string|max:255',
                'specifications.*.is_active' => 'boolean',
                'specifications.*.sort_order' => 'integer|min:0'
            ]);

            $updatedSpecs = [];

            foreach ($validated['specifications'] as $specData) {
                // Ensure 'other' is always at the end
                $options = collect($specData['options'])
                    ->reject(fn($option) => strtolower($option) === 'other')
                    ->push('other')
                    ->values()
                    ->toArray();

                $spec = electronicAdOptions::updateOrCreate(
                    ['field_name' => $specData['field_name']],
                    [
                        'display_name' => $specData['display_name'],
                        'options' => $options,
                        'is_active' => $specData['is_active'] ?? true,
                        'sort_order' => $specData['sort_order'] ?? 0
                    ]
                );

                $updatedSpecs[] = $spec->fresh();
            }

            return response()->json([
                'success' => true,
                'message' => 'Specifications updated or created successfully',
                'data' => $updatedSpecs
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update specifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete specifications (admin only)
     */
    public function bulkDeleteSpecs(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'field_names' => 'required|array|min:1',
                'field_names.*' => 'required|string|max:255'
            ]);

            $deleted = electronicAdOptions::whereIn('field_name', $validated['field_names'])->delete();

            return response()->json([
                'success' => true,
                'message' => "$deleted specifications deleted successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete specifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
