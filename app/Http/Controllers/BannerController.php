<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        return view('Modules.banners.index');
    }

    public function data(Request $request)
    {
        $banners = Banner::query();

        return DataTables::of($banners)
            ->addIndexColumn()
            ->addColumn('image', function ($banner) {
                return '<img src="' . asset($banner->image_path) . '" class="h-16">';
            })
            ->addColumn('status', function ($banner) {
                return $banner->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($banner) {
                $bannerJson = htmlspecialchars(json_encode($banner), ENT_QUOTES, 'UTF-8');
                $deleteRoute = route('banners.destroy', $banner->id);

                return '
                <div class="flex gap-2">
                    <button
                        onclick="openEditModal(bannerCrud, ' . $bannerJson . ')"
                        class="px-2 py-1 text-[#003366]">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        class="text-red-600"
                        onclick="handleDelete({
                            id: ' . $banner->id . ',
                            route: \'' . $deleteRoute . '\',
                            table: \'#banner-table\',
                            text: \'This banner will be permanently deleted!\'
                        })">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'nullable|string|max:255',
            'subtitle'   => 'nullable|string|max:255',
            'link'       => 'nullable|url|max:255',
            'image_path'      => 'required|image|mimes:jpeg,jpg,png,webp,svg|max:4096',
            'is_active'  => 'required|boolean',
        ]);

        if ($request->is_active) {
            Banner::where('is_active', 1)->update(['is_active' => 0]);
        }

        $file = $request->file('image_path');
        $filename = time() . '_banner.' . $file->getClientOriginalExtension();
        $file->storeAs('banners', $filename, 'public');

        $validated['image_path'] = 'storage/banners/' . $filename;

        Banner::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Banner created successfully'
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'      => 'nullable|string|max:255',
            'subtitle'   => 'nullable|string|max:255',
            'link'       => 'nullable|url|max:255',
            'image'      => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:4096',
            'is_active'  => 'required|boolean',
        ]);

       

        if ($request->hasFile('image')) {
            // delete old image
            if ($banner->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $banner->image_path));
            }

            $file = $request->file('image');
            $filename = time() . '_banner.' . $file->getClientOriginalExtension();
            $file->storeAs('banners', $filename, 'public');

            $validated['image_path'] = 'storage/banners/' . $filename;
        }

        $banner->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Banner updated successfully'
        ]);
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $banner->image_path));
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully'
        ]);
    }
}
