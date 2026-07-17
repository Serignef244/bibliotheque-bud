{{-- Partiel récursif pour afficher un nœud de catégorie --}}
<li class="group">
    <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50 transition-colors"
         style="padding-left: {{ 24 + $niveau * 28 }}px">
        {{-- Icône niveau --}}
        @if($niveau > 0)
            <span class="text-slate-300 flex-shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        @else
            <span class="w-2 h-2 rounded-xl bg-indigo-400 flex-shrink-0"></span>
        @endif

        {{-- Nom + badge --}}
        <div class="flex-1 min-w-0">
            <span class="text-sm font-medium text-slate-800">{{ $categorie->nom }}</span>
            @if(! $categorie->actif)
                <span class="ml-2 text-xs text-slate-400">(inactif)</span>
            @endif
        </div>

        {{-- Nombre d'ouvrages --}}
        <span class="text-xs text-slate-400 hidden sm:block">{{ $categorie->ouvrages()->count() }} ouvrage(s)</span>

        {{-- Actions (visibles au survol) --}}
        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
            @can('update', $categorie)
            <a href="{{ route('admin.categories.edit', $categorie) }}"
               class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Modifier">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            @endcan
            @can('delete', $categorie)
            <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}"
                  onsubmit="return confirm('Supprimer « {{ $categorie->nom }} » ?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
            @endcan
        </div>
    </div>

    {{-- Enfants récursifs --}}
    @if($categorie->enfants->isNotEmpty())
        <ul class="divide-y divide-slate-50">
            @foreach($categorie->enfants as $enfant)
                @include('admin.categories._noeud', ['categorie' => $enfant, 'niveau' => $niveau + 1])
            @endforeach
        </ul>
    @endif
</li>
