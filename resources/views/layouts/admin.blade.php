<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — {{ config('app.name', 'BiblioSmart') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|inter:400,500,600,700&display=swap" rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    
    <!-- iOS Spécifique -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-192x192.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex lg:flex-col lg:flex-shrink-0">
            <div class="h-16 flex items-center justify-center border-b border-white/10 px-4 bg-white">
                <img src="{{ asset('images/logo.jpeg') }}" alt="BiblioSmart" class="h-10 object-contain">
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                @php
                    $menu = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.ouvrages.index', 'label' => 'Ouvrages', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['route' => 'admin.adherents.index', 'label' => 'Adhérents', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['route' => 'admin.prets.index', 'label' => 'Prêts', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        ['route' => 'admin.penalites.index', 'label' => 'Pénalités', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['route' => 'admin.statistiques.index', 'label' => 'Statistiques', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ['route' => 'admin.utilisateurs.index', 'label' => 'Administration', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'admin_only' => true],
                        ['route' => 'admin.parametres.index', 'label' => 'Paramètres', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'admin_only' => true],
                        ['route' => 'admin.logs.index', 'label' => 'Logs', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'admin_only' => true],
                        ['route' => 'admin.backups.index', 'label' => 'Sauvegardes', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'admin_only' => true],
                    ];
                @endphp
                @foreach ($menu as $item)
                    @if(Route::has($item['route']) && (!isset($item['admin_only']) || auth()->user()->hasRole('admin')))
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs($item['route'].'*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-lg font-semibold text-slate-900 hidden sm:block">@yield('header', 'Administration')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Déconnexion</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8 relative">
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile Only) -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 flex items-center justify-around z-40 pb-safe">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[10px] font-medium">Accueil</span>
        </a>
        <a href="{{ route('admin.ouvrages.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.ouvrages.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span class="text-[10px] font-medium">Ouvrages</span>
        </a>
        <a href="{{ route('admin.prets.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.prets.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            <span class="text-[10px] font-medium">Prêts</span>
        </a>
        <a href="{{ route('admin.adherents.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.adherents.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-[10px] font-medium">Adhérents</span>
        </a>
    </nav>

    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator.serviceWorker.register('/sw.js');
        });
      }
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
