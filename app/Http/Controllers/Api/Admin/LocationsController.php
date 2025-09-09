<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    private const SETTING_KEY = 'locations_emirates';

    /**
     * [Admin] Get all emirates with their districts.
     */
    public function index(): JsonResponse
    {
        [$emirates, $setting] = $this->getEmiratesSetting();
        return response()->json([
            'key' => $setting->key,
            'type' => $setting->type,
            'description' => $setting->description,
            'data' => $emirates,
        ]);
    }

    /**
     * [Admin] Create or update an emirate with optional districts.
     * If emirate exists, districts will be merged (deduplicated) unless replace=true is provided.
     */
    public function upsertEmirate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'display_name' => 'sometimes|nullable|string|max:150',
            'districts' => 'sometimes|array',
            'districts.*' => 'required|string|max:120',
            'replace' => 'sometimes|boolean',
        ]);

        $name = $this->normalizeName($validated['name']);
        $displayName = isset($validated['display_name']) ? trim($validated['display_name']) : $name;
        $newDistricts = collect($validated['districts'] ?? [])->map(fn ($d) => $this->normalizeName($d))->values()->all();
        $replace = (bool)($validated['replace'] ?? false);

        [$emirates, $setting] = $this->getEmiratesSetting();

        // Find existing emirate (case-insensitive)
        $index = $this->findEmirateIndex($emirates, $name);
        if ($index === -1) {
            $emirates[] = [
                'name' => $name,
                'display_name' => $displayName,
                'districts' => array_values(array_unique($newDistricts)),
            ];
        } else {
            $current = $emirates[$index];
            $current['display_name'] = $displayName;
            if ($replace) {
                $current['districts'] = array_values(array_unique($newDistricts));
            } else {
                $merged = array_merge($current['districts'] ?? [], $newDistricts);
                $current['districts'] = array_values(array_unique(array_map(fn ($d) => $this->normalizeName($d), $merged)));
            }
            $emirates[$index] = $current;
        }

        $this->saveEmiratesSetting($setting, $emirates);

        return response()->json([
            'message' => 'Emirate saved successfully.',
            'data' => $emirates,
        ], 201);
    }

    /**
     * [Admin] Add or update districts for a specific emirate (merge by default).
     */
    public function upsertDistricts(Request $request, string $emirate): JsonResponse
    {
        $validated = $request->validate([
            'districts' => 'required|array|min:1',
            'districts.*' => 'required|string|max:120',
            'replace' => 'sometimes|boolean',
        ]);

        $name = $this->normalizeName($emirate);
        $newDistricts = collect($validated['districts'])->map(fn ($d) => $this->normalizeName($d))->values()->all();
        $replace = (bool)($validated['replace'] ?? false);

        [$emirates, $setting] = $this->getEmiratesSetting();
        $index = $this->findEmirateIndex($emirates, $name);

        if ($index === -1) {
            return response()->json([
                'message' => 'Emirate not found.'
            ], 404);
        }

        $current = $emirates[$index];
        if ($replace) {
            $current['districts'] = array_values(array_unique($newDistricts));
        } else {
            $merged = array_merge($current['districts'] ?? [], $newDistricts);
            $current['districts'] = array_values(array_unique(array_map(fn ($d) => $this->normalizeName($d), $merged)));
        }
        $emirates[$index] = $current;

        $this->saveEmiratesSetting($setting, $emirates);

        return response()->json([
            'message' => 'Districts saved successfully.',
            'data' => $current,
        ]);
    }

    /**
     * [Admin] Delete a district from an emirate.
     */
    public function deleteDistrict(Request $request, string $emirate): JsonResponse
    {
        $validated = $request->validate([
            'district' => 'required|string|max:120',
        ]);

        $name = $this->normalizeName($emirate);
        $district = $this->normalizeName($validated['district']);

        [$emirates, $setting] = $this->getEmiratesSetting();
        $index = $this->findEmirateIndex($emirates, $name);
        if ($index === -1) {
            return response()->json(['message' => 'Emirate not found.'], 404);
        }

        $current = $emirates[$index];
        $current['districts'] = array_values(array_filter($current['districts'] ?? [], function ($d) use ($district) {
            return mb_strtolower($d) !== mb_strtolower($district);
        }));
        $emirates[$index] = $current;

        $this->saveEmiratesSetting($setting, $emirates);

        return response()->json([
            'message' => 'District deleted successfully.',
            'data' => $current,
        ]);
    }

    /**
     * [Admin] Rename emirate.
     */
    public function renameEmirate(Request $request, string $emirate): JsonResponse
    {
        $validated = $request->validate([
            'new_name' => 'required|string|max:100',
            'display_name' => 'sometimes|nullable|string|max:150',
        ]);

        $oldName = $this->normalizeName($emirate);
        $newName = $this->normalizeName($validated['new_name']);
        $displayName = isset($validated['display_name']) ? trim($validated['display_name']) : $newName;

        [$emirates, $setting] = $this->getEmiratesSetting();
        $index = $this->findEmirateIndex($emirates, $oldName);
        if ($index === -1) {
            return response()->json(['message' => 'Emirate not found.'], 404);
        }

        // Prevent duplicate emirate names after renaming
        $dupIndex = $this->findEmirateIndex($emirates, $newName);
        if ($dupIndex !== -1 && $dupIndex !== $index) {
            return response()->json(['message' => 'Another emirate with the same name already exists.'], 409);
        }

        $emirates[$index]['name'] = $newName;
        $emirates[$index]['display_name'] = $displayName;

        $this->saveEmiratesSetting($setting, $emirates);

        return response()->json([
            'message' => 'Emirate renamed successfully.',
            'data' => $emirates[$index],
        ]);
    }

    // ================= Helpers =================

    private function getEmiratesSetting(): array
    {
        $setting = SystemSetting::firstOrCreate(
            ['key' => self::SETTING_KEY],
            [
                'value' => '[]',
                'type' => 'json',
                'description' => 'List of UAE emirates and their districts for locations management.',
            ]
        );

        $decoded = json_decode($setting->value ?: '[]', true);
        if (!is_array($decoded)) { $decoded = []; }

        // Normalize internal shape
        $normalized = [];
        foreach ($decoded as $item) {
            $normalized[] = [
                'name' => isset($item['name']) ? $this->normalizeName($item['name']) : null,
                'display_name' => isset($item['display_name']) && $item['display_name'] !== '' ? $item['display_name'] : (isset($item['name']) ? $this->normalizeName($item['name']) : ''),
                'districts' => array_values(array_unique(array_map(fn ($d) => $this->normalizeName($d), (array)($item['districts'] ?? [])))),
            ];
        }

        // Remove null/invalid entries
        $normalized = array_values(array_filter($normalized, fn ($e) => !empty($e['name'])));

        return [$normalized, $setting];
    }

    private function saveEmiratesSetting(SystemSetting $setting, array $emirates): void
    {
        $setting->value = json_encode(array_values($emirates), JSON_UNESCAPED_UNICODE);
        $setting->save();
    }

    private function findEmirateIndex(array $emirates, string $name): int
    {
        foreach ($emirates as $i => $e) {
            if (mb_strtolower($e['name']) === mb_strtolower($name)) {
                return $i;
            }
        }
        return -1;
    }

    private function normalizeName(string $name): string
    {
        $name = trim($name);
        // Title case for Latin words, keep Arabic as-is
        $name = preg_replace_callback('/([A-Za-z][A-Za-z\s\'-]*)/u', function ($m) {
            return ucwords(strtolower($m[1]));
        }, $name);
        return $name;
    }
}