<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForcePasswordController extends Controller
{
    public function create()
    {
        if (!auth()->user()->must_change_password) {
            return auth()->user()->hasRole(['admin', 'bibliothecaire']) 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('adherent.dashboard');
        }
        return view('auth.force-password');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->must_change_password) {
            return auth()->user()->hasRole(['admin', 'bibliothecaire']) 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('adherent.dashboard');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = auth()->user();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        $redirectRoute = $user->hasRole(['admin', 'bibliothecaire']) 
            ? 'admin.dashboard' 
            : 'adherent.dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Votre mot de passe a été modifié avec succès. Bienvenue !');
    }
}
