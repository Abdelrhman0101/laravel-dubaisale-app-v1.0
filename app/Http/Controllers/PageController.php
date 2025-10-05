<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function index()
    {
        $pages = Page::where('is_active', true)->get();
        return response()->json($pages);
    }


    public function show($type)
    {
        $page = Page::where('type', $type)->where('is_active', true)->get();
        return response()->json($page);
    }
}
