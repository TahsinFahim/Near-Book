<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function index($id)
    {
        // $id = category_id
        return view('Modules.sub-categories.index', compact('id'));
    }

    public function data($id, Request $request)
    {
        $categories = SubCategory::where('category_id', $id);
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
                return $category->is_active == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($category) {

                $categoryJson = htmlspecialchars(json_encode($category), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('sub-categories.destroy', ':id');

                return '
                <div class="flex justify-start gap-2">

                    <!-- Edit -->
                    <button
                        onclick="openEditModal(subCategoryCrud, ' . $categoryJson . ')"
                        class="px-2 py-1 text-[#003366] rounded text-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Delete -->
                    <button
                        class="delete-btn text-red-600"
                        onclick="handleDelete({
                            id: ' . $category->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#sub-category-table\',
                            text: \'This sub category will be permanently deleted!\'
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
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:sub_categories,slug',
            'description' => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        SubCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sub category created successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:sub_categories,slug,' . $id,
            'description' => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        $subCategory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sub category updated successfully',
            'data'    => $subCategory,
        ]);
    }

    public function destroy($id)
    {
        SubCategory::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sub category deleted successfully',
        ]);
    }
}
