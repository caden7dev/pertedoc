<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // ta page forget-password
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Générer le token sans envoyer le mail
        $status = Password::broker()->createToken(
            \App\Models\User::where('email', $request->email)->first()
        );

        // Générer l'URL complète
        $url = url(route('password.reset', [
            'token' => $status,
            'email' => $request->email
        ], false));

        // Afficher sur la page
        return back()->with('reset_link', $url)->with('status', 'Lien de réinitialisation généré !');
    }
}
