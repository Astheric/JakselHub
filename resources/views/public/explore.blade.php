@extends('layouts.public')

@section('title', 'Jelajah Wisata – Jaksel Hub')

@section('styles')
    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 480px;
            z-index: 10;
        }
        /* Custom Green Pin style */
        .green-icon {
            filter: hue-rotate(120deg) brightness(0.9) contrast(1.2);
        }
    </style>
@endsection

@section('content')

    <!-- Header Section -->
    <section class="bg-white border-b border-emerald-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-aos="fade-right">
                <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                    Explore Jakarta Selatan
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mt-3">Direktori Hijau & Urban Kota</h1>
                <p class="text-slate-500 text-sm sm:text-base mt-2">
                    Temukan lokasi nongkrong ramah lingkungan, cagar budaya Betawi legendaris, dan rimbunnya taman kota terintegrasi jalur hijau transportasi massal MRT Jakarta.
                </p>
            </div>
        </div>
    </section>

    <!-- Map & Filters Section -->
    <section class="py-8 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filters Card -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm mb-8" data-aos="fade-up" data-aos-delay="100">
                <form method="GET" action="{{ route('explore') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    
                    <!-- Category Selection -->
                    <div class="space-y-2">
                        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Pilih Kategori</label>
                        <select name="category" id="category" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                            <option value="">Semua Destinasi</option>
                            <option value="Ruang Terbuka Hijau" {{ $category === 'Ruang Terbuka Hijau' ? 'selected' : '' }}>🌳 Ruang Terbuka Hijau</option>
                            <option value="Heritage" {{ $category === 'Heritage' ? 'selected' : '' }}>🏮 Warisan Budaya (Heritage)</option>
                            <option value="Aesthetic Cafe" {{ $category === 'Aesthetic Cafe' ? 'selected' : '' }}>☕ Aesthetic Cafe</option>
                        </select>
                    </div>

                    <!-- Walkable Filter Checkbox -->
                    <div class="flex items-center h-12">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="checkbox" name="walkable" value="1" {{ $walkable ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            <span class="ml-3 text-sm font-bold text-slate-700">🚶 Ramah Pejalan Kaki</span>
                        </label>
                    </div>

                    <!-- MRT Integrated Filter Checkbox -->
                    <div class="flex items-center h-12">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="checkbox" name="mrt" value="1" {{ $mrt ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                            <span class="ml-3 text-sm font-bold text-slate-700">🚇 Dekat Stasiun MRT</span>
                        </label>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" class="flex-grow py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-all shadow-md shadow-emerald-100">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('explore') }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-sm transition-all text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Map Embed Container -->
            <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-md mb-12" data-aos="fade-up" data-aos-delay="200">
                <div id="map"></div>
                <div class="bg-emerald-950 text-emerald-100 text-xs px-6 py-3 flex justify-between items-center">
                    <span>💡 Peta Interaktif Nusantara Digital City</span>
                    <span class="font-semibold text-emerald-300">Klik pin hijau untuk melihat info detail lokasi</span>
                </div>
            </div>

            <!-- Directory Grid -->
            <div>
                <h2 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-2" data-aos="fade-right">
                    📂 Daftar Destinasi Terdata <span class="text-sm font-bold text-slate-400 bg-slate-200/50 px-3 py-1 rounded-full">{{ $destinations->count() }} Lokasi</span>
                </h2>
                
                @if($destinations->isEmpty())
                <div class="bg-white border border-dashed border-slate-200 rounded-3xl p-12 text-center text-slate-500">
                    <span class="text-4xl block mb-2">🔍</span>
                    <h3 class="font-extrabold text-slate-700 text-lg">Tidak ada destinasi ditemukan</h3>
                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kombinasi filter atau reset pencarian Anda.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($destinations as $index => $dest)
                    <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between" id="card-{{ $dest->id }}" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
                        
                        <!-- Top Banner / Category -->
                        <div class="h-40 bg-slate-100 relative overflow-hidden">
                            @if($dest->image_path)
                                <img src="{{ asset($dest->image_path) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-400 to-teal-800 flex flex-col items-center justify-center p-6 text-white text-center">
                                    <span class="text-2xl mb-1">🌳</span>
                                    <span class="font-bold text-xs tracking-wider uppercase border-b border-emerald-300/40 pb-0.5">{{ $dest->name }}</span>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 px-3 py-1 bg-white/95 text-slate-800 font-extrabold text-[10px] tracking-wider rounded-lg shadow-sm uppercase">
                                {{ $dest->category }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="font-extrabold text-xl text-slate-900 group-hover:text-emerald-600 transition-colors tracking-tight leading-tight">
                                    {{ $dest->name }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                    {{ $dest->description }}
                                </p>
                            </div>

                            <!-- Address -->
                            <div class="text-[11px] text-slate-400 flex items-start gap-1">
                                <span class="text-sm">📍</span>
                                <span class="line-clamp-2">{{ $dest->address }}</span>
                            </div>

                            <!-- Accessibility badges & Focus button -->
                            <div class="border-t border-slate-50 pt-4 space-y-3">
                                <div class="flex flex-wrap gap-2">
                                    @if($dest->walkable)
                                        <span class="text-[9px] font-extrabold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">
                                            🚶 Walkable
                                        </span>
                                    @endif
                                    @if($dest->mrt_integrated)
                                        <span class="text-[9px] font-extrabold text-teal-800 bg-teal-50 px-2 py-0.5 rounded border border-teal-100">
                                            🚇 MRT Integrated
                                        </span>
                                    @endif
                                </div>

                                <button type="button" onclick="focusMap({{ $dest->latitude }}, {{ $dest->longitude }}, '{{ addslashes($dest->name) }}', '{{ $dest->category }}', {{ $index }})" class="w-full text-center py-2.5 bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 border border-slate-200 hover:border-emerald-200 font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                    <span>🔍</span> Lihat di Peta
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <!-- Leaflet Map JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Default coordinates centered on South Jakarta (Blok M / Kebayoran area)
        var map = L.map('map').setView([-6.244302, 106.793739], 12);

        // Load premium light-themed tiles for clean White aesthetics
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Store markers to interact with them
        var markers = [];

        // Markers data from server
        @foreach($destinations as $index => $dest)
            var marker = L.marker([{{ $dest->latitude }}, {{ $dest->longitude }}])
                .addTo(map)
                .bindPopup(`
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 4px; max-width: 200px;">
                        <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; color: #059669; background-color: #ecfdf5; padding: 2px 6px; border-radius: 4px; border: 1px solid #d1fae5; display: inline-block; margin-bottom: 6px;">
                            {{ $dest->category }}
                        </span>
                        <h4 style="font-weight: 800; font-size: 13px; color: #1e293b; margin: 0 0 4px 0; line-height: 1.2;">
                            {{ $dest->name }}
                        </h4>
                        <p style="font-size: 11px; color: #64748b; margin: 0; line-height: 1.4;">
                            {{ Str::limit($dest->description, 70) }}
                        </p>
                    </div>
                `);

            // Apply custom CSS green filter to Leaflet marker
            marker._icon.classList.add('green-icon');
            markers.push(marker);
        @endforeach

        // Smoothly focus map on location
        function focusMap(lat, lng, name, category, index) {
            map.setView([lat, lng], 15, {
                animate: true,
                duration: 1.5
            });
            
            // Trigger marker popup open
            if(markers[index]) {
                markers[index].openPopup();
            }

            // Smooth scroll to map
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
@endsection
