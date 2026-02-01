<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopNavbar;
use Yajra\DataTables\Facades\DataTables;

class TopNavbarController extends Controller
{
    public function index()
    {
        return view('Modules.top_navbar.index');
    }

    public function data(Request $request)
    {
        $navbars = TopNavbar::query();

        return DataTables::of($navbars)
            ->addIndexColumn()
            ->addColumn('status', function ($item) {
                return $item->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($item) {
                $itemJson = htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('top-navbar.destroy', $item->id);

                return '
                <div class="flex gap-2">
                    <button
                        onclick="openEditModal(topNavbarCrud, ' . $itemJson . ')"
                        class="px-2 py-1 text-[#003366]">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        class="text-red-600"
                        onclick="handleDelete({
                            id: ' . $item->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#top-navbar-table\',
                            text: \'This navbar item will be permanently deleted!\'
                        })">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:top_navbar,name',
            'label'     => 'required|string|max:255',
            'url'       => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'position'  => 'nullable|integer',
        ]);

        TopNavbar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Navbar item created successfully'
        ]);
    }

    public function update(Request $request, TopNavbar $topNavbar)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:top_navbar,name,' . $topNavbar->id,
            'label'     => 'required|string|max:255',
            'url'       => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'position'  => 'nullable|integer',
        ]);

        $topNavbar->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Navbar item updated successfully'
        ]);
    }

    public function destroy(TopNavbar $topNavbar)
    {
        $topNavbar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Navbar item deleted successfully'
        ]);
    }
}
