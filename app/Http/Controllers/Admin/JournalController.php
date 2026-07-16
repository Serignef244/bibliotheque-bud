<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalActivite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(Request $request): View
    {
        $query = JournalActivite::query()
            ->with('utilisateur')
            ->orderByDesc('date');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->string('date'));
        }

        if ($request->filled('utilisateur_id')) {
            $query->where('utilisateur_id', $request->integer('utilisateur_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        $logs = $query->paginate(20)->withQueryString();
        $utilisateurs = User::orderBy('name')->get(['id', 'name']);

        return view('admin.logs.index', compact('logs', 'utilisateurs'));
    }
}
