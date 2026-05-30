<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminTimelineController extends Controller
{
    public function index()
    {
        $timelines = Timeline::orderBy('order', 'asc')->get();
        return view('admin.timelines.index', compact('timelines'));
    }

    public function create()
    {
        return view('admin.timelines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('uploads/timelines'))) {
                File::makeDirectory(public_path('uploads/timelines'), 0755, true, true);
            }
            
            $image->move(public_path('uploads/timelines'), $filename);
            $data['image_path'] = 'uploads/timelines/' . $filename;
        }

        Timeline::create($data);

        return redirect()->route('admin.timelines.index')->with('success', 'Milestone sejarah berhasil ditambahkan.');
    }

    public function edit(Timeline $timeline)
    {
        return view('admin.timelines.edit', compact('timeline'));
    }

    public function update(Request $request, Timeline $timeline)
    {
        $request->validate([
            'year' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($timeline->image_path && File::exists(public_path($timeline->image_path))) {
                File::delete(public_path($timeline->image_path));
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('uploads/timelines'))) {
                File::makeDirectory(public_path('uploads/timelines'), 0755, true, true);
            }

            $image->move(public_path('uploads/timelines'), $filename);
            $data['image_path'] = 'uploads/timelines/' . $filename;
        }

        $timeline->update($data);

        return redirect()->route('admin.timelines.index')->with('success', 'Milestone sejarah berhasil diperbarui.');
    }

    public function destroy(Timeline $timeline)
    {
        if ($timeline->image_path && File::exists(public_path($timeline->image_path))) {
            File::delete(public_path($timeline->image_path));
        }

        $timeline->delete();

        return redirect()->route('admin.timelines.index')->with('success', 'Milestone sejarah berhasil dihapus.');
    }
}
