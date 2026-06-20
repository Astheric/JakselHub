@extends('layouts.admin')

@section('title', 'Kelola Destinasi – Jaksel Hub')
@section('page_title', 'Kelola Direktori Wisata')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <p class="text-xs text-slate-500">Daftar lokasi wisata, taman kota, kuliner, dan area nongkrong terdata.</p>
        <div class="flex items-center space-x-3">
            <form action="{{ route('admin.destinations.sync') }}" method="POST" class="m-0" onsubmit="this.querySelector('button').innerHTML = '⏳ Menarik Data...'; this.querySelector('button').disabled = true;">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                    <span>🔄</span> Sinkronisasi API
                </button>
            </form>
            <a href="{{ route('admin.destinations.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <span>➕</span> Tambah Destinasi Baru
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
        @if($destinations->isEmpty())
            <div class="p-12 text-center text-slate-500">
                <span class="text-3xl block mb-2">📁</span>
                <p class="font-extrabold text-slate-700">Belum ada data destinasi wisata terdata.</p>
                <p class="text-xs text-slate-400 mt-1">Mulai isi dengan mengklik tombol tambah di atas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-extrabold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4">Nama Destinasi</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Alamat & Koordinat</th>
                            <th class="px-6 py-4">Integrasi Mobilitas</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($destinations as $dest)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <!-- Image & Name -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if($dest->image_path)
                                                <img src="{{ asset($dest->image_path) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-lg">🌳</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 block">{{ $dest->name }}</span>
                                            <span class="text-[10px] text-slate-400 block font-medium">Slug: {{ $dest->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Category -->
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-700 font-extrabold text-[10px] tracking-wider rounded-lg uppercase">
                                        {{ $dest->category }}
                                    </span>
                                </td>

                                <!-- Address & Coordinates -->
                                <td class="px-6 py-4 max-w-xs">
                                    <span class="text-xs text-slate-600 block line-clamp-1 mb-1">{{ $dest->address }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 block bg-slate-100/60 px-2 py-0.5 rounded-md w-fit">
                                        Lat: {{ $dest->latitude }}, Lng: {{ $dest->longitude }}
                                    </span>
                                </td>

                                <!-- Tags Integration -->
                                <td class="px-6 py-4 space-y-1">
                                    @if($dest->walkable)
                                        <span class="inline-block text-[9px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded mr-1">
                                            🚶 Walkable
                                        </span>
                                    @endif
                                    @if($dest->mrt_integrated)
                                        <span class="inline-block text-[9px] font-bold text-teal-800 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded">
                                            🚇 MRT Integrated
                                        </span>
                                    @endif
                                    @if(!$dest->walkable && !$dest->mrt_integrated)
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.destinations.edit', $dest->id) }}" class="p-2 bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 border border-slate-200 hover:border-emerald-200 rounded-xl transition-all font-semibold text-xs flex items-center justify-center">
                                            📝 Edit
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.destinations.destroy', $dest->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus destinasi {{ $dest->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-slate-50 hover:bg-red-50 text-slate-500 hover:text-red-700 border border-slate-200 hover:border-red-200 rounded-xl transition-all font-semibold text-xs flex items-center justify-center">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($destinations->hasPages())
                <div class="p-6 border-t border-slate-200">
                    {{ $destinations->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
