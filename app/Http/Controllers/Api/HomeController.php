<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class HomeController extends Controller
{
    public function banner()
    {
        $banner = Banner::all(); 
        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }
}
