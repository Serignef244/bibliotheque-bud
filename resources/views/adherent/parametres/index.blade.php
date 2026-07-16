@extends('layouts.adherent')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-slate-900 tracking-tight">Paramètres</h1>
            <p class="text-slate-500 mt-1">Personnalisez votre expérience sur la plateforme.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden">
        
        <!-- Tabs (Visual only for now) -->
        <div class="flex overflow-x-auto border-b border-slate-100 p-4 gap-2">
            <button class="px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-medium transition-colors">Général</button>
            <button class="px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-xl text-sm font-medium transition-colors whitespace-nowrap">Notifications</button>
            <button class="px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-xl text-sm font-medium transition-colors whitespace-nowrap">Sécurité</button>
        </div>

        <div class="p-8 space-y-10">
            
            <!-- Apparence -->
            <section>
                <h3 class="font-serif text-xl font-semibold text-slate-900 mb-6">Apparence</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="relative flex flex-col items-center gap-3 p-4 border-2 border-editorial rounded-2xl cursor-pointer bg-editorial-50/50">
                        <input type="radio" name="theme" value="light" class="peer sr-only" checked>
                        <div class="w-full h-24 bg-white rounded-lg shadow-sm border border-slate-200 flex flex-col gap-2 p-2">
                            <div class="h-3 w-1/2 bg-slate-200 rounded"></div>
                            <div class="h-2 w-full bg-slate-100 rounded mt-auto"></div>
                            <div class="h-2 w-full bg-slate-100 rounded"></div>
                        </div>
                        <span class="font-medium text-editorial text-sm">Clair</span>
                    </label>

                    <label class="relative flex flex-col items-center gap-3 p-4 border-2 border-transparent hover:border-slate-200 rounded-2xl cursor-pointer opacity-50 grayscale" title="Bientôt disponible">
                        <input type="radio" name="theme" value="dark" class="peer sr-only" disabled>
                        <div class="w-full h-24 bg-slate-900 rounded-lg shadow-sm border border-slate-800 flex flex-col gap-2 p-2">
                            <div class="h-3 w-1/2 bg-slate-700 rounded"></div>
                            <div class="h-2 w-full bg-slate-800 rounded mt-auto"></div>
                            <div class="h-2 w-full bg-slate-800 rounded"></div>
                        </div>
                        <span class="font-medium text-slate-500 text-sm flex items-center gap-2">Sombre <span class="text-[10px] bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded">Bientôt</span></span>
                    </label>
                </div>
            </section>

            <!-- Préférences -->
            <section>
                <h3 class="font-serif text-xl font-semibold text-slate-900 mb-6">Préférences</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div>
                            <p class="font-medium text-slate-900">Langue de l'interface</p>
                            <p class="text-sm text-slate-500 mt-1">Choisissez la langue d'affichage de la plateforme.</p>
                        </div>
                        <select class="bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2 font-medium focus:ring-2 focus:ring-editorial focus:border-editorial">
                            <option value="fr" selected>Français</option>
                            <option value="en">English (Bientôt)</option>
                        </select>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
