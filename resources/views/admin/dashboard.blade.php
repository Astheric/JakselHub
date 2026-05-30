@extends('layouts.admin')

@section('title', 'Admin Overview – Jaksel Hub')
@section('page_title', 'Overview & Smart City Control')

@section('content')

    <!-- Statistics Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Destinations Count Card -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Total Destinasi Wisata</span>
                <p class="text-3xl font-black text-slate-900">{{ $destinationsCount }}</p>
                <a href="{{ route('admin.destinations.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold block pt-1">Kelola Destinasi &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-sm">
                🌳
            </div>
        </div>

        <!-- Timelines Count Card -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Milestone Sejarah Kota</span>
                <p class="text-3xl font-black text-slate-900">{{ $timelinesCount }}</p>
                <a href="{{ route('admin.timelines.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold block pt-1">Kelola Linimasa &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-sm">
                📜
            </div>
        </div>

        <!-- Galleries Count Card -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs uppercase tracking-wider font-extrabold text-slate-400">Galeri Budaya & Event</span>
                <p class="text-3xl font-black text-slate-900">{{ $cultureGalleriesCount }}</p>
                <a href="{{ route('admin.cultures.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold block pt-1">Kelola Budaya &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-sm">
                🎭
            </div>
        </div>

    </div>

    <!-- Smart City Form Section -->
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm max-w-2xl">
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                ⚙️ Kontrol Manual Metrik Smart City
            </h2>
            <p class="text-xs text-slate-500 mt-1">Formulir di bawah digunakan untuk mematangkan data real-time kota (AQI, Ruang Hijau, Transportasi Umum) apabila integrasi API terhambat.</p>
        </div>
        
        <form method="POST" action="{{ route('admin.metrics.update') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- AQI Index Field -->
                <div class="space-y-2">
                    <label for="aqi" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Air Quality Index (AQI)</label>
                    <input type="number" name="aqi" id="aqi" value="{{ $metrics ? $metrics->aqi : 50 }}" min="0" max="500" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                    <p class="text-[10px] text-slate-400">Skala indeks 0 - 500 (PM2.5)</p>
                </div>

                <!-- Green Spaces Count Field -->
                <div class="space-y-2">
                    <label for="green_spaces_count" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Total Ruang Hijau (RTH)</label>
                    <input type="number" name="green_spaces_count" id="green_spaces_count" value="{{ $metrics ? $metrics->green_spaces_count : 150 }}" min="0" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                    <p class="text-[10px] text-slate-400">Jumlah taman & hutan kota terdaftar</p>
                </div>

                <!-- Public Transport Count Field -->
                <div class="space-y-2">
                    <label for="public_transport_count" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Rute Transit Hijau</label>
                    <input type="number" name="public_transport_count" id="public_transport_count" value="{{ $metrics ? $metrics->public_transport_count : 25 }}" min="0" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                    <p class="text-[10px] text-slate-400">Total rute MRT & TJ terintegrasi</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                    Simpan Perubahan Metrik
                </button>
            </div>
        </form>
    </div>

@endsection
