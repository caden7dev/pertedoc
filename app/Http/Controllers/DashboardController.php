<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perte; // ⚠ Assure-toi que ce modèle existe et pointe sur la table "pertes"

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // utilisateur connecté

        // Récupérer toutes les pertes de l'utilisateur
        $pertes = Perte::where('user_id', $user->id)->latest()->get();

        // Statistiques
        $totalDeclarations = $pertes->count();
        $enAttente = $pertes->where('statut', 'en attente')->count();
        $validees = $pertes->where('statut', 'validée')->count();

        // Les dernières déclarations (tu peux limiter à 5)
        $dernieresDeclarations = $pertes->take(5);

        return view('dashboard', compact(
            'user', 
            'totalDeclarations', 
            'enAttente', 
            'validees', 
            'dernieresDeclarations'
        ));
    }
}
