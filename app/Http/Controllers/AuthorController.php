<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Yajra\DataTables\Facades\DataTables;

class AuthorController extends Controller
{
    public function index()
    {
        return view('Modules.authors.index');
    }

    public function data(Request $request)
    {
        // Start query
        $authors = Author::query();

        // Filter
        $filter = $request->input('filter', 'active');

        switch ($filter) {
            case 'active':
                $authors->where('is_active', 1);
                break;

            case 'inactive':
                $authors->where('is_active', 0);
                break;

            case 'latest':
                $authors->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
                $authors->orderBy('created_at', 'ASC');
                break;

            default:
                $authors->orderBy('created_at', 'ASC');
                break;
        }

        return DataTables::of($authors)
            ->addIndexColumn()

            ->addColumn('status', function ($author) {
                return $author->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($author) {
                $authorJson = htmlspecialchars(json_encode($author), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('authors.destroy', $author->id);

                return '
                <div class="flex justify-start gap-2">

                    <!-- Edit -->
                    <button
                        onclick="openEditModal(authorCrud, ' . $authorJson . ')"
                        class="px-2 py-1 text-[#003366] rounded text-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Delete -->
                    <button
                        class="delete-btn text-red-600"
                        onclick="handleDelete({
                            id: ' . $author->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#author-table\',
                            text: \'This author will be permanently deleted!\'
                        })">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>
                ';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:authors,slug',
            'email'            => 'nullable|email',
            'phone'            => 'nullable|string|max:20',
            'nationality'      => 'nullable|string|max:100',
            'date_of_birth'    => 'nullable|date',
            'photo'            => 'nullable|string',
            'short_bio'        => 'nullable|string',
            'biography'        => 'nullable|string',
            'is_active'        => 'required|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        Author::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully'
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:authors,slug,' . $author->id,
            'email'            => 'nullable|email',
            'phone'            => 'nullable|string|max:20',
            'nationality'      => 'nullable|string|max:100',
            'date_of_birth'    => 'nullable|date',
            'photo'            => 'nullable|string',
            'short_bio'        => 'nullable|string',
            'biography'        => 'nullable|string',
            'is_active'        => 'required|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $author->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully'
        ]);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }
}
