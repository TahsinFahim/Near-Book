<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class PublisherController extends Controller
{
    public function index()
    {
        return view('Modules.publishers.index');
    }

    public function data(Request $request)
    {
        // Start query
        $publishers = Publisher::query();

        // Filter
        $filter = $request->input('filter', 'active');

        switch ($filter) {
            case 'active':
                $publishers->where('is_active', 1);
                break;

            case 'inactive':
                $publishers->where('is_active', 0);
                break;

            case 'latest':
                $publishers->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
                $publishers->orderBy('created_at', 'ASC');
                break;

            default:
                $publishers->orderBy('created_at', 'ASC');
                break;
        }

        return DataTables::of($publishers)
            ->addIndexColumn()

            ->addColumn('status', function ($publisher) {
                return $publisher->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($publisher) {
                $publisherJson = htmlspecialchars(json_encode($publisher), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('publishers.destroy', $publisher->id);

                return '
                <div class="flex justify-start gap-2">

                    <!-- Edit -->
                    <button
                        onclick="openEditModal(publisherCrud, ' . $publisherJson . ')"
                        class="px-2 py-1 text-[#003366] rounded text-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Delete -->
                    <button
                        class="delete-btn text-red-600"
                        onclick="handleDelete({
                            id: ' . $publisher->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#publisher-table\',
                            text: \'This publisher will be permanently deleted!\'
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
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:publishers,slug',
        'email'       => 'nullable|email',
        'phone'       => 'nullable|string|max:20',
        'address'     => 'nullable|string',
        'website'     => 'nullable|string|max:255',
        'logo'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'description' => 'nullable|string',
        'is_active'   => 'required|boolean',
    ]);

    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

        $file->storeAs('publishers', $filename, 'public');

        $validated['logo'] = 'storage/publishers/' . $filename;
    }

    Publisher::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Publisher created successfully'
    ]);
}


   public function update(Request $request, Publisher $publisher)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'slug'        => 'required|string|max:255|unique:publishers,slug,' . $publisher->id,
        'email'       => 'nullable|email',
        'phone'       => 'nullable|string|max:20',
        'address'     => 'nullable|string',
        'website'     => 'nullable|string|max:255',
        'logo'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        'description' => 'nullable|string',
        'is_active'   => 'required|boolean',
    ]);

    if ($request->hasFile('logo')) {

        // 🔥 old image delete
        if ($publisher->logo && Storage::disk('public')->exists(str_replace('storage/', '', $publisher->logo))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $publisher->logo));
        }

        $file = $request->file('logo');
        $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('publishers', $filename, 'public');

        $validated['logo'] = 'storage/publishers/' . $filename;
    }

    $publisher->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Publisher updated successfully'
    ]);
}


    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Publisher deleted successfully'
        ]);
    }
}
