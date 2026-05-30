<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Timeline;
use App\Models\CultureGallery;
use App\Models\SmartCityMetric;
use Illuminate\Http\Request;

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

        // Get 3 featured destinations
        $featuredDestinations = Destination::take(3)->orderBy('id', 'desc')->get();

        // Get recent cultural showcases
        $recentCultures = CultureGallery::take(3)->orderBy('id', 'desc')->get();

        return view('public.home', compact('metrics', 'featuredDestinations', 'recentCultures'));
    }

    /**
     * Show the explore page with filters and Leaflet map data.
     */
    public function explore(Request $request)
    {
        $category = $request->query('category');
        $walkable = $request->has('walkable');
        $mrt = $request->has('mrt');

        $query = Destination::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($walkable) {
            $query->where('walkable', true);
        }

        if ($mrt) {
            $query->where('mrt_integrated', true);
        }

        $destinations = $query->orderBy('name', 'asc')->get();

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
}
