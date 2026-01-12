<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request)
{
    $request->validate([
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'gender' => 'required|in:male,female',
        'nationality' => 'required|string',
        'email' => 'required|string|email|max:255|unique:users,email',
        'address' => 'required|string|max:255',
        'password' => 'required|string|confirmed|min:8',
        'phone' => 'nullable|string|max:20',  // Ajout du phone (optionnel)
    ]);

    // Créer le nom complet
    $fullName = $request->first_name . ' ' . $request->last_name;

    // ✅ Créer l'utilisateur avec TOUTES les données
    $user = User::create([
        'name' => $fullName,
        'last_name' => $request->last_name,        // ✅ Ajouté
        'first_name' => $request->first_name,      // ✅ Ajouté
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'contact' => $request->phone,              // ✅ Ajouté (phone du formulaire)
        'address' => $request->address,            // ✅ Ajouté
        'birth_date' => $request->birth_date,      // ✅ Ajouté
        'gender' => $request->gender,              // ✅ Ajouté
        'nationality' => $request->nationality,    // ✅ Ajouté
    ]);

 

    event(new Registered($user));

   
    

   return redirect()->route('login')->with('status', 'Inscription réussie ! Veuillez vous connecter.');
}

}
