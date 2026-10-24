<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioSmart - Système Moderne de Gestion de Bibliothèque</title>
    
    <!-- PWA & iOS -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1E3A8A">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="BiblioSmart">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .gradient-brand {
            background: linear-gradient(135deg, #1E3A8A 0%, #2563EB 100%);
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(135deg, #1E3A8A 20%, #2563EB 80%);
        }
        .hero-pattern {
            background-image: radial-gradient(rgba(30, 58, 138, 0.07) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-700 selection:bg-secondary selection:text-white flex flex-col min-h-screen">

    <!-- Header / Navigation -->
    <header class="bg-white/85 backdrop-blur-md border-b border-slate-200/70 sticky top-0 z-50 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-900/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-poppins font-bold text-2xl text-primary tracking-tight leading-none">BiblioSmart</span>
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mt-0.5">Université & Instituts</span>
                </div>
            </div>
            
            <nav class="hidden md:flex items-center gap-8">
                <a href="#fonctionnalites" class="text-sm font-medium text-slate-600 hover:text-primary transition-colors">Fonctionnalités</a>
                <a href="#statistiques" class="text-sm font-medium text-slate-600 hover:text-primary transition-colors">Chiffres clés</a>
                <a href="#jury" class="text-sm font-medium text-slate-600 hover:text-primary transition-colors">Comptes Démo (Jury)</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ redirectByRole(auth()->user()) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow hover:-translate-y-0.5 active:scale-[0.98] transition-all gap-2">
                            <span>Mon Espace</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-primary hover:bg-blue-900 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow hover:-translate-y-0.5 active:scale-[0.98] transition-all gap-2">
                            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Connexion
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-16 pb-24 lg:pt-24 lg:pb-32 overflow-hidden hero-pattern border-b border-slate-200/70">
        <!-- Ambient Glow -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-blue-100/60 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-blue-200/80 text-primary font-semibold text-xs mb-8 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                </span>
                Projet de Soutenance — Déploiement Cloud Actif
            </div>
            
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-poppins font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-6 max-w-4xl mx-auto">
                Gérez votre bibliothèque <br/>
                <span class="gradient-text">intelligemment & en temps réel</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed mb-10">
                BiblioSmart est un système de gestion intégrée nouvelle génération. Centralisez vos ouvrages, automatisez les prêts et offrez un espace numérique fluide à vos étudiants et enseignants.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="#jury" class="w-full sm:w-auto inline-flex justify-center items-center px-7 py-3.5 bg-primary hover:bg-blue-900 text-white font-medium rounded-xl shadow-lg shadow-blue-900/20 hover:shadow-xl hover:-translate-y-0.5 active:scale-[0.98] transition-all text-base gap-2 group">
                    <span>Tester la Démo (Comptes Jury)</span>
                    <svg class="w-4 h-4 text-blue-200 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="#fonctionnalites" class="w-full sm:w-auto inline-flex justify-center items-center px-7 py-3.5 bg-white text-slate-700 border border-slate-300 font-medium rounded-xl hover:bg-slate-50 hover:border-slate-400 transition-all text-base shadow-sm">
                    Découvrir les fonctionnalités
                </a>
            </div>

            <!-- Product Showcase Mockup (Anti-Slop UI) -->
            <div class="max-w-4xl mx-auto rounded-2xl bg-white p-3 border border-slate-200/80 shadow-2xl shadow-blue-950/10">
                <div class="rounded-xl bg-slate-900 text-white p-6 sm:p-8 text-left relative overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                            <span class="text-xs text-slate-400 font-mono ml-2">bibliosmart.app/tableau-de-bord</span>
                        </div>
                        <span class="text-xs text-emerald-400 bg-emerald-950/60 border border-emerald-800 px-2.5 py-0.5 rounded-full font-mono">● Système Connecté</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-4">
                            <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Ouvrages Disponibles</div>
                            <div class="text-2xl font-bold font-poppins text-white">1 248</div>
                            <div class="text-xs text-emerald-400 mt-1 flex items-center gap-1">↑ 98.2% inventoriés</div>
                        </div>
                        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-4">
                            <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Prêts Actifs</div>
                            <div class="text-2xl font-bold font-poppins text-white">84</div>
                            <div class="text-xs text-blue-300 mt-1">4 retours prévus aujourd'hui</div>
                        </div>
                        <div class="bg-slate-800/80 border border-slate-700/60 rounded-xl p-4">
                            <div class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-1">Adhérents Inscrits</div>
                            <div class="text-2xl font-bold font-poppins text-white">412</div>
                            <div class="text-xs text-indigo-300 mt-1">Étudiants & Enseignants</div>
                        </div>
                    </div>

                    <!-- Sample book item -->
                    <div class="bg-slate-800/50 border border-slate-700/50 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white">Introduction aux Algorithmes (Cormen & Rivest)</div>
                                <div class="text-xs text-slate-400">Code: <span class="font-mono text-slate-300">ALG-2024-001</span> • Rayon Informatique A2</div>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Exemplaire Disponible
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques Section -->
    <section id="statistiques" class="py-16 bg-primary text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-blue-900 to-secondary opacity-80 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-blue-800/60">
                <div class="p-3">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-poppins mb-2 text-white">100%</div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider">Numérisé & Automatisé</div>
                </div>
                <div class="p-3">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-poppins mb-2 text-white">QR / Barcode</div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider">Cartes & Douchette</div>
                </div>
                <div class="p-3">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-poppins mb-2 text-white">24h/7j</div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider">Disponibilité Cloud</div>
                </div>
                <div class="p-3">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-poppins mb-2 text-white">3 Rôles</div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold uppercase tracking-wider">Admin, Biblio, Adhérent</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités Section -->
    <section id="fonctionnalites" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block text-xs font-bold text-secondary uppercase tracking-widest bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">Architecture & Modules</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-poppins text-slate-900 tracking-tight">Tout ce dont votre centre de documentation a besoin</h2>
                <p class="text-slate-600 mt-3 text-base">Conçu selon les normes MVC et Livewire pour une réactivité instantanée sans rechargement de page.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Carte 1 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-50 text-secondary rounded-xl flex items-center justify-center mb-5 border border-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Catalogue d'Ouvrages</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Gestion complète des livres, thèses et revues. Catégorisation intelligente et suivi en temps réel de chaque exemplaire physique.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Codes-barres uniques par exemplaire</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Couvertures hébergées sur Cloudinary</li>
                    </ul>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-5 border border-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Gestion des Adhérents</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Gestion des profils (Étudiants, Enseignants) avec règles de quotas de prêt distinctes et génération automatisée de cartes.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Cartes d'adhérent PDF téléchargeables</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Identification par QR Code d'adhérent</li>
                    </ul>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-5 border border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Circulation & Prêts</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Flux de prêt et retour ultra-rapide. Blocage intelligent si quota dépassé ou pénalité non régularisée.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Compatible douchette et lecteur code-barre</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Historique complet des transactions</li>
                    </ul>
                </div>

                <!-- Carte 4 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-5 border border-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Pénalités & Retards</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Calcul automatique des pénalités financières par jour de retard, avec encaissement et reçu de paiement.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Commande artisan cron de vérification</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Reçu de règlement imprimable</li>
                    </ul>
                </div>

                <!-- Carte 5 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-5 border border-amber-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Statistiques & Rapports</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Tableau de bord dynamique Chart.js : évolution mensuelle, top 5 des ouvrages les plus empruntés et export PDF.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Graphiques interactifs</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Exportation de rapport pour la direction</li>
                    </ul>
                </div>

                <!-- Carte 6 -->
                <div class="bg-white rounded-2xl p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center mb-5 border border-sky-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-slate-900 mb-2">Emails Automatisés</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Notifications automatiques par email via SMTP Brevo : relances de retour à J-3, alertes de retard et confirmations.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> File d'attente asynchrone (Queue Jobs)</li>
                        <li class="flex items-center gap-2"><span class="text-emerald-600 font-bold">✓</span> Templates emails soignés aux couleurs du projet</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Comptes Démo Jury Section (Anti-Slop & Conçu Spécialement pour la Soutenance) -->
    <section id="jury" class="py-24 bg-white border-y border-slate-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block text-xs font-bold text-primary uppercase tracking-widest bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">Accès Démonstration</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-poppins text-slate-900 tracking-tight">Comptes configurés pour le Jury</h2>
                <p class="text-slate-600 max-w-2xl mx-auto mt-2 text-base">Utilisez ces comptes pré-remplis pour tester tous les rôles et permissions de BiblioSmart lors de la soutenance.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Admin Card -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-blue-200/70 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-primary bg-blue-100/70 px-2.5 py-1 rounded-full uppercase tracking-wider">Super Admin</span>
                            <span class="text-xl">👑</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 font-poppins">Administrateur</h3>
                        <p class="text-xs text-slate-500 mb-4">Accès total : gestion des utilisateurs, sauvegardes, journal d'audit et statistiques.</p>
                        
                        <div class="bg-white rounded-xl p-3.5 border border-slate-200 font-mono text-xs space-y-2 mb-6">
                            <div class="flex justify-between items-center text-slate-600">
                                <span class="text-slate-400 font-sans text-[11px]">Email :</span>
                                <span class="font-semibold text-slate-800 select-all">admin@bibliotheque.local</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600 border-t border-slate-100 pt-2">
                                <span class="text-slate-400 font-sans text-[11px]">Mot de passe :</span>
                                <span class="font-semibold text-slate-800 select-all">Admin12345!</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-primary hover:bg-blue-900 text-white text-xs font-semibold rounded-xl transition-all shadow-sm gap-1.5">
                        <span>Se connecter en Admin</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Bibliothécaire Card -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-emerald-200/70 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-full uppercase tracking-wider">Opérationnel</span>
                            <span class="text-xl">📚</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 font-poppins">Bibliothécaire</h3>
                        <p class="text-xs text-slate-500 mb-4">Gestion quotidienne : catalogue, sorties/retours d'ouvrages, encaissement des pénalités.</p>
                        
                        <div class="bg-white rounded-xl p-3.5 border border-slate-200 font-mono text-xs space-y-2 mb-6">
                            <div class="flex justify-between items-center text-slate-600">
                                <span class="text-slate-400 font-sans text-[11px]">Email :</span>
                                <span class="font-semibold text-slate-800 select-all">bibliothecaire@bibliotheque.local</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600 border-t border-slate-100 pt-2">
                                <span class="text-slate-400 font-sans text-[11px]">Mot de passe :</span>
                                <span class="font-semibold text-slate-800 select-all">Biblio12345!</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl transition-all shadow-sm gap-1.5">
                        <span>Se connecter en Bibliothécaire</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Adhérent Card -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-indigo-200/70 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-100/70 px-2.5 py-1 rounded-full uppercase tracking-wider">Adhérent</span>
                            <span class="text-xl">🎓</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 font-poppins">Étudiant / Adhérent</h3>
                        <p class="text-xs text-slate-500 mb-4">Espace personnel : consultation du catalogue, suivi de ses prêts en cours et carte membre.</p>
                        
                        <div class="bg-white rounded-xl p-3.5 border border-slate-200 font-mono text-xs space-y-2 mb-6">
                            <div class="flex justify-between items-center text-slate-600">
                                <span class="text-slate-400 font-sans text-[11px]">Email :</span>
                                <span class="font-semibold text-slate-800 select-all">adherent@bibliotheque.local</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600 border-t border-slate-100 pt-2">
                                <span class="text-slate-400 font-sans text-[11px]">Mot de passe :</span>
                                <span class="font-semibold text-slate-800 select-all">Adherent12345!</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white text-xs font-semibold rounded-xl transition-all shadow-sm gap-1.5">
                        <span>Se connecter en Adhérent</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-primary hover:bg-blue-900 text-white font-medium rounded-xl shadow-lg shadow-blue-900/15 hover:shadow-xl hover:-translate-y-0.5 active:scale-[0.98] transition-all gap-2">
                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>Accéder au Portail de Connexion</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-auto border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-secondary rounded-lg flex items-center justify-center text-white font-bold">
                        B
                    </div>
                    <div>
                        <span class="font-poppins font-bold text-xl text-white tracking-tight">BiblioSmart</span>
                        <p class="text-xs text-slate-500">Projet de fin d'études — Licence / Master</p>
                    </div>
                </div>
                
                <div class="text-xs text-slate-400 text-center md:text-right">
                    Développé avec Laravel, Livewire & Tailwind CSS.<br/>
                    &copy; {{ date('Y') }} BiblioSmart. Tous droits réservés.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
