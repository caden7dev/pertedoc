<?php

namespace App\Http\Controllers;

use App\Models\Perte;
use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    /**
     * Affiche le dashboard de l'agent
     */
    public function index()
    {
        // Récupérer toutes les pertes, triées par date décroissante
        $pertes = Perte::orderBy('created_at', 'desc')->get();

        return view('agent.dashboard', compact('pertes'));
    }

    /**
     * Valider une déclaration
     */
    public function valider(Perte $perte)
    {
        // Vérifier que la déclaration est en attente
        if ($perte->statut !== 'en attente') {
            return back()->with('error', 'Cette déclaration a déjà été traitée.');
        }

        // Mettre à jour le statut
        $perte->update([
            'statut' => 'validée',
            'date_traitement' => now(),
        ]);

        return back()->with('success', '✅ Déclaration validée avec succès.');
    }

    /**
     * Rejeter une déclaration
     */
    public function rejeter(Perte $perte)
    {
        // Vérifier que la déclaration est en attente
        if ($perte->statut !== 'en attente') {
            return back()->with('error', 'Cette déclaration a déjà été traitée.');
        }

        // Mettre à jour le statut
        $perte->update([
            'statut' => 'rejetée',
            'date_traitement' => now(),
        ]);

        return back()->with('success', '❌ Déclaration rejetée.');
    }

    /**
     * Afficher les détails d'une déclaration
     */
    public function show(Perte $perte)
    {
        return view('agent.perte.show', compact('perte'));
    }
}