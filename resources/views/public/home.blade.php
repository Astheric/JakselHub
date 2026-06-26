@extends('layouts.public')

@section('title', 'Jaksel Hub – Nusantara Digital City')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden border-b border-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 lg:pt-28 lg:pb-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left z-10" data-aos="fade-right">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-widest animate-pulse">
                        <i class="bi bi-leaf-fill text-emerald-600 mr-1.5"></i> Smart City Innovation
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Harmoni Modernitas <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">
                            Hijau & Digital
                        </span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Selamat datang di representasi digital Jakarta Selatan. Wilayah di mana inovasi bisnis pencakar langit SCBD melebur indah dalam rimbunnya paru-paru kota dan kehangatan budaya luhur Betawi.
                    </p>
                    
                    <!-- Call to Actions -->
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('explore') }}" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 hover:shadow-emerald-200 transition-all text-center">
                            Mulai Jelajah Kota
                        </a>
                        <a href="{{ route('culture') }}" class="px-8 py-4 bg-white hover:bg-slate-50 text-emerald-700 font-bold border border-emerald-200 hover:border-emerald-300 rounded-2xl transition-all text-center">
                            Telusuri Sejarah
                        </a>
                    </div>
                </div>
                
                <!-- Right Visual: SCBD & Nature Blend -->
                <div class="lg:col-span-6 relative flex justify-center items-center" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-full max-w-lg relative z-10">
                        <!-- Decorative Shapes -->
                        <div class="absolute -top-12 -left-12 w-64 h-64 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl opacity-60"></div>
                        <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-teal-100 rounded-full mix-blend-multiply filter blur-2xl opacity-60"></div>
                        
                        <!-- Premium Composite Card (representing SCBD + Forest) -->
                        <div class="relative bg-white border border-slate-100 rounded-3xl p-4 shadow-2xl shadow-slate-100 transform hover:scale-[1.02] transition-transform duration-300">
                            <!-- Simulated Premium Image using CSS Gradients & SVGs -->
                            <div class="h-80 w-full rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-600 to-slate-900 relative overflow-hidden flex flex-col justify-between p-6">
                                <!-- Abstract Skyline lines & Leafs -->
                                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                
                                <!-- Decorative Digital Net -->
                                <svg class="absolute inset-0 w-full h-full text-white/5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                    <path d="M0,40 C20,20 40,60 80,40" stroke="currentColor" stroke-width="0.5" fill="none"/>
                                    <path d="M0,20 C30,50 50,10 80,60" stroke="currentColor" stroke-width="0.5" fill="none"/>
                                </svg>

                                <!-- Top Badges -->
                                <div class="flex justify-between items-start z-10">
                                    <span class="px-3 py-1 bg-white/10 backdrop-blur-md text-white font-bold text-xs rounded-full border border-white/20">
                                        <i class="bi bi-building mr-1"></i> SCBD Tech Area
                                    </span>
                                    <span class="px-3 py-1 bg-emerald-500/30 backdrop-blur-md text-emerald-200 font-bold text-xs rounded-full border border-emerald-400/30">
                                        <i class="bi bi-tree-fill mr-1"></i> Green Spine
                                    </span>
                                </div>
                                
                                <!-- Bottom title -->
                                <div class="z-10 text-white space-y-2">
                                    <h3 class="font-extrabold text-2xl tracking-tight leading-tight">Nusantara Digital City</h3>
                                    <p class="text-xs text-emerald-200 font-medium">Harmoni pembangunan masif urban berdampingan dengan kelestarian alam dan budaya luhur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Smart City Real-time Metrics Widget -->
    <section class="py-12 bg-slate-50 border-b border-emerald-50 relative -mt-8 z-20 max-w-6xl mx-auto px-4">
        <div class="bg-white border border-emerald-100 rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-100" data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 border-b border-slate-100 pb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="bi bi-bar-chart-line-fill text-emerald-600"></i> Indikator Smart City Jaksel
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Metrik lingkungan terdigitalisasi dan ketersediaan mobilitas publik secara real-time.</p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 rounded-full border border-emerald-100 text-xs font-semibold text-emerald-700">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-ping"></span>
                    Update Real-Time Terkendali
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- AQI Index Card -->
                @php
                    $aqi = $metrics->aqi;
                    $aqiColor = 'bg-emerald-500';
                    $aqiBg = 'bg-emerald-50';
                    $aqiBorder = 'border-emerald-100';
                    $aqiText = 'text-emerald-700';
                    $aqiStatus = 'Baik (Sangat Sehat)';
                    
                    if ($aqi > 50 && $aqi <= 100) {
                        $aqiColor = 'bg-yellow-500';
                        $aqiBg = 'bg-yellow-50';
                        $aqiBorder = 'border-yellow-100';
                        $aqiText = 'text-yellow-700';
                        $aqiStatus = 'Sedang (Aman)';
                    } elseif ($aqi > 100) {
                        $aqiColor = 'bg-red-500';
                        $aqiBg = 'bg-red-50';
                        $aqiBorder = 'border-red-100';
                        $aqiText = 'text-red-700';
                        $aqiStatus = 'Tidak Sehat';
                    }
                @endphp
                <div class="p-6 rounded-2xl border {{ $aqiBorder }} {{ $aqiBg }} flex items-center justify-between shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Kualitas Udara (AQI)</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $aqi }}</span>
                            <span class="text-xs font-bold {{ $aqiText }}">{{ $aqiStatus }}</span>
                        </div>
                        <p class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live Data: Open-Meteo API
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl {{ $aqiColor }} text-white flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                </div>

                <!-- Green Spaces (RTH) Card -->
                <div class="p-6 rounded-2xl border border-teal-100 bg-teal-50/50 flex items-center justify-between shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Ruang Terbuka Hijau</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metrics->green_spaces_count }}</span>
                            <span class="text-xs font-bold text-teal-700">Taman & Hutan Kota</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Komitmen Net-Zero Carbon 2030.</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                </div>

                <!-- Public Transport Card -->
                <div class="p-6 rounded-2xl border border-emerald-100 bg-emerald-50/50 flex items-center justify-between shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Rute Hijau MRT & TJ</span>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $metrics->public_transport_count }}</span>
                            <span class="text-xs font-bold text-emerald-700">Koneksi Aktif</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Transportasi ramah lingkungan.</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Curated Destinations Showcase -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4" data-aos="fade-up">
                <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                    <i class="bi bi-map mr-1"></i> Destinasi Pilihan
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Jelajah Sudut Hijau Jakarta Selatan</h2>
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                    Katalog titik ikonik terintegrasi yang memisahkan keindahan taman kota, keasrian budaya luhur, dan kawasan bersantai modis kawula muda.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredDestinations as $dest)
                <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <!-- Image Area -->
                    <div class="h-56 bg-slate-100 relative overflow-hidden">
                        @if($dest->image_path)
                            <img src="{{ asset($dest->image_path) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <!-- Placeholder with custom thematic HSL gradient -->
                            <div class="w-full h-full bg-gradient-to-br from-emerald-400/80 to-teal-700/90 flex flex-col items-center justify-center p-6 text-white text-center relative">
                                <i class="bi bi-tree text-3xl mb-2"></i>
                                <span class="font-bold text-sm tracking-wide">{{ $dest->category }}</span>
                                <span class="text-[10px] text-emerald-100 mt-1 uppercase tracking-widest font-semibold border-b border-emerald-300 pb-0.5">{{ $dest->name }}</span>
                            </div>
                        @endif
                        
                        <!-- Top Category badge -->
                        <span class="absolute top-4 left-4 px-3 py-1 bg-white/95 backdrop-blur-sm text-slate-800 font-extrabold text-[10px] tracking-wider rounded-lg shadow-sm uppercase">
                            {{ $dest->category }}
                        </span>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-xl text-slate-900 group-hover:text-emerald-600 transition-colors tracking-tight">
                                {{ $dest->name }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ $dest->description }}
                            </p>
                        </div>
                        
                        <!-- Indicators (Walkable/MRT) -->
                        <div class="flex flex-wrap gap-2 pt-2 border-t border-slate-50">
                            @if($dest->walkable)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100">
                                    <i class="bi bi-person-walking"></i> Ramah Pejalan Kaki
                                </span>
                            @endif
                            @if($dest->mrt_integrated)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100">
                                    <i class="bi bi-subway"></i> Stasiun MRT Terdekat
                                </span>
                            @endif
                        </div>
                        <div class="pt-4 mt-auto">
                            <a href="{{ route('destination.show', $dest->id) }}" class="w-full text-center py-2.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-xs rounded-xl transition-all shadow-sm flex items-center justify-center">
                                Lihat Detail Destinasi
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('explore') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 border-b-2 border-emerald-200 hover:border-emerald-600 pb-1 transition-all">
                    Lihat Semua Direktori Wisata
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Betawi Culture Promotion Banner -->
    <section class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-emerald-800 to-teal-950 rounded-3xl p-8 sm:p-12 md:p-16 text-white relative overflow-hidden shadow-xl" data-aos="fade-up">
                <!-- Graphics -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-700 rounded-full mix-blend-multiply opacity-20 filter blur-xl"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                    <div class="lg:col-span-8 space-y-6">
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 font-extrabold text-xs uppercase rounded-lg border border-emerald-500/30 tracking-widest">
                            <i class="bi bi-award-fill mr-1"></i> Budaya Betawi Setu Babakan
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kekayaan Tradisi yang Selalu Dirawat</h2>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-xl">
                            Di tengah kemajuan era digital, Jakarta Selatan terus berkomitmen menjaga nyawa kebudayaan lokal Betawi melalui Perkampungan Budaya Betawi Setu Babakan. Saksikan festival seni mingguan, cicipi kuliner warisan, dan warisi tradisi untuk masa depan.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('culture') }}" class="px-6 py-3.5 bg-white hover:bg-emerald-50 text-slate-900 font-extrabold text-sm rounded-xl transition-all shadow-md inline-block">
                                Telusuri Budaya & Linimasa
                            </a>
                        </div>
                    </div>
                    
                    <!-- Decorative cultural icon representation -->
                    <div class="lg:col-span-4 flex justify-center" data-aos="zoom-in" data-aos-delay="300">
                        <div class="w-48 h-48 bg-white/10 backdrop-blur-md rounded-full border border-white/20 flex items-center justify-center shadow-lg transform rotate-3 group hover:rotate-12 transition-transform duration-500">
                            <div class="text-center p-6 text-white space-y-2 group-hover:scale-110 transition-transform duration-500">
                                <i class="bi bi-award-fill text-5xl block animate-bounce text-emerald-300"></i>
                                <span class="font-extrabold text-xs tracking-widest uppercase block text-emerald-300">Setu Babakan</span>
                                <span class="text-[10px] text-slate-300 font-medium block">Jakarta Selatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
