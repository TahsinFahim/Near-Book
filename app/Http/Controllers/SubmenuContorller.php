<?php

namespace App\Http\Controllers;

use App\Models\Submenu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubmenuContorller extends Controller
{
    public function index($id)
    {
        return view('Modules.submenus.index', compact('id'));
    }


    public function data($id, Request $request)
    {
        $menus = Submenu::where('menu_id', $id);
        $filter = $request->input('filter', 'active');

        // Apply filter based on selection
        switch ($filter) {
            case 'active':
                $menus->where('status', 1);
                break;

            case 'inactive':
                $menus->where('status', 0);
                break;

            case 'latest':
                $menus->orderBy('created_at', 'DESC');
                break;

            case 'oldest':
                $menus->orderBy('created_at', 'ASC');
                break;

            default:
                // Default: show active and order by latest
                $menus->orderBy('created_at', 'ASC');
                break;
        }


        return DataTables::of($menus)
            ->addIndexColumn()

            ->addColumn('status', function ($menu) {
                return $menu->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })




            ->addColumn('action', function ($menu) {

                $menuJson = htmlspecialchars(json_encode($menu), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('menus.destroy', ':id');

                return '
        <div class="flex justify-start gap-2">

            <!-- Edit -->
            <button
                onclick="openEditModal(menuCrud, ' . $menuJson . ')"
                class="px-2 py-1 text-[#003366] rounded text-sm">
                <i class="fa fa-edit"></i>
            </button>

            <!-- Delete -->
            <button
                class="delete-btn text-red-600"
                onclick="handleDelete({
                    id: ' . $menu->id . ',
                    route: \'' . $deleteRoute . '\',
                    table: \'#submenu-table\',
                    text: \'This menu will be permanently deleted!\'
                })">
                <i class="fa fa-trash"></i>
            </button>

            

        </div>
    ';
            })


            ->filterColumn('submenus', function ($query, $keyword) {
                $query->whereHas('submenus', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    { 
        // Validate request data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'menu_id'     => 'required',
            'url'      => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
            'status'   => 'required|boolean',
        ]);

        // Create submenu
        Submenu::create($validated);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Submenu created successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        // Find the submenu by id
        $submenu = Submenu::findOrFail($id);

        // Validate request data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'url'      => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
            'status'   => 'required|boolean',
        ]);

        // Update submenu
        $submenu->update($validated);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Submenu updated successfully',
            'data'    => $submenu
        ]);
    }
}
