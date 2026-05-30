<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard – Jaksel Hub')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS and JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    <!-- AlpineJS fallback -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 flex min-h-screen">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between flex-shrink-0 z-30 shadow-lg">
        <div>
            <!-- Sidebar Header -->
            <div class="h-20 bg-slate-950 flex items-center justify-center px-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <span class="w-6 h-6 bg-emerald-500 rounded-md flex items-center justify-center text-white font-extrabold text-sm">J</span>
                    <span class="font-extrabold text-lg text-white tracking-wide">CMS Control</span>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <nav class="p-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all {{ Route::is('admin.dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span>📊</span>
                    <span>Overview & Metrics</span>
                </a>
                <a href="{{ route('admin.destinations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all {{ Route::is('admin.destinations.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span>🌳</span>
                    <span>Destinasi Wisata</span>
                </a>
                <a href="{{ route('admin.timelines.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all {{ Route::is('admin.timelines.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span>📜</span>
                    <span>Linimasa Sejarah</span>
                </a>
                <a href="{{ route('admin.cultures.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all {{ Route::is('admin.cultures.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <span>🎭</span>
                    <span>Galeri Budaya</span>
                </a>
            </nav>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="p-6 border-t border-slate-800 bg-slate-950 space-y-4">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center space-x-2 w-full py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs rounded-xl border border-slate-700 transition-all shadow-sm">
                <span>🌐</span>
                <span>Lihat Website</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full text-center py-2 text-xs font-bold text-slate-500 hover:text-red-400 transition-colors">
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Bar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10">
            <div>
                <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-slate-500">
                    <span>👤</span>
                    <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold rounded-full uppercase">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </header>

        <!-- Main Body Workspace -->
        <main class="flex-grow p-8 overflow-y-auto">
            <!-- Success/Error Alerts -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                    <span class="text-lg">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl shadow-sm text-sm">
                    <div class="flex items-center gap-3 font-bold mb-2 text-red-950">
                        <span class="text-lg">🚨</span>
                        <span>Ada kesalahan dalam pengisian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside pl-4 text-xs space-y-1 text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
