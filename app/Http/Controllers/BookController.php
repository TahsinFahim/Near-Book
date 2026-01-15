<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
    public function index()
    {

        $authors = Author::where('is_active', 1)->get(['id', 'name']);
        $categories = Category::where('is_active', 1)->get(['id', 'name']);
        return view('Modules.books.index', compact('authors', 'categories'));
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
            'category_id'       => 'required|integer',
            'sub_category_id'    => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'publication_date'  => 'nullable|date',
            'publisher'         => 'nullable|string|max:255',
            'is_active'         => 'required|boolean',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
        ]);
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
           $file->storeAs('covers', $filename, 'public');


            $validated['cover_image'] = '/storage/covers/' . $filename;
        }
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
        'category_id'       => 'required|integer',
        'sub_category_id'   => 'required|integer',
        'cover_image'       => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        'short_description' => 'nullable|string',
        'description'       => 'nullable|string',
        'publication_date'  => 'nullable|date',
        'publisher'         => 'nullable|string|max:255',
        'is_active'         => 'required|boolean',
        'meta_title'        => 'nullable|string|max:255',
        'meta_description'  => 'nullable|string|max:255',
    ]);

    // Image upload handle
    if ($request->hasFile('cover_image')) {
        // Delete old image if exists
        if ($book->cover_image) {
            $oldPath = str_replace('/storage/', 'public/', $book->cover_image);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }

        $file = $request->file('cover_image');
        $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
       $file->storeAs('covers', $filename, 'public');

        $validated['cover_image'] = '/storage/covers/' . $filename;
    } else {
        // যদি image update না হয়, remove key to keep old image
        unset($validated['cover_image']);
    }

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
