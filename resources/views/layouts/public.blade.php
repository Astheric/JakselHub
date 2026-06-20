<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jaksel Hub - Nusantara Digital City. Menampilkan harmoni antara pesatnya inovasi teknologi urban dengan pelestarian ruang terbuka hijau dan budaya lokal Jakarta Selatan.">
    <title>@yield('title', 'Jaksel Hub – Nusantara Digital City')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- CSS and JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Leaflet.js for Maps (only loaded on Explore page) -->
    @yield('styles')
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    <!-- AlpineJS fallback if compiled script has delay -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50/50 text-slate-800 flex flex-col min-h-screen">

    <!-- Sticky Glassmorphic Header -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/90 border-b border-emerald-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-md shadow-emerald-200 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-2xl tracking-tight text-slate-900 group-hover:text-emerald-700 transition-colors">
                        Jaksel<span class="text-emerald-600 font-bold">Hub</span>
                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-sm font-semibold tracking-wide {{ Route::is('home') ? 'text-emerald-600 border-b-2 border-emerald-600 pb-1' : 'text-slate-600 hover:text-emerald-600' }} transition-all">Home</a>
                    <a href="{{ route('explore') }}" class="text-sm font-semibold tracking-wide {{ Route::is('explore') ? 'text-emerald-600 border-b-2 border-emerald-600 pb-1' : 'text-slate-600 hover:text-emerald-600' }} transition-all">Explore Jaksel</a>
                    <a href="{{ route('culture') }}" class="text-sm font-semibold tracking-wide {{ Route::is('culture') ? 'text-emerald-600 border-b-2 border-emerald-600 pb-1' : 'text-slate-600 hover:text-emerald-600' }} transition-all">Culture & Heritage</a>
                </nav>
                
                <!-- CTA / Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold rounded-xl text-sm border border-emerald-200 transition-colors shadow-sm">
                            Admin Panel
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-slate-500 hover:text-red-600 font-medium transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow-md shadow-emerald-200 hover:shadow-emerald-300 transition-all transform hover:-translate-y-0.5">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button (AlpineJS handled) -->
                <div class="md:hidden flex items-center" x-data="{ open: false }">
                    <button @click="open = !open" class="text-slate-600 hover:text-emerald-600 p-2 focus:outline-none" aria-label="Toggle menu">
                        <svg class="h-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <!-- Mobile Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute top-20 right-4 left-4 bg-white border border-emerald-100 shadow-xl rounded-2xl p-6 flex flex-col space-y-4">
                        <a href="{{ route('home') }}" class="text-base font-bold py-2 border-b border-slate-50 {{ Route::is('home') ? 'text-emerald-600' : 'text-slate-600' }}">Home</a>
                        <a href="{{ route('explore') }}" class="text-base font-bold py-2 border-b border-slate-50 {{ Route::is('explore') ? 'text-emerald-600' : 'text-slate-600' }}">Explore Jaksel</a>
                        <a href="{{ route('culture') }}" class="text-base font-bold py-2 border-b border-slate-50 {{ Route::is('culture') ? 'text-emerald-600' : 'text-slate-600' }}">Culture & Heritage</a>
                        
                        <div class="pt-4 flex flex-col space-y-3">
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="w-full text-center py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-md">
                                    Admin Panel
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-center py-2 text-slate-500 hover:text-red-600 font-medium">
                                        Keluar
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="w-full text-center py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-md shadow-emerald-200">Masuk</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Nature Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t-4 border-emerald-600 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <!-- Logo & Slogan -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white">
                            Jaksel<span class="text-emerald-400 font-bold">Hub</span>
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-sm mb-6 leading-relaxed">
                        Inisiatif integrasi digital terdepan di Jakarta Selatan untuk merepresentasikan modernitas tata kelola kota berbasis Smart Environment dan pelestarian warisan budaya Betawi.
                    </p>
                    <span class="text-xs text-emerald-400/80 px-3 py-1.5 bg-emerald-950/60 border border-emerald-900 rounded-full font-semibold">
                        🍃 Nusantara Digital City Ecosystem
                    </span>
                </div>
                
                <!-- Quick Sitemap -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Halaman Utama</a></li>
                        <li><a href="{{ route('explore') }}" class="hover:text-emerald-400 transition-colors">Panduan Wisata (Explore)</a></li>
                        <li><a href="{{ route('culture') }}" class="hover:text-emerald-400 transition-colors">Edukasi & Sejarah (Culture)</a></li>
                    </ul>
                </div>
                
                <!-- Target Audience Contacts -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h3>
                    <p class="text-sm text-slate-400 leading-relaxed mb-3">
                        Pemerintah Kota Administrasi Jakarta Selatan<br>
                        Gedung Walikota Jaksel, Kebayoran Baru
                    </p>
                    <a href="mailto:info@jakselhub.go.id" class="text-sm text-emerald-400 hover:underline">
                        info@jakselhub.go.id
                    </a>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Jaksel Hub – Nusantara Digital City. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6 mt-4 sm:mt-0">
                    <a href="#" class="hover:text-slate-300">Syarat Ketentuan</a>
                    <a href="#" class="hover:text-slate-300">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
