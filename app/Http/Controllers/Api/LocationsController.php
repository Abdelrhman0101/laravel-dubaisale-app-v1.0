<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    private const SETTING_KEY = 'locations_emirates';

    /**
     * [Public] Read-only endpoint: returns emirates with their districts for clients.
     */
    public function index(): JsonResponse
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

        $emirates = [];
        foreach ($decoded as $item) {
            $emirates[] = [
                'name' => isset($item['name']) ? $this->normalizeName($item['name']) : null,
                'display_name' => isset($item['display_name']) && $item['display_name'] !== ''
                    ? $item['display_name']
                    : (isset($item['name']) ? $this->normalizeName($item['name']) : ''),
                'districts' => array_values(array_unique(array_map(fn ($d) => $this->normalizeName($d), (array)($item['districts'] ?? [])))),
            ];
        }

        // Remove invalid entries (missing name)
        $emirates = array_values(array_filter($emirates, fn ($e) => !empty($e['name'])));

        return response()->json([
            'emirates' => $emirates,
        ]);
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