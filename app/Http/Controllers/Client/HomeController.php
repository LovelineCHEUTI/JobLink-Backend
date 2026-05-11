<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function categories(Request $request)
    {
        \Log::info('Token reçu: ' . $request->bearerToken());
        
        $categories = Category::where('is_active', true)->get();

        return response()->json($categories);
    }
}