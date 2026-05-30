@extends('layouts.admin')

@section('title', 'Tambah Milestone Sejarah – Jaksel Hub')
@section('page_title', 'Tambah Milestone Linimasa')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.timelines.index') }}" class="text-xs text-slate-500 hover:text-emerald-600 font-bold">&larr; Kembali ke Daftar</a>
    </div>

    <!-- Form Panel -->
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm max-w-2xl">
        <form method="POST" action="{{ route('admin.timelines.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Year/Era -->
                <div class="space-y-2 sm:col-span-2">
                    <label for="year" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Era / Tahun</label>
                    <input type="text" name="year" id="year" placeholder="Misal: 1970an atau Abad ke-19" value="{{ old('year') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>

                <!-- Order -->
                <div class="space-y-2">
                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Urutan Tampil</label>
                    <input type="number" name="order" id="order" placeholder="Misal: 1" value="{{ old('order', 1) }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
                </div>
            </div>

            <!-- Title -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Judul Peristiwa Sejarah</label>
                <input type="text" name="title" id="title" placeholder="Misal: Wilayah Resapan Air Subur" value="{{ old('title') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Deskripsi Linimasa</label>
                <textarea name="description" id="description" rows="5" placeholder="Tuliskan peristiwa sejarah secara mendalam dan pengaruhnya terhadap penataan kota Jakarta Selatan..." required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition-colors">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="space-y-2">
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Foto Terkait Sejarah (Opsional)</label>
                <input type="file" name="image" id="image" class="w-full text-slate-500 text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <p class="text-[10px] text-slate-400">JPEG, PNG, JPG, WEBP. Maks 2MB.</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.timelines.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                    Simpan Milestone
                </button>
            </div>

        </form>
    </div>

@endsection
