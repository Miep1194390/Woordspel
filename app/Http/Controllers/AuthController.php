<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login form showen functie
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Inlog functie
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Auth gelukt door naar dashboard pagina
            return redirect('/dashboard');
        } else {
            // Auth niet gelukt terug naar login pagina met error
            return redirect()->back()->withErrors([
                'email' => 'Ongeldige inloggegevens.',
            ]);
        }
    }

    // Uitlog functie
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
