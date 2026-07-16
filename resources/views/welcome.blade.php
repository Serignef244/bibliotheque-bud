@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-50 pt-16 pb-32 sm:pt-24 sm:pb-40">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-editorial-50 text-editorial text-xs font-bold uppercase tracking-widest mb-8 border border-editorial/10">
            <span class="w-2 h-2 rounded-full bg-editorial animate-pulse"></span>
            Bibliothèque Universitaire
        </div>

        <h1 class="font-serif text-5xl sm:text-7xl font-bold text-slate-900 tracking-tight leading-[1.1] mb-8 max-w-4xl mx-auto">
            La connaissance<br>
            <span class="italic text-editorial">à portée de main.</span>
        </h1>
        
        <p class="text-lg sm:text-xl text-slate-500 leading-relaxed max-w-2xl mx-auto mb-10">
            Accédez à des milliers d'ouvrages académiques, gérez vos emprunts et explorez notre catalogue depuis une plateforme pensée pour votre réussite.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-editorial hover:bg-editorial-light text-white font-medium rounded-xl transition-all shadow-sm shadow-editorial/20 text-lg flex items-center justify-center gap-2 group">
                Commencer la lecture
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <a href="#catalogue" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-medium rounded-xl transition-all shadow-sm text-lg flex items-center justify-center">
                Explorer le catalogue
            </a>
        </div>
    </div>
    
    <!-- Cercle décoratif -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-editorial-50 rounded-full blur-[100px] pointer-events-none opacity-50"></div>
</div>

<!-- Features Section -->
<div class="bg-white py-24 sm:py-32 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 sm:gap-8">
            <!-- Feature 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-editorial-50 text-editorial rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-3">Vaste catalogue</h3>
                <p class="text-slate-500 leading-relaxed">Parcourez une collection riche et variée d'ouvrages physiques et numériques soigneusement classés.</p>
            </div>
            <!-- Feature 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-3">Gestion simplifiée</h3>
                <p class="text-slate-500 leading-relaxed">Suivez vos emprunts, prolongez vos prêts en un clic et restez informé des dates de retour.</p>
            </div>
            <!-- Feature 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-3">Alertes & Notifications</h3>
                <p class="text-slate-500 leading-relaxed">Soyez prévenu avant l'expiration de vos emprunts pour éviter les pénalités de retard.</p>
            </div>
        </div>
    </div>
</div>
@endsection
