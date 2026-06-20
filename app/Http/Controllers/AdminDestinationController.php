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
        $destinations = Destination::orderBy('id', 'desc')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function syncOsm()
    {
        // Build the Overpass QL query
        $query = '[out:json][timeout:25];
area["name"="Jakarta Selatan"]->.searchArea;
(
  node["leisure"="park"](area.searchArea);
  way["leisure"="park"](area.searchArea);
  node["tourism"="museum"](area.searchArea);
  way["tourism"="museum"](area.searchArea);
  node["historic"](area.searchArea);
  way["historic"](area.searchArea);
  node["tourism"="attraction"](area.searchArea);
);
out center;';

        $url = 'https://overpass-api.de/api/interpreter?data=' . urlencode($query);
        
        try {
            $options = [
                'http' => [
                    'method' => 'GET',
                    'header' => "User-Agent: JakselHubBot/1.0\r\n"
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);

            if ($response !== false) {
                $data = json_decode($response, true);
                $elements = $data['elements'] ?? [];
                
                $newCount = 0;
                
                foreach ($elements as $el) {
                    $tags = $el['tags'] ?? [];
                    $name = $tags['name'] ?? null;
                    if (!$name) continue;

                    // Skip if name already exists (No Overwrite!)
                    if (Destination::where('name', $name)->exists()) {
                        continue;
                    }

                    // Determine Category
                    $cat = 'Tempat Wisata';
                    $descPrefix = 'Ruang publik dan tempat wisata menarik di Jakarta Selatan.';
                    
                    if (isset($tags['leisure']) && $tags['leisure'] == 'park') {
                        $cat = 'Ruang Terbuka Hijau';
                        $descPrefix = 'Taman kota dan ruang terbuka hijau yang asri di Jakarta Selatan.';
                    }
                    if (isset($tags['tourism']) && $tags['tourism'] == 'museum') {
                        $cat = 'Heritage';
                        $descPrefix = 'Museum edukatif dengan koleksi sejarah di Jakarta Selatan.';
                    }
                    if (isset($tags['historic'])) {
                        $cat = 'Heritage';
                        $descPrefix = 'Situs bersejarah dan cagar budaya di Jakarta Selatan.';
                    }

                    // Coordinates
                    $lat = $el['lat'] ?? $el['center']['lat'] ?? null;
                    $lon = $el['lon'] ?? $el['center']['lon'] ?? null;
                    if (!$lat || !$lon) continue;

                    // Generate a reproducible random image from picsum
                    $idStr = (string)$el['id'];
                    $imageSeed = md5($idStr);
                    $imageUrl = "https://picsum.photos/seed/{$imageSeed}/800/600";

                    // Description
                    $description = $descPrefix . ' Destinasi ini merupakan bagian dari peta integrasi JakselHub.';

                    // Address placeholder
                    $address = $tags['addr:street'] ?? 'Jakarta Selatan';

                    $slug = Str::slug($name);
                    $existingSlug = Destination::where('slug', $slug)->first();
                    if ($existingSlug) {
                        $slug = $slug . '-' . $el['id'];
                    }

                    Destination::create([
                        'name' => $name,
                        'slug' => $slug,
                        'description' => $description,
                        'category' => $cat,
                        'address' => $address,
                        'latitude' => $lat,
                        'longitude' => $lon,
                        'image_path' => $imageUrl,
                    ]);

                    $newCount++;
                }

                if ($newCount > 0) {
                    return redirect()->route('admin.destinations.index')->with('success', "Sinkronisasi berhasil! $newCount destinasi baru telah ditambahkan dari API tanpa menimpa data lama.");
                } else {
                    return redirect()->route('admin.destinations.index')->with('success', "Sinkronisasi selesai. Tidak ada destinasi baru yang ditemukan (Semua data sudah mutakhir).");
                }
            } else {
                return redirect()->route('admin.destinations.index')->with('error', 'Gagal mengambil data dari API OpenStreetMap.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.destinations.index')->with('error', 'Terjadi kesalahan koneksi API: ' . $e->getMessage());
        }
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
