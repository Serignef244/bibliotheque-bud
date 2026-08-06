<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioSmart - La solution moderne de gestion de bibliothèque</title>
    
    <!-- PWA & iOS -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAF8; }
        h1, h2, h3, h4, .font-playfair { font-family: 'Playfair Display', serif; }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(90deg, #1E3A8A, #3B82F6);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231e3a8a' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="antialiased text-gray-600 selection:bg-[#3B82F6] selection:text-white flex flex-col min-h-screen">

    <!-- Header / Navigation -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1E3A8A] rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-900/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-playfair font-bold text-2xl text-[#1E3A8A] tracking-tight">BiblioSmart</span>
            </div>
            
            <nav class="hidden md:flex items-center gap-8">
                <a href="#fonctionnalites" class="text-sm font-medium text-gray-600 hover:text-[#1E3A8A] transition-colors">Fonctionnalités</a>
                <a href="#statistiques" class="text-sm font-medium text-gray-600 hover:text-[#1E3A8A] transition-colors">Chiffres clés</a>
                <a href="#jury" class="text-sm font-medium text-gray-600 hover:text-[#1E3A8A] transition-colors">Accès Jury</a>
            </nav>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#1E3A8A] text-white text-sm font-medium rounded-lg hover:bg-[#3B82F6] transition-all shadow-md shadow-blue-900/10 hover:shadow-lg">
                            Accéder au Tableau de Bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-[#1E3A8A] text-white text-sm font-medium rounded-lg hover:bg-[#3B82F6] transition-all shadow-md shadow-blue-900/10 hover:shadow-lg gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Connexion
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-32 overflow-hidden bg-white hero-pattern border-b border-gray-100">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#FAFAF8] opacity-80 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50/80 backdrop-blur border border-blue-100 text-[#1E3A8A] font-medium text-sm mb-8 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#3B82F6] animate-pulse"></span>
                Phase Finale - Déploiement Cloud Actif
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-[#1E3A8A] leading-tight mb-8">
                Gérez votre bibliothèque <br/>
                <span class="gradient-text font-playfair italic">intelligemment</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed mb-10">
                BiblioSmart est le système de gestion intégrée nouvelle génération. Centralisez vos ouvrages, fluidifiez les prêts et offrez une expérience moderne à vos adhérents.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#jury" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 bg-[#1E3A8A] text-white font-medium rounded-xl hover:bg-[#152c6b] transition-all shadow-xl shadow-blue-900/20 text-lg">
                    Tester l'application
                </a>
                <a href="#fonctionnalites" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-4 bg-white text-[#1E3A8A] border border-gray-200 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all text-lg">
                    Découvrir les fonctionnalités
                </a>
            </div>
        </div>
    </section>

    <!-- Statistiques Section -->
    <section id="statistiques" class="py-12 bg-[#1E3A8A] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/10">
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold font-playfair mb-2">100%</div>
                    <div class="text-blue-200 text-sm font-medium uppercase tracking-wider">Numérisé</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold font-playfair mb-2">QR</div>
                    <div class="text-blue-200 text-sm font-medium uppercase tracking-wider">Génération auto</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold font-playfair mb-2">24/7</div>
                    <div class="text-blue-200 text-sm font-medium uppercase tracking-wider">Disponibilité Cloud</div>
                </div>
                <div class="p-4">
                    <div class="text-4xl md:text-5xl font-bold font-playfair mb-2">3</div>
                    <div class="text-blue-200 text-sm font-medium uppercase tracking-wider">Rôles Utilisateurs</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Section -->
    <section id="fonctionnalites" class="py-24 bg-[#FAFAF8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-sm font-bold text-[#3B82F6] tracking-widest uppercase mb-3">Un outil complet</h2>
                <h3 class="text-4xl font-bold text-[#1E3A8A] font-playfair">Tout ce dont vous avez besoin pour administrer votre centre de ressources</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Carte 1 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-blue-50 text-[#3B82F6] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Catalogue d'Ouvrages</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Gérez vos livres, magazines et revues. Classez-les par catégories, attribuez des auteurs et suivez l'état exact de chaque exemplaire physique.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Codes-barres uniques</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Couvertures via Cloudinary</li>
                    </ul>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Gestion des Adhérents</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Suivez vos membres, définissez des types d'adhérents (Étudiant, Professeur) avec des quotas de prêts différents et des alertes sur cotisation.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Génération de Cartes PDF</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Authentification via QR Code</li>
                    </ul>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Circulation & Prêts</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Rendez vos processus d'emprunt et de retour fluides. Le système empêche automatiquement les prêts si le quota est atteint ou si une pénalité est active.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Scan rapide à la douchette</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Historique complet</li>
                    </ul>
                </div>

                <!-- Carte 4 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Automatisation des Pénalités</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Fini les calculs manuels. En cas de retard de restitution, le système applique les règles définies et gère le règlement avec édition de reçu financier.
                    </p>
                </div>

                <!-- Carte 5 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Tableaux de bord Analytiques</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Prenez les bonnes décisions grâce à des statistiques visuelles (Chart.js) : évolution des prêts, top 5 des ouvrages, revenus des pénalités...
                    </p>
                </div>

                <!-- Carte 6 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 bg-sky-50 text-sky-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="font-playfair text-xl font-bold text-[#1E3A8A] mb-3">Communication par Email</h4>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Connecté à un serveur SMTP (Brevo), BiblioSmart notifie automatiquement les utilisateurs (retards, inscription, alertes de disponibilité).
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Comptes de test (Pour le jury) -->
    <section id="jury" class="py-24 bg-white border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#1E3A8A] font-playfair mb-4">Testez la plateforme</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ces comptes ont été pré-configurés pour la soutenance afin de vous permettre de tester les différents rôles et privilèges de BiblioSmart.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Admin -->
                <div class="p-8 rounded-2xl bg-gradient-to-br from-[#1E3A8A]/5 to-[#3B82F6]/5 border border-blue-100 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-100 rounded-full opacity-50"></div>
                    <div class="flex items-center gap-4 mb-6 relative">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#1E3A8A] text-white shadow-lg shadow-blue-900/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-[#1E3A8A]">Administrateur</h3>
                            <p class="text-sm text-[#3B82F6] font-medium">Accès Total (Super Admin)</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 font-mono text-sm bg-white p-5 rounded-xl border border-blue-50 shadow-sm relative">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 border-b border-gray-50 pb-2">
                            <span class="text-gray-400 font-sans text-xs uppercase tracking-wider">Email de connexion</span> 
                            <span class="font-semibold text-gray-800 select-all">admin@bibliotheque.local</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 pt-1">
                            <span class="text-gray-400 font-sans text-xs uppercase tracking-wider">Mot de passe</span> 
                            <span class="font-semibold text-gray-800 select-all">Admin12345!</span>
                        </div>
                    </div>
                </div>

                <!-- Bibliothécaire -->
                <div class="p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50/30 border border-green-100 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-100 rounded-full opacity-50"></div>
                    <div class="flex items-center gap-4 mb-6 relative">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg shadow-green-900/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-emerald-900">Bibliothécaire</h3>
                            <p class="text-sm text-emerald-600 font-medium">Gestion Quotidienne</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 font-mono text-sm bg-white p-5 rounded-xl border border-green-50 shadow-sm relative">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 border-b border-gray-50 pb-2">
                            <span class="text-gray-400 font-sans text-xs uppercase tracking-wider">Email de connexion</span> 
                            <span class="font-semibold text-gray-800 select-all">bibliothecaire@bibliotheque.local</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 pt-1">
                            <span class="text-gray-400 font-sans text-xs uppercase tracking-wider">Mot de passe</span> 
                            <span class="font-semibold text-gray-800 select-all">Biblio12345!</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-[#1E3A8A] text-white font-medium rounded-xl hover:bg-[#3B82F6] transition-all shadow-lg shadow-blue-900/20 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Accéder au portail de connexion
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="font-playfair font-bold text-2xl text-white tracking-tight">BiblioSmart</span>
                </div>
                
                <div class="text-sm">
                    Développé pour la soutenance de projet de fin d'études.
                </div>
                
                <div class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} BiblioSmart. Tous droits réservés.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
