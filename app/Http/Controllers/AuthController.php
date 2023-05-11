<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authenticatie succesvol, doorverwijzen naar de gewenste pagina
            return redirect('/dashboard');
        } else {
            // Authenticatie mislukt, doorverwijzen naar de loginpagina met een foutmelding
            return redirect()->back()->withErrors([
                'email' => 'Ongeldige inloggegevens.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
