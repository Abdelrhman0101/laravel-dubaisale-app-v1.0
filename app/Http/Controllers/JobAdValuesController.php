<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JopAdValues;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JobAdValuesController extends Controller
{
    //
    public function getClientSpecs(): JsonResponse
    {
        try {
            $specs = JopAdValues::getClientSpecs();

            return response()->json([
                'success' => true,
                'data'    => $specs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specifications',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all specifications for admin management
     */
    public function getAdminSpecs(): JsonResponse
    {
        try {
            $specs = JopAdValues::ordered()->get();

            return response()->json([
                'success' => true,
                'data'    => $specs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specifications',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific specification by field name
     */
    public function getSpecByField(string $fieldName): JsonResponse
    {
        try {
            $spec = JopAdValues::where('field_name', $fieldName)->first();

            if (!$spec) {
                return response()->json([
                    'success' => false,
                    'message' => 'Specification not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data'    => $spec
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve specification',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a specific specification
     */
    public function updateSpec(Request $request, string $fieldName): JsonResponse
    {
        try {
            $validated = $request->validate([
                'display_name' => 'required|string|max:255',
                'options'      => 'required|array|min:1',
                'options.*'    => 'required|string|max:255',
                'is_active'    => 'boolean',
                'sort_order'   => 'integer|min:0'
            ]);

            $spec = JopAdValues::where('field_name', $fieldName)->first();

            if (!$spec) {
                return response()->json([
                    'success' => false,
                    'message' => 'Specification not found'
                ], 404);
            }

            // Ensure 'Other' always exists at the end
            $options = collect($validated['options'])
                ->reject(fn($option) => strtolower($option) === 'other')
                ->push('Other')
                ->values()
                ->toArray();

            $spec->update([
                'display_name' => $validated['display_name'],
                'options'      => $options,
                'is_active'    => $validated['is_active'] ?? $spec->is_active,
                'sort_order'   => $validated['sort_order'] ?? $spec->sort_order
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Specification updated successfully',
                'data'    => $spec->fresh()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update specification',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update all specifications
     */
    public function bulkUpdateSpecs(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'specifications'                  => 'required|array|min:1',
                'specifications.*.field_name'     => 'required|string|max:255',
                'specifications.*.display_name'   => 'required|string|max:255',
                'specifications.*.options'        => 'required|array|min:1',
                'specifications.*.options.*'      => 'required|string|max:255',
                'specifications.*.is_active'      => 'boolean',
                'specifications.*.sort_order'     => 'integer|min:0'
            ]);

            $updatedSpecs = [];

            foreach ($validated['specifications'] as $specData) {
                $spec = JopAdValues::where('field_name', $specData['field_name'])->first();
                if (!$spec) {
                    continue; // skip not found
                }

                $options = collect($specData['options'])
                    ->reject(fn($option) => strtolower($option) === 'other')
                    ->push('Other')
                    ->values()
                    ->toArray();

                $spec->update([
                    'display_name' => $specData['display_name'],
                    'options'      => $options,
                    'is_active'    => $specData['is_active'] ?? $spec->is_active,
                    'sort_order'   => $specData['sort_order'] ?? $spec->sort_order
                ]);

                $updatedSpecs[] = $spec->fresh();
            }

            return response()->json([
                'success' => true,
                'message' => 'Specifications updated successfully',
                'data'    => $updatedSpecs
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update specifications',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
