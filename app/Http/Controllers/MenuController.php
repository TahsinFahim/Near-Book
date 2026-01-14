<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        return view('Modules.menus.index');
    }

  public function data(Request $request)
{
    $menus = Menu::with('submenus');
    
    // Get the filter value from request
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
        ->addColumn('submenus', function ($menu) {
            if ($menu->submenus->count() == 0) {
                return '<span class="text-muted">No Submenu</span>';
            }

            return $menu->submenus
                ->pluck('name')
                ->implode(', ');
        })
        ->addColumn('action', function ($menu) {
            $menuJson = htmlspecialchars(json_encode($menu), ENT_QUOTES, 'UTF-8');
            $deleteRoute = route('menus.destroy', $menu->id);

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
                    table: \'#menu-table\',
                    text: \'This menu will be permanently deleted!\'
                })">
                <i class="fa fa-trash"></i>
            </button>

            <!-- Submenu -->
            <a href="' . url('/submenus/' . $menu->id) . '"
                class="px-2 py-1 bg-[#003366] text-white rounded text-sm">
                Add Sub Menus
            </a>
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
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        Menu::create($request->all());

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'url'      => 'nullable|string',
            'icon'     => 'nullable|string',
            'order_by' => 'required|integer',
            'status'   => 'required|boolean',
        ]);

        $menu->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Menu updated successfully'
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu deleted successfully'
        ]);
    }
}
