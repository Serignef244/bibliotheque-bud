<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForcePasswordController extends Controller
{
    public function create()
    {
        if (!auth()->user()->must_change_password) {
            return redirect()->route('adherent.dashboard');
        }
        return view('adherent.auth.force-password');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->must_change_password) {
            return redirect()->route('adherent.dashboard');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = auth()->user();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('adherent.dashboard')->with('success', 'Votre mot de passe a été modifié avec succès. Bienvenue !');
    }
}
