@extends('layouts.guest')

@section('title', 'Accueil')
@section('container_width', 'max-w-5xl')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
    <!-- Left Column: Hero & Features -->
    <div class="lg:col-span-7 space-y-6 text-left">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-semibold tracking-wide uppercase">
            ⚡ Phase 0 terminée - Fondations Actives
        </div>
        
        <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
            Accédez au savoir de la <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">Bibliothèque BUD</span>
        </h1>
        
        <p class="text-slate-400 text-base md:text-lg max-w-xl">
            Une plateforme moderne et intuitive conçue pour la gestion des ouvrages, le suivi des adhérents, l'administration des prêts et le calcul des pénalités.
        </p>

        <!-- Feature cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:border-indigo-500/30 transition-all duration-300">
                <div class="h-9 w-9 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-3">
                    📚
                </div>
                <h3 class="font-bold text-white text-sm">Gestion des Ouvrages</h3>
                <p class="text-xs text-slate-500 mt-1">CRUD complet, arborescence de catégories et codes-barres.</p>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:border-violet-500/30 transition-all duration-300">
                <div class="h-9 w-9 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-400 mb-3">
                    👥
                </div>
                <h3 class="font-bold text-white text-sm">Espace Adhérents</h3>
                <p class="text-xs text-slate-500 mt-1">Inscriptions, cartes PDF avec QR-code et quotas personnalisés.</p>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:border-fuchsia-500/30 transition-all duration-300">
                <div class="h-9 w-9 rounded-lg bg-fuchsia-500/10 flex items-center justify-center text-fuchsia-400 mb-3">
                    🔄
                </div>
                <h3 class="font-bold text-white text-sm">Prêts & Retours</h3>
                <p class="text-xs text-slate-500 mt-1">Scan par code-barres, retards et alertes mail automatiques.</p>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:border-pink-500/30 transition-all duration-300">
                <div class="h-9 w-9 rounded-lg bg-pink-500/10 flex items-center justify-center text-pink-400 mb-3">
                    💰
                </div>
                <h3 class="font-bold text-white text-sm">Gestion des Pénalités</h3>
                <p class="text-xs text-slate-500 mt-1">Calcul d'amendes en FCFA, reçus PDF et blocages de prêts.</p>
            </div>
        </div>
    </div>

    <!-- Right Column: Portal Entry & Seeded Accounts -->
    <div class="lg:col-span-5 w-full">
        <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-2xl p-6 sm:p-8 space-y-6 text-left relative overflow-hidden">
            <!-- Glow effect inside card -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>

            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-white">Prêt à commencer ?</h2>
                <p class="text-sm text-slate-400">Connectez-vous pour accéder à l'application.</p>
            </div>

            <!-- Login button -->
            <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:opacity-95 text-white py-3 text-base font-bold shadow-lg shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 text-center">
                Se connecter
            </a>

            <!-- Divider -->
            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-slate-800"></div>
                <span class="flex-shrink mx-4 text-slate-600 text-xs font-bold uppercase tracking-wider">Comptes de Test</span>
                <div class="flex-grow border-t border-slate-800"></div>
            </div>

            <!-- Preseeded accounts -->
            <div class="space-y-3">
                <div class="p-3.5 rounded-xl bg-slate-950/50 border border-slate-800/80 hover:border-slate-700 transition-colors text-sm">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-indigo-400">Administrateur</span>
                        <span class="text-xs bg-indigo-500/10 text-indigo-400 px-2 py-0.5 rounded border border-indigo-500/20">Accès total</span>
                    </div>
                    <div class="text-slate-400 text-xs font-mono select-all">Email : admin@bibliotheque.local</div>
                    <div class="text-slate-400 text-xs font-mono">Mot de passe : <span class="select-all">Admin12345!</span></div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-950/50 border border-slate-800/80 hover:border-slate-700 transition-colors text-sm">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-emerald-400">Bibliothécaire</span>
                        <span class="text-xs bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20">Gestion quotidienne</span>
                    </div>
                    <div class="text-slate-400 text-xs font-mono select-all">Email : bibliothecaire@bibliotheque.local</div>
                    <div class="text-slate-400 text-xs font-mono">Mot de passe : <span class="select-all">Biblio12345!</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
