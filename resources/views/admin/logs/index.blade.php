@extends('layouts.admin')

@section('header', 'Journal d\'activité')

@section('content')
<div class="rounded-xl bg-white shadow-sm border border-slate-200">
    <div class="p-6 border-b border-slate-200">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Utilisateur</label>
                <select name="utilisateur_id" class="w-full rounded-lg border-slate-300 text-sm">
                    <option value="">Tous</option>
                    @foreach ($utilisateurs as $utilisateur)
                        <option value="{{ $utilisateur->id }}" @selected(request('utilisateur_id') == $utilisateur->id)>{{ $utilisateur->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Action</label>
                <select name="action" class="w-full rounded-lg border-slate-300 text-sm">
                    <option value="">Toutes</option>
                    @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method)
                        <option value="{{ $method }}" @selected(request('action') === $method)>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Filtrer</button>
                <a href="{{ route('admin.logs.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-slate-500">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-slate-500">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-slate-500">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-slate-500">Route</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-slate-500">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $log->date->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $log->utilisateur?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">{{ $log->action }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $log->route }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $log->ip }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">Aucune activité enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
