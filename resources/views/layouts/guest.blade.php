<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'BiblioSmart'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- PWA & iOS Spécifique -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/icon-192x192.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-600 min-h-screen relative selection:bg-secondary selection:text-white flex flex-col">
    <!-- Header Minimaliste -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="BiblioSmart" class="h-12 object-contain">
            </a>
            
            <!-- Navigation -->
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ redirectByRole(auth()->user()) }}" class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors">
                        Mon Espace
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-secondary hover:bg-blue-500 text-white px-6 py-2.5 text-sm font-medium shadow-sm transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                        Me connecter
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col relative z-10 w-full @yield('main_classes', '')">
        @if (session('status'))
            <div class="max-w-md mx-auto w-full mt-8 px-4">
                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 text-sm text-emerald-600 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="max-w-md mx-auto w-full mt-8 px-4">
                <div class="rounded-xl bg-red-50 border border-red-100 p-4 text-sm text-red-600 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @hasSection('content')
            @yield('content')
        @else
            <!-- Formulaires (Login, etc.) centrés -->
            <div class="flex-1 flex items-center justify-center px-4 py-12">
                <div class="w-full @yield('container_width', 'max-w-md') transition-all duration-500">
                    <div class="bg-white border border-slate-200/60 shadow-sm rounded-3xl p-8 sm:p-10 relative overflow-hidden">
                        <!-- Ligne décorative haute -->
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-secondary"></div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer Minimaliste -->
    @if(!View::hasSection('hide_footer'))
        <footer class="bg-white border-t border-slate-200/60 py-8 text-center text-sm text-slate-500 mt-auto">
            <div class="max-w-7xl mx-auto px-6">
                <p>&copy; {{ date('Y') }} BiblioSmart. Tous droits réservés.</p>
            </div>
        </footer>
    @endif
</body>
</html>
