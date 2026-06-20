@extends('layouts.public')

@section('title', 'Budaya & Sejarah – Jaksel Hub')

@section('content')

    <!-- Header Section -->
    <section class="bg-white border-b border-emerald-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl" data-aos="fade-up">
            <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                Culture & Heritage
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900 mt-4">Merawat Warisan, Menembus Masa Depan</h1>
            <p class="text-slate-500 text-sm sm:text-base mt-3 leading-relaxed">
                Telusuri perjalanan Jakarta Selatan dari kawasan resapan air alami yang subur menjadi megapolitan bisnis berteknologi tinggi, berdampingan secara harmonis dengan adat budaya Betawi yang terus dilestarikan.
            </p>
        </div>
    </section>

    <!-- History Timeline Section -->
    <section class="py-20 bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-2" data-aos="fade-up">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Linimasa Perkembangan Jaksel</h2>
                <p class="text-slate-500 text-xs sm:text-sm">Evolusi tata kota Jakarta Selatan menuju Smart City ramah lingkungan.</p>
            </div>
            
            <!-- Vertical Timeline Component -->
            <div class="relative wrap overflow-hidden p-10 h-full">
                <!-- Center Line -->
                <div class="border-2-2 absolute border-opacity-20 border-emerald-500 h-full border" style="left: 50%"></div>
                
                @if($timelines->isEmpty())
                <div class="bg-white border border-dashed border-slate-200 rounded-3xl p-12 text-center text-slate-500">
                    <span class="text-4xl block mb-2">📜</span>
                    <h3 class="font-extrabold text-slate-700 text-lg">Belum ada linimasa terdata</h3>
                    <p class="text-xs text-slate-400 mt-1">Gunakan panel admin untuk menambahkan linimasa sejarah baru.</p>
                </div>
                @else
                    @foreach($timelines as $index => $time)
                        @php
                            $isEven = $index % 2 === 0;
                        @endphp
                        
                        <!-- Timeline Row -->
                        <div class="mb-12 flex justify-between items-center w-full {{ $isEven ? 'flex-row-reverse' : 'left-timeline' }}" data-aos="{{ $isEven ? 'fade-right' : 'fade-left' }}">
                            <div class="order-1 w-5/12 hidden md:block"></div>
                            
                            <!-- Central Node Dot -->
                            <div class="z-20 flex items-center order-1 bg-emerald-600 shadow-xl w-8 h-8 rounded-full border-4 border-white justify-center" data-aos="zoom-in" data-aos-delay="200">
                                <span class="w-2.5 h-2.5 bg-white rounded-full"></span>
                            </div>
                            
                            <!-- Timeline Card Content -->
                            <div class="order-1 bg-white border border-emerald-50 rounded-3xl w-full md:w-5/12 p-6 sm:p-8 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-center justify-between gap-4 mb-3">
                                    <span class="text-xs font-black uppercase text-emerald-600 bg-emerald-50 px-3 py-1 rounded-md">
                                        {{ $time->year }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold">Milestone {{ $index + 1 }}</span>
                                </div>
                                <h3 class="mb-3 font-extrabold text-slate-900 text-lg sm:text-xl tracking-tight leading-tight">
                                    {{ $time->title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    {{ $time->description }}
                                </p>
                                
                                @if($time->image_path)
                                    <div class="mt-4 h-48 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
                                        <img src="{{ asset($time->image_path) }}" alt="{{ $time->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Cultural Grid Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4" data-aos="fade-up">
                <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                    Cultural Showcases
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Kekayaan Betawi Setu Babakan</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Eksplorasi ragam festival, keunikan sanggar kesenian, dan aneka event budaya Betawi bernuansa ramah lingkungan di jantung Jakarta Selatan.
                </p>
            </div>
            
            @if($cultures->isEmpty())
            <div class="border border-dashed border-slate-200 rounded-3xl p-12 text-center text-slate-500">
                <span class="text-4xl block mb-2">🎭</span>
                <h3 class="font-extrabold text-slate-700 text-lg">Belum ada kesenian terdata</h3>
                <p class="text-xs text-slate-400 mt-1">Gunakan panel admin untuk mengisi galeri kesenian Betawi.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cultures as $gal)
                <div class="group bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
                    
                    <!-- Image Showcase -->
                    <div class="h-56 bg-slate-100 relative overflow-hidden">
                        @if($gal->image_path)
                            <img src="{{ asset($gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-600/90 to-teal-950 flex flex-col items-center justify-center p-6 text-white text-center">
                                <span class="text-4xl mb-2">🎭</span>
                                <span class="font-bold text-sm tracking-wide border-b border-emerald-400/40 pb-0.5">{{ $gal->title }}</span>
                            </div>
                        @endif
                        
                        <!-- Category badge -->
                        <span class="absolute top-4 left-4 px-3 py-1 bg-white/95 text-slate-800 font-extrabold text-[10px] tracking-wider rounded-lg shadow-sm uppercase">
                            {{ $gal->category }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 space-y-3 flex-grow flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-lg text-slate-900 group-hover:text-emerald-600 transition-colors tracking-tight leading-tight">
                                {{ $gal->title }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-4">
                                {{ $gal->description }}
                            </p>
                        </div>
                        
                        <div class="border-t border-slate-50 pt-3 text-[10px] text-slate-400 flex justify-between items-center font-bold">
                            <span>🍃 Nusantara Digital City</span>
                            <span class="text-emerald-600">Terverifikasi Lestarikan Budaya</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

@endsection
