@extends('layouts.admin')

@section('title', 'Ubah Budaya & Event – Jaksel Hub')
@section('page_title', 'Ubah Konten Budaya / Event')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.cultures.index') }}" class="text-xs text-slate-500 hover:text-emerald-600 font-bold">&larr; Kembali ke Daftar</a>
    </div>

    <!-- Form Panel -->
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm max-w-2xl">
        <form method="POST" action="{{ route('admin.cultures.update', $culture->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Title -->
                <div class="space-y-2 sm:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Judul Budaya / Event</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $culture->title) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Kategori</label>
                    <select name="category" id="category" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                        <option value="Kesenian" {{ old('category', $culture->category) === 'Kesenian' ? 'selected' : '' }}>Kesenian</option>
                        <option value="Festival" {{ old('category', $culture->category) === 'Festival' ? 'selected' : '' }}>Festival</option>
                        <option value="Event" {{ old('category', $culture->category) === 'Event' ? 'selected' : '' }}>Event Kreatif</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Deskripsi / Penjelasan Budaya</label>
                <textarea name="description" id="description" rows="6" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">{{ old('description', $culture->description) }}</textarea>
            </div>

            <!-- Image Upload and Preview -->
            <div class="space-y-3">
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Foto Kesenian / Event (Opsional)</label>
                
                @if($culture->image_path)
                    <div class="mb-3">
                        <p class="text-xs text-slate-400 mb-1.5">Foto Terunggah:</p>
                        <div class="w-40 h-28 bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                            <img src="{{ asset($culture->image_path) }}" alt="{{ $culture->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
                
                <input type="file" name="image" id="image" class="w-full text-slate-500 text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-[10px] text-slate-400">Pilih berkas baru jika ingin mengganti foto yang ada. JPEG, PNG, JPG, WEBP. Maks 2MB.</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.cultures.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

@endsection
