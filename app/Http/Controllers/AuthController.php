<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users',
            'telephone' => 'required',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:etudiant,proprietaire',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('logements.index')->with('success', 'Bienvenue ' . $user->prenom . ' !');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $identifiants = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($identifiants)) {
            $request->session()->regenerate();
            return redirect()->route('logements.index')->with('success', 'Connexion réussie');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous êtes déconnecté');
    }

    public function editProfil()
    {
        return view('auth.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required',
        ]);

        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('profil.edit')->with('success', 'Profil modifié avec succès');
    }
}
