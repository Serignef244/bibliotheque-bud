<!DOCTYPE html>
<html lang="fr" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — {{ config('app.name', 'BiblioSmart') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    
    <!-- iOS Spécifique -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">
    <link rel="apple-touch-icon" href="/icons/icon-180x180.png" sizes="180x180">
    <link rel="apple-touch-icon" href="/icons/icon-167x167.png" sizes="167x167">
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="/icons/icon-120x120.png" sizes="120x120">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800 selection:bg-secondary selection:text-white">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-primary text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex lg:flex-col lg:flex-shrink-0 border-r border-white/10 shadow-xl lg:shadow-none">
            
            <!-- Logo Header -->
            <div class="h-20 flex items-center justify-between border-b border-white/10 px-6 bg-white">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="BiblioSmart" class="h-11 object-contain">
                </a>
                <span class="text-[10px] font-bold uppercase tracking-wider text-primary bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                    {{ auth()->user()->hasRole('admin') ? 'Super Admin' : 'Biblio' }}
                </span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                <!-- Modules Métiers -->
                <div>
                    <p class="px-3 text-[11px] font-bold text-blue-200/60 uppercase tracking-widest mb-2">Gestion Métier</p>
                    <div class="space-y-1">
                        @php
                            $metierMenu = [
                                ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                ['route' => 'admin.ouvrages.index', 'label' => 'Ouvrages & Exemplaires', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                ['route' => 'admin.adherents.index', 'label' => 'Adhérents & Cartes', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                                ['route' => 'admin.prets.index', 'label' => 'Prêts & Retours', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                                ['route' => 'admin.penalites.index', 'label' => 'Pénalités & Reçus', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['route' => 'admin.statistiques.index', 'label' => 'Statistiques & Export', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ];
                        @endphp
                        @foreach ($metierMenu as $item)
                            @if(Route::has($item['route']))
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition-all duration-200 group {{ request()->routeIs($item['route'].'*') ? 'bg-white/15 text-white shadow-sm border-l-4 border-secondary font-semibold pl-3' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs($item['route'].'*') ? 'text-secondary' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Système & Propriétaire (Super Admin) -->
                @if(auth()->user()->hasRole('admin'))
                    <div>
                        <p class="px-3 text-[11px] font-bold text-amber-300/70 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <span>👑</span>
                            <span>Espace Propriétaire</span>
                        </p>
                        <div class="space-y-1">
                            @php
                                $adminMenu = [
                                    ['route' => 'admin.utilisateurs.index', 'label' => 'Comptes Utilisateurs', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                                    ['route' => 'admin.parametres.index', 'label' => 'Configuration Système', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'],
                                    ['route' => 'admin.logs.index', 'label' => 'Journal d\'Audit (Logs)', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                    ['route' => 'admin.backups.index', 'label' => 'Sauvegardes BD', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12'],
                                ];
                            @endphp
                            @foreach ($adminMenu as $item)
                                @if(Route::has($item['route']))
                                    <a href="{{ route($item['route']) }}"
                                       class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm transition-all duration-200 group {{ request()->routeIs($item['route'].'*') ? 'bg-white/15 text-white shadow-sm border-l-4 border-amber-400 font-semibold pl-3' : 'text-blue-100/80 hover:bg-white/10 hover:text-white' }}">
                                        <svg class="h-5 w-5 {{ request()->routeIs($item['route'].'*') ? 'text-amber-300' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </nav>

            <!-- User Widget & Logout in Sidebar -->
            <div class="p-4 border-t border-white/10 space-y-3">
                <div class="px-3.5 py-3 rounded-2xl bg-white/10 border border-white/10 flex items-center gap-3">
                    <img class="h-10 w-10 rounded-xl object-cover border border-white/20 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563EB&color=fff" alt="">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-block text-[10px] font-semibold text-blue-200 uppercase tracking-wider">
                            {{ auth()->user()->hasRole('admin') ? '👑 Propriétaire' : '📚 Bibliothécaire' }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-blue-100 hover:bg-rose-500/10 hover:text-rose-300 text-xs font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Se déconnecter</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
            <!-- Header -->
            <header class="h-20 bg-white/85 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="hidden sm:block">
                        <div class="text-base sm:text-lg font-bold font-poppins text-slate-900 leading-none">
                            @yield('header', 'Administration')
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium mt-1 inline-block">Portail de Gestion & Administration</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors">
                        <span>Voir le site</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <!-- User Pill -->
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <p class="text-xs font-bold text-slate-800 leading-none">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] font-semibold text-primary uppercase tracking-wider mt-0.5 inline-block">
                                {{ auth()->user()->hasRole('admin') ? 'Super Admin' : 'Bibliothécaire' }}
                            </span>
                        </div>
                        <img class="h-9 w-9 rounded-xl object-cover border border-slate-200 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1E3A8A&color=fff" alt="">
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8 relative">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-800 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bottom Navigation (Mobile Only) -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 flex items-center justify-around z-40 pb-safe">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('admin.ouvrages.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.ouvrages.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span class="text-[10px] font-medium">Ouvrages</span>
        </a>
        <a href="{{ route('admin.adherents.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.adherents.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="text-[10px] font-medium">Adhérents</span>
        </a>
        <a href="{{ route('admin.prets.index') }}" class="flex flex-col items-center p-3 {{ request()->routeIs('admin.prets.*') ? 'text-primary' : 'text-slate-400 hover:text-slate-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            <span class="text-[10px] font-medium">Prêts</span>
        </a>
    </nav>

    @livewireScripts
    @stack('scripts')
</body>
</html>
