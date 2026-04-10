<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('Modules.departments.index');
    }

    public function data(Request $request)
    {
        $departments = Department::query();

        return DataTables::of($departments)
            ->addIndexColumn()
            ->addColumn('status', function ($department) {
                return $department->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($department) {
                $departmentJson = htmlspecialchars(json_encode($department), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('departments.destroy', $department->id);

                return '
                <div class="flex gap-2">
                    <button
                        onclick="openEditModal(departmentCrud, ' . $departmentJson . ')"
                        class="px-2 py-1 text-[#003366]">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        class="text-red-600"
                        onclick="handleDelete({
                            id: ' . $department->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#department-table\',
                            text: \'This department will be permanently deleted!\'
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
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:departments,code',
            'faculty'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        Department::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully'
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:departments,code,' . $department->id,
            'faculty'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        $department->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully'
        ]);
    }
}
