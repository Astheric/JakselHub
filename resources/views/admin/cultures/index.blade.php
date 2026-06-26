@extends('layouts.admin')

@section('title', 'Kelola Budaya – Jaksel Hub')
@section('page_title', 'Kelola Galeri Budaya & Event')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <p class="text-xs text-slate-500">Daftar kesenian Betawi, festival adat di Setu Babakan, dan event kreatif di Jakarta Selatan.</p>
        <a href="{{ route('admin.cultures.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5">
            <i class="bi bi-plus-lg"></i> Tambah Budaya/Event Baru
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
        @if($galleries->isEmpty())
            <div class="p-12 text-center text-slate-500">
                <i class="bi bi-masks text-3xl block mb-2 text-slate-300"></i>
                <p class="font-extrabold text-slate-700">Belum ada data budaya terdata.</p>
                <p class="text-xs text-slate-400 mt-1">Mulai isi dengan mengklik tombol tambah di atas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-extrabold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4">Judul Konten</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Deskripsi Singkat</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($galleries as $gal)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <!-- Image & Title -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if($gal->image_path)
                                                <img src="{{ asset($gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="bi bi-masks text-lg text-slate-400"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 block">{{ $gal->title }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Category -->
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-700 font-extrabold text-[10px] tracking-wider rounded-lg uppercase">
                                        {{ $gal->category }}
                                    </span>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4 max-w-sm">
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $gal->description }}</p>
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.cultures.edit', $gal->id) }}" class="p-2 bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 border border-slate-200 hover:border-emerald-200 rounded-xl transition-all font-semibold text-xs flex items-center justify-center">
                                            <i class="bi bi-pencil-square mr-1"></i> Edit
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.cultures.destroy', $gal->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten budaya {{ $gal->title }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-slate-50 hover:bg-red-50 text-slate-500 hover:text-red-700 border border-slate-200 hover:border-red-200 rounded-xl transition-all font-semibold text-xs flex items-center justify-center">
                                                <i class="bi bi-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
