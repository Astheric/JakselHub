@extends('layouts.public')

@section('title', $destination->name . ' – Jaksel Hub')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <style>
        #map { height: 400px; z-index: 10; border-radius: 1.5rem; }
        .green-icon { filter: hue-rotate(120deg) brightness(0.9) contrast(1.2); }
    </style>
@endsection

@section('content')

    <!-- Hero Image Area -->
    <section class="relative w-full h-[50vh] sm:h-[60vh] bg-slate-100 overflow-hidden">
        @if($destination->image_path)
            <img src="{{ asset($destination->image_path) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
        @else
            <!-- Placeholder for API Data -->
            <div class="w-full h-full bg-gradient-to-br from-emerald-500 via-teal-600 to-emerald-900 flex flex-col items-center justify-center p-6 text-white text-center">
                <i class="bi bi-tree text-7xl sm:text-8xl mb-4 text-emerald-100 opacity-90 animate-bounce"></i>
                <span class="font-bold text-lg sm:text-xl tracking-widest uppercase text-emerald-100">{{ $destination->category }}</span>
            </div>
            <!-- Decorative Overlay -->
            <div class="absolute inset-0 bg-black/20 mix-blend-multiply"></div>
        @endif
        
        <!-- Back Button Overlay -->
        <a href="{{ route('explore') }}" class="absolute top-8 left-4 sm:left-8 px-5 py-2.5 bg-white/90 backdrop-blur-md text-slate-800 font-bold text-sm rounded-full shadow-lg hover:bg-white hover:-translate-y-0.5 transition-all flex items-center gap-2">
            <span>&larr;</span> Kembali
        </a>
    </section>

    <!-- Content Section -->
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-24">
        
        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-2xl shadow-slate-200 border border-slate-100" data-aos="fade-up">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                <!-- Main Info -->
                <div class="md:col-span-7 space-y-6">
                    <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-700 font-extrabold text-xs uppercase tracking-widest rounded-lg border border-emerald-100">
                        {{ $destination->category }}
                    </span>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ $destination->name }}
                    </h1>
                    
                    <div class="flex items-start gap-2 text-slate-500">
                        <i class="bi bi-geo-alt-fill text-slate-400 text-xl mt-0.5"></i>
                        <p class="text-sm sm:text-base leading-relaxed">{{ $destination->address }}</p>
                    </div>

                    <div class="prose prose-slate prose-emerald mt-6">
                        <p class="text-slate-600 leading-relaxed sm:text-lg">
                            {{ $destination->description }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-6 border-t border-slate-100 mt-6">
                        @if($destination->walkable)
                            <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl">
                                <i class="bi bi-person-walking text-slate-500 text-2xl"></i>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold text-slate-400">Aksesibilitas</span>
                                    <span class="block text-sm font-bold text-emerald-700">Ramah Pejalan Kaki</span>
                                </div>
                            </div>
                        @endif
                        
                        @if($destination->mrt_integrated)
                            <div class="flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl">
                                <i class="bi bi-subway text-slate-500 text-2xl"></i>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold text-slate-400">Transportasi</span>
                                    <span class="block text-sm font-bold text-teal-700">Dekat Stasiun MRT</span>
                                </div>
                            </div>
                        @endif

                        @if(isset($destination->is_api) && $destination->is_api)
                            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-100 rounded-xl w-full mt-2">
                                <i class="bi bi-broadcast text-blue-500 text-2xl"></i>
                                <div>
                                    <span class="block text-[10px] uppercase font-bold text-blue-400">Sumber Data</span>
                                    <span class="block text-xs font-bold text-blue-700">Otomatis dari OpenStreetMap API</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map Widget -->
                <div class="md:col-span-5">
                    <div class="sticky top-8 space-y-4">
                        <h3 class="font-bold text-lg text-slate-800">Peta Lokasi</h3>
                        <div id="map" class="shadow-md border border-slate-200"></div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $destination->latitude }},{{ $destination->longitude }}" target="_blank" rel="noopener noreferrer" class="w-full block text-center py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition-colors">
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        var lat = {{ $destination->latitude }};
        var lng = {{ $destination->longitude }};
        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap & CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var marker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`<b>{{ $destination->name }}</b><br>Jaksel Hub`)
            .openPopup();
            
        marker._icon.classList.add('green-icon');
    </script>
@endsection
