<?php

namespace App\Http\Controllers;

use App\Models\SearchIndex;
use Illuminate\Http\Request;

class SmartSearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $keyword = $request->keyword;

        $results = SearchIndex::query()
            ->where('title', 'like', "%{$keyword}%")
            ->select('item_type')
            ->selectRaw('COUNT(*) as total_ads')
            ->groupBy('item_type')
            ->get();

        return response()->json([
            'keyword' => $keyword,
            'results' => $results
        ]);
    }
}
