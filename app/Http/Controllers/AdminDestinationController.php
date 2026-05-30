<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminDestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::orderBy('id', 'desc')->get();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Ruang Terbuka Hijau,Heritage,Aesthetic Cafe',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mrt_integrated' => 'nullable|boolean',
            'walkable' => 'nullable|boolean',
        ]);

        $data = $request->except('image');
        $data['mrt_integrated'] = $request->has('mrt_integrated');
        $data['walkable'] = $request->has('walkable');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            
            // Create directory if not exists
            if (!File::isDirectory(public_path('uploads/destinations'))) {
                File::makeDirectory(public_path('uploads/destinations'), 0755, true, true);
            }
            
            $image->move(public_path('uploads/destinations'), $filename);
            $data['image_path'] = 'uploads/destinations/' . $filename;
        }

        Destination::create($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi wisata berhasil ditambahkan.');
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Ruang Terbuka Hijau,Heritage,Aesthetic Cafe',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mrt_integrated' => 'nullable|boolean',
            'walkable' => 'nullable|boolean',
        ]);

        $data = $request->except('image');
        $data['mrt_integrated'] = $request->has('mrt_integrated');
        $data['walkable'] = $request->has('walkable');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($destination->image_path && File::exists(public_path($destination->image_path))) {
                File::delete(public_path($destination->image_path));
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('uploads/destinations'))) {
                File::makeDirectory(public_path('uploads/destinations'), 0755, true, true);
            }

            $image->move(public_path('uploads/destinations'), $filename);
            $data['image_path'] = 'uploads/destinations/' . $filename;
        }

        $destination->update($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi wisata berhasil diperbarui.');
    }

    public function destroy(Destination $destination)
    {
        if ($destination->image_path && File::exists(public_path($destination->image_path))) {
            File::delete(public_path($destination->image_path));
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi wisata berhasil dihapus.');
    }
}
