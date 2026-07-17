<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Mail\CompteUtilisateurCree;
use App\Models\Setting;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Ne lister que le personnel (ceux qui ont un rôle admin ou bibliothecaire, ou du moins exclure 'adherent')
        $query = User::whereHas('roles', function($q) {
            $q->where('name', '!=', 'adherent');
        })->with('roles')->latest();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->get('role'));
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::where('name', '!=', 'adherent')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'adherent')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $password = Str::password(12, true, true, true, false);

        $user = clone(new User());
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($password);
        $user->must_change_password = true; // Always force change on first login
        $user->save();

        $user->assignRole($validated['roles']);

        $biblioNom = Setting::get('biblio_nom', 'BiblioSmart');
        Mail::to($user->email)->send(new CompteUtilisateurCree($user, $password, $biblioNom));

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès. Un email contenant ses identifiants lui a été envoyé.');
    }

    public function edit(User $utilisateur)
    {
        $roles = Role::where('name', '!=', 'adherent')->get();
        $userRoles = $utilisateur->roles->pluck('name')->toArray();
        
        return view('admin.users.edit', [
            'user' => $utilisateur,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    public function update(Request $request, User $utilisateur)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $utilisateur->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $utilisateur->name = $validated['name'];
        $utilisateur->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $utilisateur->password = Hash::make($validated['password']);
        }
        
        $utilisateur->must_change_password = $request->has('must_change_password');
        $utilisateur->save();

        $utilisateur->syncRoles($validated['roles']);

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $utilisateur)
    {
        if ($utilisateur->id === auth()->id()) {
            return redirect()->route('admin.utilisateurs.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
