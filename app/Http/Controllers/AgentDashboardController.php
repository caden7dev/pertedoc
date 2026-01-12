<?php

namespace App\Http\Controllers;

use App\Models\Perte;
use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    public function index()
    {
        $pertes = Perte::orderBy('created_at', 'desc')->get();

        return view('agent.dashboard', compact('pertes'));
    }

    public function valider(Perte $perte)
    {
        $perte->update([
            'statut' => 'validée',
            'date_traitement' => now(),
        ]);

        return back()->with('success', 'Déclaration validée avec succès.');
    }

    public function rejeter(Perte $perte)
    {
        $perte->update([
            'statut' => 'rejetée',
            'date_traitement' => now(),
        ]);

        return back()->with('success', 'Déclaration rejetée.');
    }
}
