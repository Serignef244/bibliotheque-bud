@extends('layouts.adherent')

@section('title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-slate-900 tracking-tight">Notifications</h1>
            <p class="text-slate-500 mt-1">Restez informé de l'activité de votre compte.</p>
        </div>
        
        @if($notifications->count() > 0 && auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('adherent.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-white border border-slate-200 hover:border-editorial text-slate-700 hover:text-editorial text-sm font-medium rounded-full shadow-sm transition-all">
                    Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/60">
        @if($notifications->isEmpty())
            <div class="py-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-1">Aucune notification</h3>
                <p class="text-slate-500 text-sm">Vous n'avez pas de nouvelles notifications pour le moment.</p>
            </div>
        @else
            <div class="relative border-l border-slate-100 ml-4 space-y-8">
                @foreach($notifications as $notification)
                    @php
                        $type = $notification->data['type'] ?? 'info';
                        $colors = match($type) {
                            'success' => 'bg-emerald-100 text-emerald-600',
                            'warning' => 'bg-amber-100 text-amber-600',
                            'error' => 'bg-red-100 text-red-600',
                            default => 'bg-editorial-light/20 text-editorial',
                        };
                        $icon = match($type) {
                            'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />',
                            'warning' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
                            'error' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />',
                            default => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                        };
                    @endphp
                    
                    <div class="relative pl-8 group">
                        <!-- Ligne / Point -->
                        <span class="absolute -left-[17px] top-1 flex h-8 w-8 items-center justify-center rounded-full {{ $colors }} ring-8 ring-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>
                        </span>
                        
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="text-base font-semibold {{ $notification->read_at ? 'text-slate-700' : 'text-slate-900' }}">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                    </h4>
                                    @if(!$notification->read_at)
                                        <span class="px-2 py-0.5 rounded-full bg-editorial text-white text-[10px] font-bold uppercase tracking-wider">Nouveau</span>
                                    @endif
                                </div>
                                <p class="{{ $notification->read_at ? 'text-slate-500' : 'text-slate-700 font-medium' }}">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-slate-400 mt-2 font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            
                            @if(!$notification->read_at)
                                <form action="{{ route('adherent.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-400 hover:text-editorial rounded-full hover:bg-slate-50 transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100" title="Marquer comme lu">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
