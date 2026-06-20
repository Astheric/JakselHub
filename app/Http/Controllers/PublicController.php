<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Timeline;
use App\Models\CultureGallery;
use App\Models\SmartCityMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    /**
     * Show the landing page / homepage.
     */
    public function home()
    {
        $metrics = SmartCityMetric::first() ?? new SmartCityMetric([
            'aqi' => 45,
            'green_spaces_count' => 156,
            'public_transport_count' => 38
        ]);

        // Fetch Real-time AQI from API with 30 minutes cache
        $realtimeAqi = Cache::remember('jaksel_aqi', 1800, function () use ($metrics) {
            try {
                $response = Http::timeout(5)->get('https://air-quality-api.open-meteo.com/v1/air-quality', [
                    'latitude' => -6.2615,
                    'longitude' => 106.8106,
                    'current' => 'us_aqi'
                ]);

                if ($response->successful()) {
                    return $response->json('current.us_aqi');
                }
            } catch (\Exception $e) {
                Log::warning('Failed to fetch AQI from Open-Meteo API: ' . $e->getMessage());
            }

            // Fallback to database value
            return $metrics->aqi;
        });

        // Calculate total green spaces (DB)
        $totalGreenSpaces = Destination::where('category', 'Ruang Terbuka Hijau')->count();

        // Override the database value with the real-time AQI and total spaces
        $metrics->aqi = $realtimeAqi;
        $metrics->green_spaces_count = $totalGreenSpaces;

        // Get featured destinations from DB
        $featuredDestinations = Destination::inRandomOrder()->take(5)->get();

        // Get recent cultural showcases
        $recentCultures = CultureGallery::take(3)->orderBy('id', 'desc')->get();

        return view('public.home', compact('metrics', 'featuredDestinations', 'recentCultures'));
    }

    /**
     * Show the explore page with filters and Leaflet map data.
     */
    public function explore(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $walkable = $request->has('walkable');
        $mrt = $request->has('mrt');

        $query = Destination::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($walkable) {
            $query->where('walkable', true);
        }

        if ($mrt) {
            $query->where('mrt_integrated', true);
        }

        $destinations = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        return view('public.explore', compact('destinations', 'category', 'walkable', 'mrt'));
    }

    /**
     * Show culture & heritage history timeline.
     */
    public function culture()
    {
        $timelines = Timeline::orderBy('order', 'asc')->get();
        $cultures = CultureGallery::orderBy('id', 'desc')->get();

        return view('public.culture', compact('timelines', 'cultures'));
    }

    /**
     * Show Destination Detail Page.
     */
    public function showDestination($id)
    {
        $destination = Destination::findOrFail($id);
        return view('public.destination', compact('destination'));
    }

    /**
     * Transum (Transportasi Umum) Connection Feature
     */
    public function transum(Request $request)
    {
        $networks = [
            'mrt' => [
                'name' => 'MRT Jakarta',
                'color' => 'blue',
                'bg_image' => 'https://picsum.photos/seed/mrtjakarta/1920/1080',
                'stations' => [
                    'lebak_bulus' => ['name' => 'Stasiun Lebak Bulus Grab', 'lat' => -6.2893, 'lon' => 106.7750],
                    'fatmawati' => ['name' => 'Stasiun Fatmawati Indomaret', 'lat' => -6.2925, 'lon' => 106.7937],
                    'cipete' => ['name' => 'Stasiun Cipete Raya', 'lat' => -6.2783, 'lon' => 106.7974],
                    'haji_nawi' => ['name' => 'Stasiun Haji Nawi', 'lat' => -6.2667, 'lon' => 106.7974],
                    'blok_a' => ['name' => 'Stasiun Blok A', 'lat' => -6.2558, 'lon' => 106.7973],
                    'blok_m' => ['name' => 'Stasiun Blok M BCA', 'lat' => -6.2445, 'lon' => 106.7980],
                    'asean' => ['name' => 'Stasiun ASEAN', 'lat' => -6.2393, 'lon' => 106.7984],
                    'senayan' => ['name' => 'Stasiun Senayan Mastercard', 'lat' => -6.2268, 'lon' => 106.8016],
                ]
            ],
            'krl' => [
                'name' => 'KRL Commuter Line',
                'color' => 'red',
                'bg_image' => 'https://picsum.photos/seed/krljakarta/1920/1080',
                'stations' => [
                    'manggarai' => ['name' => 'Stasiun Manggarai', 'lat' => -6.2098, 'lon' => 106.8502],
                    'tebet' => ['name' => 'Stasiun Tebet', 'lat' => -6.2265, 'lon' => 106.8582],
                    'cawang' => ['name' => 'Stasiun Cawang', 'lat' => -6.2427, 'lon' => 106.8576],
                    'duren_kalibata' => ['name' => 'Stasiun Duren Kalibata', 'lat' => -6.2553, 'lon' => 106.8546],
                    'pasar_minggu' => ['name' => 'Stasiun Pasar Minggu', 'lat' => -6.2842, 'lon' => 106.8443],
                    'tanjung_barat' => ['name' => 'Stasiun Tanjung Barat', 'lat' => -6.3080, 'lon' => 106.8398],
                    'lenteng_agung' => ['name' => 'Stasiun Lenteng Agung', 'lat' => -6.3312, 'lon' => 106.8329],
                    'univ_pancasila' => ['name' => 'Stasiun Univ. Pancasila', 'lat' => -6.3404, 'lon' => 106.8320],
                    'kebayoran' => ['name' => 'Stasiun Kebayoran', 'lat' => -6.2384, 'lon' => 106.7820],
                ]
            ],
            'tj' => [
                'name' => 'Transjakarta',
                'color' => 'orange',
                'bg_image' => 'https://picsum.photos/seed/transjakarta/1920/1080',
                'stations' => [
                    'csw' => ['name' => 'Halte Integrasi CSW', 'lat' => -6.2405, 'lon' => 106.7997],
                    'blok_m_terminal' => ['name' => 'Terminal Blok M', 'lat' => -6.2435, 'lon' => 106.7990],
                    'ragunan' => ['name' => 'Halte Ragunan', 'lat' => -6.3026, 'lon' => 106.8227],
                    'kuningan_barat' => ['name' => 'Halte Kuningan Barat', 'lat' => -6.2392, 'lon' => 106.8306],
                    'kuningan_timur' => ['name' => 'Halte Kuningan Timur', 'lat' => -6.2404, 'lon' => 106.8310],
                    'pancoran_tugu' => ['name' => 'Halte Pancoran Tugu', 'lat' => -6.2421, 'lon' => 106.8442],
                    'dept_pertanian' => ['name' => 'Halte Departemen Pertanian', 'lat' => -6.2894, 'lon' => 106.8224],
                ]
            ]
        ];

        $type = $request->get('type', 'mrt');
        if (!array_key_exists($type, $networks)) {
            $type = 'mrt';
        }

        $stations = $networks[$type]['stations'];
        
        $selectedId = $request->get('station');
        if (!$selectedId || !array_key_exists($selectedId, $stations)) {
            $selectedId = array_key_first($stations); // Default to first station of the selected type
        }
        $selectedStation = $stations[$selectedId];

        // Fetch all destinations from Database
        $allDestinations = Destination::all();
        
        $nearbyDestinations = [];
        foreach ($allDestinations as $dest) {
            $dist = $this->haversineGreatCircleDistance(
                $selectedStation['lat'], $selectedStation['lon'],
                $dest->latitude, $dest->longitude
            );
            if ($dist <= 1500) { // 1.5 km
                $dest->distance_meters = round($dist);
                $nearbyDestinations[] = $dest;
            }
        }
        
        // Sort by distance
        usort($nearbyDestinations, function($a, $b) {
            return $a->distance_meters <=> $b->distance_meters;
        });

        $networkInfo = $networks[$type];

        return view('public.transum', compact('networks', 'type', 'stations', 'selectedId', 'selectedStation', 'nearbyDestinations', 'networkInfo'));
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @return float Distance in meters
     */
    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

}
