<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;
use Yajra\DataTables\Facades\DataTables;

class ContactInfoController extends Controller
{
    public function index()
    {
        return view('Modules.contact_info.index');
    }

    public function data(Request $request)
    {
        $infos = ContactInfo::query();

        return DataTables::of($infos)
            ->addIndexColumn()
            ->addColumn('status', function ($info) {
                return $info->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($info) {
                $infoJson = htmlspecialchars(json_encode($info), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('contact-info.destroy', $info->id);

                return '
                <div class="flex gap-2">
                    <button
                        onclick="openEditModal(contactInfoCrud, ' . $infoJson . ')"
                        class="px-2 py-1 text-[#003366]">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        class="text-red-600"
                        onclick="handleDelete({
                            id: ' . $info->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#contact-info-table\',
                            text: \'This contact info will be permanently deleted!\'
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
            'phone'     => 'nullable|string|max:20',
            'whatsapp'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter'   => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'youtube'   => 'nullable|url|max:255',
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active) {
            ContactInfo::where('is_active', 1)->update(['is_active' => 0]);
        }

        ContactInfo::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contact info created successfully'
        ]);
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        $validated = $request->validate([
            'phone'     => 'nullable|string|max:20',
            'whatsapp'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter'   => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'youtube'   => 'nullable|url|max:255',
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active) {
            ContactInfo::where('is_active', 1)
                ->where('id', '!=', $contactInfo->id)
                ->update(['is_active' => 0]);
        }

        $contactInfo->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contact info updated successfully'
        ]);
    }

    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact info deleted successfully'
        ]);
    }
}
