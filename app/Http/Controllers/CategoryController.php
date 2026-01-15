<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    // Show categories page
    public function index()
    {
        return view('Modules.categories.index');
    }

    public function subCategories($categoryId)
{
    return response()->json(
        SubCategory::where('category_id', $categoryId)
            ->select('id', 'name')
            ->get()
    );
}


    // Fetch data for DataTables
    public function data(Request $request)
    {
        $categories = Category::query();

        // Get filter from request
        $filter = $request->input('filter', 'active');

        switch ($filter) {
            case 'active':
                $categories->where('is_active', 1);
                break;

            case 'inactive':
                $categories->where('is_active', 0);
                break;

            case 'latest':
                $categories->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
                $categories->orderBy('created_at', 'ASC');
                break;

            default:
                $categories->orderBy('created_at', 'ASC');
                break;
        }

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('status', function ($category) {
                return $category->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($category) {
                $categoryJson = htmlspecialchars(json_encode($category), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('categories.destroy', $category->id);

                return '
                <div class="flex justify-start gap-2">
                    <!-- Edit -->
                    <button
                        onclick="openEditModal(categoryCrud, ' . $categoryJson . ')"
                        class="px-2 py-1 text-[#003366] rounded text-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Delete -->
                    <button
                        class="delete-btn text-red-600"
                        onclick="handleDelete({
                            id: ' . $category->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#category-table\',
                            text: \'This category will be permanently deleted!\'
                        })">
                        <i class="fa fa-trash"></i>
                    </button>

                     <a href="' . url('/sub-categories/' . $category->id) . '"
                class="px-2 py-1 bg-[#003366] text-white rounded text-sm">
                Add Sub Categories
            </a>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'required|boolean',
        ]);

        Category::create($request->all());

        return response()->json(['success' => true]);
    }

    // Update existing category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'required|boolean',
        ]);

        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
        ]);
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}
