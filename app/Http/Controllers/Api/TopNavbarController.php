<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopNavbar;
use App\Models\Category;

class TopNavbarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    // Get active navbar items sorted by position
    $navbars = TopNavbar::orderBy('position', 'ASC')->get();

    // Transform each row to include all required fields
    $result = $navbars->map(function($item) {
        return [
            'id'       => $item->id,
            'name'     => $item->name,   // internal key
            'title'    => $item->label,  // visible text
            'url'      => $item->url,
            'position' => $item->position,
            'status'   => $item->is_active ? 'Active' : 'Inactive',
        ];
    });

    return response()->json([
        'success' => true,
        'data'    => $result
    ]);
}

public function categoris()
{
    $categories = Category::with('subCategories')->where('is_active', 1)
        // ->orderBy('position', 'ASC')
        ->get();

    return response()->json([
        'success' => true,
        'data'    => $categories
    ]);

  
}

}
