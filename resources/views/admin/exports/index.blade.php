@extends('layouts.admin')

@section('header', 'Exports & Rapports')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50">
            <h2 class="text-2xl font-poppins font-bold text-slate-900">📤 Centre d'exportation</h2>
            <p class="text-slate-600 mt-2">Générez des rapports et exportez les données de la bibliothèque pour vos analyses externes.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.statistiques.export') }}" method="POST">
                @csrf
                
                <!-- Sélection des données -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        1. Sélectionner les données à exporter
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors border-slate-200 hover:border-blue-500 hover:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="type" value="ouvrages" class="sr-only" checked>
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-900 group-has-[:checked]:text-blue-900">📚 Ouvrages</p>
                                        <p class="text-slate-500">Liste complète du catalogue</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-xl border border-slate-300 group-has-[:checked]:border-[5px] group-has-[:checked]:border-blue-600"></div>
                            </div>
                        </label>

                        <label class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors border-slate-200 hover:border-blue-500 hover:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="type" value="adherents" class="sr-only">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-900 group-has-[:checked]:text-blue-900">👥 Adhérents</p>
                                        <p class="text-slate-500">Membres et statuts</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-xl border border-slate-300 group-has-[:checked]:border-[5px] group-has-[:checked]:border-blue-600"></div>
                            </div>
                        </label>

                        <label class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors border-slate-200 hover:border-blue-500 hover:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="type" value="prets" class="sr-only">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-900 group-has-[:checked]:text-blue-900">🔄 Prêts</p>
                                        <p class="text-slate-500">Historique des emprunts</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-xl border border-slate-300 group-has-[:checked]:border-[5px] group-has-[:checked]:border-blue-600"></div>
                            </div>
                        </label>

                        <label class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors border-slate-200 hover:border-blue-500 hover:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="type" value="penalites" class="sr-only">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-900 group-has-[:checked]:text-blue-900">💰 Pénalités</p>
                                        <p class="text-slate-500">Retards et amendes</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-xl border border-slate-300 group-has-[:checked]:border-[5px] group-has-[:checked]:border-blue-600"></div>
                            </div>
                        </label>

                        <label class="group relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors border-slate-200 hover:border-blue-500 hover:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600 has-[:checked]:bg-blue-50 md:col-span-2">
                            <input type="radio" name="type" value="statistiques" class="sr-only">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center">
                                    <div class="text-sm">
                                        <p class="font-bold text-slate-900 group-has-[:checked]:text-blue-900">📈 Rapport complet des statistiques</p>
                                        <p class="text-slate-500">Tous les indicateurs clés de performance (Recommandé en PDF)</p>
                                    </div>
                                </div>
                                <div class="h-5 w-5 rounded-xl border border-slate-300 group-has-[:checked]:border-[5px] group-has-[:checked]:border-blue-600"></div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Période -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        2. Période (Optionnel)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-slate-700 mb-1">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-slate-700 mb-1">Date de fin</label>
                            <input type="date" name="date_fin" id="date_fin" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Format -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        3. Format
                    </h3>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="format" value="excel" class="text-blue-600 focus:ring-blue-500" checked>
                            <span class="text-slate-700 font-medium">Excel (.xlsx)</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="format" value="csv" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-slate-700 font-medium">CSV (.csv)</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="format" value="pdf" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-slate-700 font-medium">PDF (.pdf)</span>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Télécharger le rapport
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
