<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteLogo;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteLogoController extends Controller
{
    public function index()
    {
        return view('Modules.site_logo.index');
    }

    public function data(Request $request)
    {
        $logos = SiteLogo::query();

        return DataTables::of($logos)
            ->addIndexColumn()

            ->addColumn('logo', function ($logo) {
                return '<img src="' . asset($logo->logo_path) . '" class="h-10">';
            })

            ->addColumn('status', function ($logo) {
                return $logo->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($logo) {
                $logoJson = htmlspecialchars(json_encode($logo), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('site-logo.destroy', $logo->id);

                return '
                <div class="flex gap-2">

                    <button
                        onclick="openEditModal(siteLogoCrud, ' . $logoJson . ')"
                        class="px-2 py-1 text-[#003366]">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        class="text-red-600"
                        onclick="handleDelete({
                            id: ' . $logo->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#site-logo-table\',
                            text: \'This logo will be permanently deleted!\'
                        })">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>';
            })

            ->rawColumns(['logo', 'status', 'action'])
            ->make(true);
    }

    /**
     * Store logo
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'logo_path'      => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'alt_text'  => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        // deactivate old active logos
        if ($request->is_active) {
            SiteLogo::where('is_active', 1)->update(['is_active' => 0]);
        }

        $file = $request->file('logo_path');
        $filename = time() . '_site_logo.' . $file->getClientOriginalExtension();
        $file->storeAs('site-logo', $filename, 'public');

        $validated['logo_path'] = 'storage/site-logo/' . $filename;

        SiteLogo::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Site logo uploaded successfully'
        ]);
    }

    /**
     * Update logo
     */
    public function update(Request $request, SiteLogo $siteLogo)
    {
        $validated = $request->validate([
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'alt_text'  => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        if ($request->is_active) {
            SiteLogo::where('is_active', 1)
                ->where('id', '!=', $siteLogo->id)
                ->update(['is_active' => 0]);
        }

        if ($request->hasFile('logo')) {

            // delete old logo
            if (
                $siteLogo->logo_path &&
                Storage::disk('public')->exists(str_replace('storage/', '', $siteLogo->logo_path))
            ) {
                Storage::disk('public')->delete(str_replace('storage/', '', $siteLogo->logo_path));
            }

            $file = $request->file('logo');
            $filename = time() . '_site_logo.' . $file->getClientOriginalExtension();
            $file->storeAs('site-logo', $filename, 'public');

            $validated['logo_path'] = 'storage/site-logo/' . $filename;
        }

        $siteLogo->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Site logo updated successfully'
        ]);
    }

    /**
     * Delete logo
     */
    public function destroy(SiteLogo $siteLogo)
    {
        if (
            $siteLogo->logo_path &&
            Storage::disk('public')->exists(str_replace('storage/', '', $siteLogo->logo_path))
        ) {
            Storage::disk('public')->delete(str_replace('storage/', '', $siteLogo->logo_path));
        }

        $siteLogo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Site logo deleted successfully'
        ]);
    }
}
