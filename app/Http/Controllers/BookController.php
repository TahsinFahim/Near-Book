<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
  public function index()
{

    $authors = Author::where('is_active', 1)->get(['id', 'name']);
    return view('Modules.books.index', compact('authors'));
}


   public function data(Request $request)
{ 
    $books = Book::with('author');

    // Existing status/date filters
     $filter = $request->input('filter', 'active');

        switch ($filter) {
            case 'active':
                $books->where('is_active', 1);
                break;

            case 'inactive':
                $books->where('is_active', 0);
                break;

            case 'latest':
                $books->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
               $books->orderBy('created_at', 'ASC');
                break;

            default:
                $books->orderBy('created_at', 'ASC');
                break;
        }

    // ✅ New: Filter by author
    if ($request->filled('author_id')) {
        $books->where('author_id', $request->author_id);
    }

    return DataTables::of($books)
        ->addIndexColumn()
        ->addColumn('author', fn($book) => $book->author?->name ?? 'N/A')
        ->addColumn('status', fn($book) => $book->is_active
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>')
        ->addColumn('action', function ($book) {
            $bookJson = htmlspecialchars(json_encode($book), ENT_QUOTES, 'UTF-8');
            $deleteRoute = route('books.destroy', $book->id);

            return '
                <div class="flex justify-start gap-2">
                    <button onclick="openEditModal(bookCrud,' . $bookJson . ')" class="px-2 py-1 text-[#003366] rounded text-sm"><i class="fa fa-edit"></i></button>
                    <button class="delete-btn text-red-600" onclick="handleDelete({id: ' . $book->id . ', route: \'' . $deleteRoute . '\', table: \'#book-table\', text: \'This book will be permanently deleted!\'})"><i class="fa fa-trash"></i></button>
                </div>
            ';
        })
        ->rawColumns(['author', 'status', 'action'])
        ->make(true);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:books,slug',
            'author_id'         => 'required|exists:authors,id',
            'isbn'              => 'nullable|string|max:50',
            'price'             => 'nullable|numeric',
            'stock'             => 'nullable|integer',
            'cover_image'       => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'publication_date'  => 'nullable|date',
            'publisher'         => 'nullable|string|max:255',
            'is_active'         => 'required|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
        ]);

        Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully'
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:books,slug,' . $book->id,
            'author_id'         => 'required|exists:authors,id',
            'isbn'              => 'nullable|string|max:50',
            'price'             => 'nullable|numeric',
            'stock'             => 'nullable|integer',
            'cover_image'       => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'publication_date'  => 'nullable|date',
            'publisher'         => 'nullable|string|max:255',
            'is_active'         => 'required|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully'
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    }
}
