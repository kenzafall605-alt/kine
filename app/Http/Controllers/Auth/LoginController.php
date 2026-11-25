<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Afficher la page de connexion.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion de l'utilisateur.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Vérifier si le compte est actif
            if (!Auth::user()->is_active) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Votre compte est désactivé.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Ces informations d’identification ne correspondent pas.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
} 
