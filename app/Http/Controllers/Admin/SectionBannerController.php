<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SectionBannerController extends Controller
{
    public function index()
    {
        $banners = SectionBanner::all()->groupBy('category');
        return view('section-banners', compact('banners'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'lang' => 'required|in:ar,en',
            'type' => 'required|in:main,detail', // e.g., main screen or detail screen
            'content_type' => 'required|in:image,text',
            'image' => 'required_if:content_type,image|image|max:2048',
            'text' => 'required_if:content_type,text|string|nullable',
            'text_color' => 'nullable|string',
            'background_color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = [
            'category' => $request->category,
            'lang' => $request->lang,
            'type' => $request->type,
            'content_type' => $request->content_type,
        ];

        // Handle Image Upload
        if ($request->content_type === 'image' && $request->hasFile('image')) {
            // Delete old image if exists
            $existing = SectionBanner::where([
                'category' => $request->category,
                'lang' => $request->lang,
                'type' => $request->type
            ])->first();

            if ($existing && $existing->content_type === 'image') {
                Storage::disk('public')->delete($existing->content);
            }

            $path = $request->file('image')->store('section-banners', 'public');
            $data['content'] = $path;
            $data['style_options'] = null;
        } 
        // Handle Text
        else {
            $data['content'] = $request->text;
            $data['style_options'] = [
                'color' => $request->text_color,
                'background_color' => $request->background_color
            ];
        }

        $banner = SectionBanner::updateOrCreate(
            [
                'category' => $request->category,
                'lang' => $request->lang,
                'type' => $request->type
            ],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Banner updated successfully',
            'data' => $banner,
            'image_url' => $banner->content_type === 'image' ? Storage::url($banner->content) : null
        ]);
    }

    public function destroy(Request $request)
    {
        $banner = SectionBanner::where([
            'category' => $request->category,
            'lang' => $request->lang,
            'type' => $request->type
        ])->first();

        if ($banner) {
            if ($banner->content_type === 'image') {
                Storage::disk('public')->delete($banner->content);
            }
            $banner->delete();
            return response()->json(['success' => true, 'message' => 'Banner deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Banner not found'], 404);
    }
}
