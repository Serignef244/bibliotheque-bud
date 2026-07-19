@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-50 pt-16 pb-24 sm:pt-24 sm:pb-32">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 text-primary text-xs font-bold uppercase tracking-widest mb-8 border border-primary/10">
            <span class="w-2 h-2 rounded-xl bg-secondary animate-pulse"></span>
            BiblioSmart
        </div>

        <h1 class="font-poppins text-5xl sm:text-7xl font-bold text-slate-900 tracking-tight leading-[1.1] mb-8 max-w-4xl mx-auto">
            Accédez au savoir de <br>
            <span class="italic text-primary">BiblioSmart.</span>
        </h1>
        
        <p class="text-lg sm:text-xl text-slate-700 leading-relaxed max-w-2xl mx-auto mb-10">
            Une plateforme moderne et intuitive conçue pour la gestion des ouvrages, le suivi des adhérents, l'administration des prêts et le calcul des pénalités.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-all shadow-sm shadow-secondary/20 text-lg flex items-center justify-center gap-2 group">
                Se connecter
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="#test-accounts" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-medium rounded-xl transition-all shadow-sm text-lg flex items-center justify-center">
                Voir les comptes de test
            </a>
        </div>
    </div>
    
    <!-- Cercle décoratif -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-slate-50 rounded-xl blur-[100px] pointer-events-none opacity-50"></div>
</div>

<!-- Features Section -->
<div class="bg-white py-24 sm:py-32 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 sm:gap-8">
            <!-- Feature 1 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-primary rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">📚</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Gestion des Ouvrages</h3>
                <p class="text-sm text-slate-700 leading-relaxed">CRUD complet, arborescence de catégories et codes-barres.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">👥</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Espace Adhérents</h3>
                <p class="text-sm text-slate-700 leading-relaxed">Inscriptions, cartes PDF avec QR-code et quotas personnalisés.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-amber-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">🔄</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Prêts & Retours</h3>
                <p class="text-sm text-slate-700 leading-relaxed">Scan par code-barres, retards et alertes mail automatiques.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">💰</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Gestion des Pénalités</h3>
                <p class="text-sm text-slate-700 leading-relaxed">Calcul d'amendes en FCFA, reçus PDF et blocages de prêts.</p>
            </div>
        </div>
    </div>
</div>

<!-- Test Accounts Section -->
<div id="test-accounts" class="bg-slate-50 py-24 sm:py-32 border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-6 sm:px-10">
        <div class="text-center mb-16">
            <h2 class="font-poppins text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Comptes de Test</h2>
            <p class="text-slate-700 text-lg">Utilisez ces identifiants pour vous connecter et tester les fonctionnalités.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Admin Account -->
            <div class="bg-white rounded-3xl p-8 border border-primary/20 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-secondary"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-slate-900">Administrateur</h3>
                        <span class="text-xs font-semibold uppercase tracking-wider text-primary">Accès total</span>
                    </div>
                </div>
                
                <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Email</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">admin@bibliotheque.local</code>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Mot de passe</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">Admin12345!</code>
                    </div>
                </div>
            </div>

            <!-- Librarian Account -->
            <div class="bg-white rounded-3xl p-8 border border-secondary/20 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-blue-300"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-slate-900">Bibliothécaire</h3>
                        <span class="text-xs font-semibold uppercase tracking-wider text-secondary">Gestion quotidienne</span>
                    </div>
                </div>
                
                <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Email</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">bibliothecaire@bibliotheque.local</code>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Mot de passe</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">Biblio12345!</code>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA -->
        <div class="mt-16 text-center">
            <h3 class="font-poppins text-2xl font-bold text-slate-900 mb-6">Prêt à commencer ?</h3>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-primary hover:bg-slate-800 text-white font-medium rounded-xl transition-all shadow-lg shadow-primary/20 text-lg gap-2 group">
@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-50 pt-16 pb-24 sm:pt-24 sm:pb-32">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 text-primary text-xs font-bold uppercase tracking-widest mb-8 border border-primary/10">
            <span class="w-2 h-2 rounded-xl bg-secondary animate-pulse"></span>
            BiblioSmart
        </div>

        <h1 class="font-poppins text-5xl sm:text-7xl font-bold text-slate-900 tracking-tight leading-[1.1] mb-8 max-w-4xl mx-auto">
            Accédez au savoir de <br>
            <span class="italic text-primary">BiblioSmart.</span>
        </h1>
        
        <p class="text-lg sm:text-xl text-slate-500 leading-relaxed max-w-2xl mx-auto mb-10">
            Une plateforme moderne et intuitive conçue pour la gestion des ouvrages, le suivi des adhérents, l'administration des prêts et le calcul des pénalités.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-all shadow-sm shadow-secondary/20 text-lg flex items-center justify-center gap-2 group">
                Se connecter
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="#test-accounts" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-medium rounded-xl transition-all shadow-sm text-lg flex items-center justify-center">
                Voir les comptes de test
            </a>
        </div>
    </div>
    
    <!-- Cercle décoratif -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-slate-50 rounded-xl blur-[100px] pointer-events-none opacity-50"></div>
</div>

<!-- Features Section -->
<div class="bg-white py-24 sm:py-32 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 sm:gap-8">
            <!-- Feature 1 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-primary rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">📚</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Gestion des Ouvrages</h3>
                <p class="text-sm text-slate-500 leading-relaxed">CRUD complet, arborescence de catégories et codes-barres.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">👥</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Espace Adhérents</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Inscriptions, cartes PDF avec QR-code et quotas personnalisés.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-amber-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">🔄</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Prêts & Retours</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Scan par code-barres, retards et alertes mail automatiques.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-14 h-14 bg-white text-rose-500 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="text-2xl">💰</span>
                </div>
                <h3 class="font-poppins text-xl font-bold text-slate-900 mb-3">Gestion des Pénalités</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Calcul d'amendes en FCFA, reçus PDF et blocages de prêts.</p>
            </div>
        </div>
    </div>
</div>

<!-- Test Accounts Section -->
<div id="test-accounts" class="bg-slate-50 py-24 sm:py-32 border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-6 sm:px-10">
        <div class="text-center mb-16">
            <h2 class="font-poppins text-3xl sm:text-4xl font-bold text-slate-900 mb-4">Comptes de Test</h2>
            <p class="text-slate-500 text-lg">Utilisez ces identifiants pour vous connecter et tester les fonctionnalités.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Admin Account -->
            <div class="bg-white rounded-3xl p-8 border border-primary/20 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-secondary"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-slate-900">Administrateur</h3>
                        <span class="text-xs font-semibold uppercase tracking-wider text-primary">Accès total</span>
                    </div>
                </div>
                
                <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Email</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">admin@bibliotheque.local</code>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Mot de passe</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">Admin12345!</code>
                    </div>
                </div>
            </div>

            <!-- Librarian Account -->
            <div class="bg-white rounded-3xl p-8 border border-secondary/20 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-secondary to-blue-300"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-slate-900">Bibliothécaire</h3>
                        <span class="text-xs font-semibold uppercase tracking-wider text-secondary">Gestion quotidienne</span>
                    </div>
                </div>
                
                <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Email</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">bibliothecaire@bibliotheque.local</code>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Mot de passe</span>
                        <code class="text-sm font-semibold text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">Biblio12345!</code>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA -->
        <div class="mt-16 text-center">
            <h3 class="font-poppins text-2xl font-bold text-slate-900 mb-6">Prêt à commencer ?</h3>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-primary hover:bg-slate-800 text-white font-medium rounded-xl transition-all shadow-lg shadow-primary/20 text-lg gap-2 group">
                Se connecter
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>
@endsection
