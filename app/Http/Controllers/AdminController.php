<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Timeline;
use App\Models\CultureGallery;
use App\Models\SmartCityMetric;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $destinationsCount = Destination::count();
        $timelinesCount = Timeline::count();
        $cultureGalleriesCount = CultureGallery::count();
        $metrics = SmartCityMetric::first();

        return view('admin.dashboard', compact(
            'destinationsCount',
            'timelinesCount',
            'cultureGalleriesCount',
            'metrics'
        ));
    }

    /**
     * Update Smart City Metrics.
     */
    public function updateMetrics(Request $request)
    {
        $request->validate([
            'aqi' => 'required|integer|min:0|max:500',
            'green_spaces_count' => 'required|integer|min:0',
            'public_transport_count' => 'required|integer|min:0',
        ]);

        $metrics = SmartCityMetric::first();
        if (!$metrics) {
            $metrics = new SmartCityMetric();
        }

        $metrics->fill($request->only(['aqi', 'green_spaces_count', 'public_transport_count']));
        $metrics->save();

        return redirect()->route('admin.dashboard')->with('success', 'Statistik Smart City berhasil diperbarui.');
    }
}
