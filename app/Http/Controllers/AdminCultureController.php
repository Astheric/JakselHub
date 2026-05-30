<?php

namespace App\Http\Controllers;

use App\Models\CultureGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminCultureController extends Controller
{
    public function index()
    {
        $galleries = CultureGallery::orderBy('id', 'desc')->get();
        return view('admin.cultures.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.cultures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Kesenian,Festival,Event',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('uploads/cultures'))) {
                File::makeDirectory(public_path('uploads/cultures'), 0755, true, true);
            }
            
            $image->move(public_path('uploads/cultures'), $filename);
            $data['image_path'] = 'uploads/cultures/' . $filename;
        }

        CultureGallery::create($data);

        return redirect()->route('admin.cultures.index')->with('success', 'Konten budaya berhasil ditambahkan.');
    }

    public function edit(CultureGallery $culture)
    {
        return view('admin.cultures.edit', compact('culture'));
    }

    public function update(Request $request, CultureGallery $culture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Kesenian,Festival,Event',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($culture->image_path && File::exists(public_path($culture->image_path))) {
                File::delete(public_path($culture->image_path));
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('uploads/cultures'))) {
                File::makeDirectory(public_path('uploads/cultures'), 0755, true, true);
            }

            $image->move(public_path('uploads/cultures'), $filename);
            $data['image_path'] = 'uploads/cultures/' . $filename;
        }

        $culture->update($data);

        return redirect()->route('admin.cultures.index')->with('success', 'Konten budaya berhasil diperbarui.');
    }

    public function destroy(CultureGallery $culture)
    {
        if ($culture->image_path && File::exists(public_path($culture->image_path))) {
            File::delete(public_path($culture->image_path));
        }

        $culture->delete();

        return redirect()->route('admin.cultures.index')->with('success', 'Konten budaya berhasil dihapus.');
    }
}
