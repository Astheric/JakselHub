@extends('layouts.admin')

@section('title', 'Kelola Linimasa – Jaksel Hub')
@section('page_title', 'Kelola Linimasa Sejarah')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <p class="text-xs text-slate-500">Linimasa perkembangan kota dari kawasan resapan air hingga menjadi metropolitan hijau terintegrasi.</p>
        <a href="{{ route('admin.timelines.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center gap-1.5">
            <span>➕</span> Tambah Milestone Baru
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
        @if($timelines->isEmpty())
            <div class="p-12 text-center text-slate-500">
                <span class="text-3xl block mb-2">📜</span>
                <p class="font-extrabold text-slate-700">Belum ada linimasa sejarah terdata.</p>
                <p class="text-xs text-slate-400 mt-1">Mulai tambahkan dengan mengklik tombol di atas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-extrabold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4 w-20">Urutan</th>
                            <th class="px-6 py-4 w-32">Tahun/Era</th>
                            <th class="px-6 py-4">Judul Peristiwa</th>
                            <th class="px-6 py-4">Deskripsi Sejarah</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($timelines as $time)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <!-- Order -->
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-800 font-extrabold text-[11px] rounded-lg">
                                        #{{ $time->order }}
                                    </span>
                                </td>
                                
                                <!-- Year/Era -->
                                <td class="px-6 py-4">
                                    <span class="font-black text-emerald-600 tracking-tight">{{ $time->year }}</span>
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-800 block">{{ $time->title }}</span>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4 max-w-sm">
                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $time->description }}</p>
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.timelines.edit', $time->id) }}" class="p-2 bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 border border-slate-200 hover:border-emerald-200 rounded-xl transition-all font-semibold text-xs flex items-center justify-center">
                                            📝 Edit
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.timelines.destroy', $time->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus milestone era {{ $time->year }}?')">
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
        @endif
    </div>

@endsection
