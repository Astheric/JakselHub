@extends('layouts.public')

@section('title', 'Koneksi Transum - JakselHub')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-gradient-to-b from-slate-800 to-slate-900 overflow-hidden transition-all duration-500" 
    style="background: linear-gradient(to bottom, var(--tw-gradient-from), var(--tw-gradient-to))">
    
    @php
        $heroColor = match($type) {
            'mrt' => 'from-blue-900',
            'krl' => 'from-red-900',
            'tj' => 'from-orange-800',
            default => 'from-blue-900'
        };
        $accentColor = match($type) {
            'mrt' => 'text-blue-300 bg-blue-500/20 border-blue-400/30',
            'krl' => 'text-red-300 bg-red-500/20 border-red-400/30',
            'tj' => 'text-orange-300 bg-orange-500/20 border-orange-400/30',
            default => 'text-blue-300 bg-blue-500/20 border-blue-400/30'
        };
        $gradientText = match($type) {
            'mrt' => 'from-blue-400 to-cyan-300',
            'krl' => 'from-red-400 to-orange-300',
            'tj' => 'from-orange-400 to-yellow-300',
            default => 'from-blue-400 to-cyan-300'
        };
    @endphp

    <div class="absolute inset-0 bg-gradient-to-b {{ $heroColor }} to-slate-900"></div>
    <div class="absolute inset-0 bg-[url('{{ $networkInfo['bg_image'] }}')] bg-cover bg-center opacity-20 mix-blend-overlay transition-all duration-500"></div>
    <div class="absolute inset-0 bg-slate-900/40"></div>
    
    <div class="container mx-auto px-6 relative z-10 text-center">
        <span class="inline-block py-1 px-3 rounded-full {{ $accentColor }} text-sm font-bold tracking-wider uppercase mb-4 border backdrop-blur-sm transition-all duration-300">
            Transportasi Umum
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight">
            Peta Koneksi <span class="text-transparent bg-clip-text bg-gradient-to-r {{ $gradientText }}">{{ $networkInfo['name'] }}</span>
        </h1>
        <p class="text-lg text-slate-200 max-w-2xl mx-auto mb-10 leading-relaxed">
            Temukan taman, museum, dan destinasi wisata di Jakarta Selatan yang terintegrasi dan bisa diakses dengan berjalan kaki dari {{ $networkInfo['name'] }}.
        </p>
        
        <!-- Network Selector Pills -->
        <div class="flex flex-wrap justify-center gap-4 mt-8">
            <a href="{{ route('transum', ['type' => 'mrt']) }}" class="px-6 py-3 rounded-full font-bold transition-all duration-300 {{ $type === 'mrt' ? 'bg-blue-600 text-white shadow-[0_0_20px_rgba(37,99,235,0.4)] scale-105' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 hover:text-white backdrop-blur-md border border-slate-600' }} flex items-center gap-2">
                <i class="bi bi-subway"></i> MRT Jakarta
            </a>
            <a href="{{ route('transum', ['type' => 'krl']) }}" class="px-6 py-3 rounded-full font-bold transition-all duration-300 {{ $type === 'krl' ? 'bg-red-600 text-white shadow-[0_0_20px_rgba(220,38,38,0.4)] scale-105' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 hover:text-white backdrop-blur-md border border-slate-600' }} flex items-center gap-2">
                <i class="bi bi-train-front"></i> KRL Commuter
            </a>
            <a href="{{ route('transum', ['type' => 'tj']) }}" class="px-6 py-3 rounded-full font-bold transition-all duration-300 {{ $type === 'tj' ? 'bg-orange-500 text-white shadow-[0_0_20px_rgba(249,115,22,0.4)] scale-105' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 hover:text-white backdrop-blur-md border border-slate-600' }} flex items-center gap-2">
                <i class="bi bi-bus-front"></i> Transjakarta
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Left Column: Transit Line -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 sticky top-32">
                    @php
                        $uiColor = match($type) {
                            'mrt' => 'blue',
                            'krl' => 'red',
                            'tj' => 'orange',
                            default => 'blue'
                        };
                    @endphp
                    <h2 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span>Pilih Titik</span>
                        <span class="px-2 py-1 bg-{{ $uiColor }}-100 text-{{ $uiColor }}-700 text-xs rounded-lg uppercase tracking-wider">{{ $networkInfo['name'] }}</span>
                    </h2>
                    
                    <div class="relative pl-4 space-y-6">
                        <!-- Timeline line -->
                        <div class="absolute left-[23px] top-4 bottom-4 w-1 bg-slate-100 rounded-full"></div>
                        
                        @foreach($stations as $id => $station)
                        <div class="relative group">
                            <form action="{{ route('transum') }}" method="GET" class="w-full">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="station" value="{{ $id }}">
                                <button type="submit" class="w-full flex items-center text-left hover:bg-slate-50 p-2 rounded-xl transition-all relative z-10 group">
                                    
                                    <!-- Node Indicator -->
                                    <div class="w-5 h-5 rounded-full border-4 {{ $selectedId === $id ? 'bg-'.$uiColor.'-600 border-'.$uiColor.'-200 shadow-[0_0_15px_rgba(0,0,0,0.2)]' : 'bg-white border-slate-300 group-hover:border-'.$uiColor.'-400' }} flex-shrink-0 z-10 transition-all mr-4"></div>
                                    
                                    <!-- Station Name -->
                                    <div>
                                        <h3 class="font-bold text-lg {{ $selectedId === $id ? 'text-'.$uiColor.'-700' : 'text-slate-600 group-hover:text-'.$uiColor.'-600' }} transition-colors">
                                            {{ str_replace(['Stasiun ', 'Halte ', 'Terminal '], '', $station['name']) }}
                                        </h3>
                                    </div>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Destinations -->
            <div class="lg:w-2/3">
                <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                            Radius <span class="text-{{ $uiColor }}-600">{{ $selectedStation['name'] }}</span>
                        </h2>
                        <p class="text-slate-500 mt-2">Ditemukan <span class="font-bold text-slate-700">{{ count($nearbyDestinations) }} destinasi</span> dalam radius 1.5 KM berjalan kaki.</p>
                    </div>
                </div>

                @if(count($nearbyDestinations) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($nearbyDestinations as $dest)
                            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] border border-slate-100 transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                                <a href="{{ route('destination.show', $dest->id) }}" class="relative h-48 overflow-hidden block">
                                    @if($dest->image_path)
                                        <img src="{{ asset($dest->image_path) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-{{ $uiColor }}-400 to-slate-500 flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
                                            <i class="bi bi-geo-alt-fill text-5xl text-white/50"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-slate-800 text-xs font-bold rounded-lg shadow-sm">
                                            {{ $dest->category }}
                                        </span>
                                    </div>
                                    
                                    <!-- Distance Badge -->
                                    <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3 py-1.5 bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold rounded-xl shadow-sm border border-white/20">
                                        <i class="bi bi-person-walking text-sm"></i>
                                        <span>{{ $dest->distance_meters }} m</span>
                                    </div>
                                </a>
                                <div class="p-6 flex-grow flex flex-col">
                                    <a href="{{ route('destination.show', $dest->id) }}" class="text-xl font-bold text-slate-800 mb-2 hover:text-{{ $uiColor }}-600 transition-colors line-clamp-1 block">{{ $dest->name }}</a>
                                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $dest->description }}</p>
                                    
                                    <a href="https://www.google.com/maps/dir/?api=1&origin={{ $selectedStation['lat'] }},{{ $selectedStation['lon'] }}&destination={{ $dest->latitude }},{{ $dest->longitude }}&travelmode=walking" target="_blank" class="mt-auto pt-4 border-t border-slate-100 flex items-center text-{{ $uiColor }}-600 font-semibold text-sm hover:text-{{ $uiColor }}-700 transition-colors cursor-pointer">
                                        Lihat Rute di Google Maps <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-slate-100 flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-4xl mb-6 shadow-inner text-slate-400">
                            <i class="bi bi-person-walking"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Destinasi Terdekat</h3>
                        <p class="text-slate-500 max-w-md mx-auto">Sistem belum menemukan taman atau museum yang berada dalam radius 1.5 KM berjalan kaki dari stasiun/halte ini.</p>
                        
                        <a href="{{ route('explore') }}" class="mt-8 px-6 py-3 bg-{{ $uiColor }}-600 hover:bg-{{ $uiColor }}-700 text-white font-bold rounded-xl shadow-md transition-all">
                            Cari Destinasi Lain
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
