<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioSmart - Accueil</title>
    
    <!-- PWA & iOS -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAF8; }
        h1, h2, h3, .font-playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased text-[#6B7280]">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Simple Logo Text -->
                <span class="font-playfair font-bold text-3xl text-[#1E3A8A] tracking-tight">BiblioSmart</span>
            </div>
            
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-[#3B82F6] hover:text-[#1E3A8A] font-medium transition-colors">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#1E3A8A] text-white font-medium rounded-lg hover:bg-[#3B82F6] transition-colors shadow-sm gap-2">
                            <span>🕊️</span> Connexion
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <!-- Bannière principale -->
    <section class="py-20 md:py-28 overflow-hidden relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-[#1E3A8A] font-medium text-sm mb-8 ring-1 ring-blue-100 shadow-sm">
                <span>⚡</span> Phase 0 terminée - Fondations Actives
            </div>
            
            <h1 class="text-4xl md:text-[48px] font-bold text-[#1E3A8A] leading-tight mb-6">
                Accédez au savoir de BiblioSmart
            </h1>
            
            <p class="text-lg md:text-xl text-[#6B7280] max-w-3xl mx-auto leading-relaxed">
                Une plateforme moderne et intuitive conçue pour la gestion des ouvrages, le suivi des adhérents, l'administration des prêts et le calcul des pénalités.
            </p>
        </div>
    </section>

    <!-- Grille des fonctionnalités -->
    <section class="py-16 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Carte 1 -->
                <div class="bg-[#FAFAF8] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                        📚
                    </div>
                    <h3 class="font-playfair text-2xl font-semibold text-[#1E3A8A] mb-4">Gestion des Ouvrages</h3>
                    <p class="text-[#6B7280] text-[14px] leading-relaxed">
                        CRUD complet, arborescence de catégories et codes-barres.
                    </p>
                </div>

                <!-- Carte 2 -->
                <div class="bg-[#FAFAF8] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                        👥
                    </div>
                    <h3 class="font-playfair text-2xl font-semibold text-[#1E3A8A] mb-4">Espace Adhérents</h3>
                    <p class="text-[#6B7280] text-[14px] leading-relaxed">
                        Inscriptions, cartes PDF avec QR-code et quotas personnalisés.
                    </p>
                </div>

                <!-- Carte 3 -->
                <div class="bg-[#FAFAF8] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                        🔄
                    </div>
                    <h3 class="font-playfair text-2xl font-semibold text-[#1E3A8A] mb-4">Prêts & Retours</h3>
                    <p class="text-[#6B7280] text-[14px] leading-relaxed">
                        Scan par code-barres, retards et alertes mail automatiques.
                    </p>
                </div>

                <!-- Carte 4 -->
                <div class="bg-[#FAFAF8] rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition-shadow duration-300 group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                        💰
                    </div>
                    <h3 class="font-playfair text-2xl font-semibold text-[#1E3A8A] mb-4">Gestion des Pénalités</h3>
                    <p class="text-[#6B7280] text-[14px] leading-relaxed">
                        Calcul d'amendes en FCFA, reçus PDF et blocages de prêts.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Comptes de test (Pour le jury) -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-[#1E3A8A]/10">
                <h2 class="font-playfair text-3xl font-bold text-[#1E3A8A] mb-8 text-center">Comptes de Test</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Admin -->
                    <div class="p-6 rounded-xl bg-blue-50/50 border border-blue-100">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#1E3A8A] text-white">👑</span>
                            <h3 class="font-semibold text-lg text-[#1E3A8A]">Administrateur</h3>
                        </div>
                        <p class="text-sm text-[#6B7280] mb-4">Accès total</p>
                        <div class="space-y-2 font-mono text-sm bg-white p-4 rounded-lg border border-gray-100">
                            <div class="flex justify-between"><span class="text-gray-500">Email:</span> <span class="font-medium text-slate-800">admin@admin.com</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Mdp:</span> <span class="font-medium text-slate-800">password</span></div>
                        </div>
                    </div>

                    <!-- Bibliothécaire -->
                    <div class="p-6 rounded-xl bg-green-50/50 border border-green-100">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#3B82F6] text-white">👓</span>
                            <h3 class="font-semibold text-lg text-[#1E3A8A]">Bibliothécaire</h3>
                        </div>
                        <p class="text-sm text-[#6B7280] mb-4">Gestion quotidienne</p>
                        <div class="space-y-2 font-mono text-sm bg-white p-4 rounded-lg border border-gray-100">
                            <div class="flex justify-between"><span class="text-gray-500">Email:</span> <span class="font-medium text-slate-800">biblio@biblio.com</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Mdp:</span> <span class="font-medium text-slate-800">password</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Appel à l'action (CTA) -->
    <section class="py-20 bg-[#1E3A8A] text-center px-4 sm:px-6 lg:px-8">
        <h2 class="font-playfair text-4xl font-bold text-white mb-6">Prêt à commencer ?</h2>
        <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">
            Connectez-vous pour accéder à l'application et découvrir l'ensemble des fonctionnalités de BiblioSmart.
        </p>
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#1E3A8A] font-bold rounded-lg hover:bg-gray-50 transition-colors shadow-lg gap-2 text-lg">
            🔑 Se connecter
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-[#6B7280] text-sm">
                &copy; {{ date('Y') }} BiblioSmart. Tous droits réservés.
            </p>
        </div>
    </footer>

</body>
</html>
