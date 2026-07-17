@extends('layouts.admin')

@section('header', 'Paramètres généraux')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50">
            <h2 class="text-2xl font-poppins font-bold text-slate-900">⚙️ Configuration de la bibliothèque</h2>
            <p class="text-slate-600 mt-2">Gérez les paramètres globaux de l'application.</p>
        </div>

        <form action="{{ route('admin.parametres.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-12">
                <!-- Informations générales -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Informations générales
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nom de la bibliothèque</label>
                            <input type="text" name="biblio_nom" value="{{ $settings['general']['biblio_nom'] ?? '' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Adresse</label>
                            <input type="text" name="biblio_adresse" value="{{ $settings['general']['biblio_adresse'] ?? '' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label>
                            <input type="text" name="biblio_telephone" value="{{ $settings['general']['biblio_telephone'] ?? '' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email de contact</label>
                            <input type="email" name="biblio_email" value="{{ $settings['general']['biblio_email'] ?? '' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </section>

                <!-- Gestion des prêts -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Gestion des prêts
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Durée de prêt par défaut</label>
                            <div class="relative">
                                <input type="number" min="1" name="pret_duree" value="{{ $settings['prets']['pret_duree'] ?? '14' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-16">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">jours</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Max de prolongations</label>
                            <input type="number" min="0" name="pret_max_prolongations" value="{{ $settings['prets']['pret_max_prolongations'] ?? '1' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Durée d'une prolongation</label>
                            <div class="relative">
                                <input type="number" min="1" name="pret_duree_prolongation" value="{{ $settings['prets']['pret_duree_prolongation'] ?? '7' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-16">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">jours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Pénalités -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pénalités de retard
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tarif Étudiant</label>
                            <div class="relative">
                                <input type="number" min="0" name="penalite_etudiant" value="{{ $settings['penalites']['penalite_etudiant'] ?? '100' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-24">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">FCFA / jour</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tarif Enseignant</label>
                            <div class="relative">
                                <input type="number" min="0" name="penalite_enseignant" value="{{ $settings['penalites']['penalite_enseignant'] ?? '50' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-24">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">FCFA / jour</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tarif Externe</label>
                            <div class="relative">
                                <input type="number" min="0" name="penalite_externe" value="{{ $settings['penalites']['penalite_externe'] ?? '250' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-24">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">FCFA / jour</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Seuil de blocage du compte</label>
                            <div class="relative">
                                <input type="number" min="0" name="penalite_seuil_blocage" value="{{ $settings['penalites']['penalite_seuil_blocage'] ?? '1000' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pr-16">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-slate-500 sm:text-sm">FCFA</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Au-delà de ce montant impayé, l'adhérent ne peut plus emprunter.</p>
                        </div>
                    </div>
                </section>

                <!-- Notifications -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifications
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <div class="flex items-center h-6">
                                <input type="checkbox" name="notif_rappel" value="true" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ ($settings['notifications']['notif_rappel'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">Rappel d'échéance</p>
                                <p class="text-sm text-slate-500">Envoyer un rappel 3 jours avant la date de retour prévue.</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <div class="flex items-center h-6">
                                <input type="checkbox" name="notif_retard" value="true" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ ($settings['notifications']['notif_retard'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">Notification de retard</p>
                                <p class="text-sm text-slate-500">Envoyer une notification dès le premier jour de retard.</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <div class="flex items-center h-6">
                                <input type="checkbox" name="notif_confirmation" value="true" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ ($settings['notifications']['notif_confirmation'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">Confirmation de prêt</p>
                                <p class="text-sm text-slate-500">Envoyer un récapitulatif par email lors d'un nouvel emprunt.</p>
                            </div>
                        </label>
                    </div>
                </section>
            </div>

            <div class="p-6 border-t border-slate-200 bg-slate-50 flex justify-end gap-3 rounded-b-2xl">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Enregistrer les paramètres
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
