<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perte;
use Illuminate\Support\Facades\Auth;


class PerteController extends Controller
{
    /**
     * Afficher le formulaire de déclaration de perte
     */
    public function create()
    {
        return view('perte.create');
    }

    /**
     * Enregistrer la déclaration de perte
     */
    public function store(Request $request)
    {
        // 🔐 Validation des données (EN PREMIER)
        $validated = $request->validate([
            // Déclarant
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'contact' => 'required|string|max:30',
            'email' => 'required|email|max:255',

            // Pièce
            'type_piece' => 'required|string',
            'numero_piece' => 'nullable|string|max:100',
            'date_delivrance' => 'nullable|date',
            'autorite_delivrance' => 'nullable|string|max:255',

            // Perte
            'date_perte' => 'required|date',
            'lieu_perte' => 'nullable|string|max:255',
            'circonstances' => 'nullable|string',

            // Fichiers
            'copie_piece' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'declaration_vol' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'document_complementaire' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
 $validated['user_id'] = Auth::id(); // <-- ici
        /*
        |--------------------------------------------------------------------------
        | Upload des fichiers (si fournis)
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('copie_piece')) {
            $validated['copie_piece'] =
                $request->file('copie_piece')->store('pertes/copie_piece', 'public');
        }

        if ($request->hasFile('declaration_vol')) {
            $validated['declaration_vol'] =
                $request->file('declaration_vol')->store('pertes/declaration_vol', 'public');
        }

        if ($request->hasFile('document_complementaire')) {
            $validated['document_complementaire'] =
                $request->file('document_complementaire')->store('pertes/documents', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Enregistrement en base de données
        |--------------------------------------------------------------------------
        */
        $perte = Perte::create($validated);

        // ✅ Redirection après succès
        return redirect()
            ->route('dashboard')
            ->with('success', 'Votre déclaration de perte a été soumise avec succès.');
    }

    /**
     * Afficher toutes les déclarations
     */
    public function index()
    {
        $pertes = Perte::orderBy('created_at', 'desc')->get();
        return view('perte.index', compact('pertes'));
    }

    /**
     * Afficher une déclaration spécifique
     */
    public function show($id)
    {
        $perte = Perte::findOrFail($id);
        return view('perte.show', compact('perte'));
    }
}