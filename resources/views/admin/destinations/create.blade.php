@extends('layouts.admin')

@section('title', 'Tambah Destinasi Wisata – Jaksel Hub')
@section('page_title', 'Tambah Destinasi Baru')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.destinations.index') }}" class="text-xs text-slate-500 hover:text-emerald-600 font-bold">&larr; Kembali ke Daftar</a>
    </div>

    <!-- Form Panel -->
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm max-w-3xl">
        <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Nama Lokasi</label>
                    <input type="text" name="name" id="name" placeholder="Misal: Taman Langsat" value="{{ old('name') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori</label>
                    <select name="category" id="category" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Ruang Terbuka Hijau" {{ old('category') === 'Ruang Terbuka Hijau' ? 'selected' : '' }}>🌳 Ruang Terbuka Hijau</option>
                        <option value="Heritage" {{ old('category') === 'Heritage' ? 'selected' : '' }}>🏮 Warisan Budaya (Heritage)</option>
                        <option value="Aesthetic Cafe" {{ old('category') === 'Aesthetic Cafe' ? 'selected' : '' }}>☕ Aesthetic Cafe</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Deskripsi Detail</label>
                <textarea name="description" id="description" rows="5" placeholder="Tuliskan ulasan lengkap, sejarah singkat, kelebihan, dan nuansa tempat..." required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">{{ old('description') }}</textarea>
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Alamat Lengkap</label>
                <input type="text" name="address" id="address" placeholder="Misal: Jl. Langsat No.1, Kramat Pela, Kebayoran Baru" value="{{ old('address') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Latitude -->
                <div class="space-y-2">
                    <label for="latitude" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Latitude (Garis Lintang)</label>
                    <input type="number" step="0.000001" name="latitude" id="latitude" placeholder="Misal: -6.244302" value="{{ old('latitude') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Longitude -->
                <div class="space-y-2">
                    <label for="longitude" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Longitude (Garis Bujur)</label>
                    <input type="number" step="0.000001" name="longitude" id="longitude" placeholder="Misal: 106.793739" value="{{ old('longitude') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>
            </div>

            <!-- Image Upload -->
            <div class="space-y-2">
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Foto Lokasi</label>
                <input type="file" name="image" id="image" class="w-full text-slate-500 text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-[10px] text-slate-400">Format yang didukung: JPEG, PNG, JPG, WEBP. Maks 2MB.</p>
            </div>

            <!-- Checkbox Integrasi Mobilitas -->
            <div class="pt-4 border-t border-slate-100 space-y-4">
                <h3 class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Integrasi Hijau</h3>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- Walkable -->
                    <label class="relative flex items-center cursor-pointer">
                        <input type="checkbox" name="walkable" value="1" {{ old('walkable') ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ml-3 text-sm font-semibold text-slate-700">🏃 Ramah Pejalan Kaki (Walkable)</span>
                    </label>

                    <!-- MRT -->
                    <label class="relative flex items-center cursor-pointer">
                        <input type="checkbox" name="mrt_integrated" value="1" {{ old('mrt_integrated') ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-teal-600"></div>
                        <span class="ml-3 text-sm font-semibold text-slate-700">🚇 Dekat Stasiun MRT (Integrated)</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.destinations.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                    Simpan Destinasi
                </button>
            </div>

        </form>
    </div>

@endsection
