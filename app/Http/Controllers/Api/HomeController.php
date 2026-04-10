<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Book;

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

    public function booksByCategory($categoryId)
    {
        $books = Book::with('publisher','author','subCategory')->where('category_id', $categoryId)->where('is_active', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }
    public function bookDetails($id)
    {
        $book = Book::with('category','publisher','author','subCategory')->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }
}
