<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Destination;
use Illuminate\Support\Str;

class ImportOsmDestinations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:osm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import OpenStreetMap destinations (Parks, Museums, Historic) to the local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai menarik data dari Overpass API...');

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
                
                $count = 0;
                
                foreach ($elements as $el) {
                    $tags = $el['tags'] ?? [];
                    $name = $tags['name'] ?? null;
                    if (!$name) continue;

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

                    // Update or Create the destination
                    $slug = Str::slug($name);
                    
                    // Check if slug exists, if so append osm id
                    $existing = Destination::where('slug', $slug)->first();
                    if ($existing && $existing->name !== $name) {
                        $slug = $slug . '-' . $el['id'];
                    }

                    Destination::updateOrCreate(
                        ['name' => $name], // Search by name
                        [
                            'slug' => $slug,
                            'description' => $description,
                            'category' => $cat,
                            'address' => $address,
                            'latitude' => $lat,
                            'longitude' => $lon,
                            'image_path' => $imageUrl,
                        ]
                    );

                    $count++;
                }

                $this->info("Berhasil mengimpor $count destinasi ke dalam database.");
            } else {
                $this->error('Gagal mengambil data dari API Overpass.');
            }
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan koneksi API: ' . $e->getMessage());
        }
    }
}
