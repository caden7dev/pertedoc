<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perte;
use App\Models\TypePiece;

class AdminController extends Controller
{
    /**
     * Tableau de bord Administrateur Général
     */
    public function index()
    {
        return view('admin.dashboard', [
            // 🔢 Statistiques globales
            'stats' => [
                'users' => User::count(),
                'types_pieces' => TypePiece::count(),
                'roles' => 3, // admin | agent | citoyen
                'pertes' => Perte::count(),
            ],

            // 👥 Derniers utilisateurs
            'users' => User::latest()->limit(5)->get(),

            // 🪪 Types de pièces
            'typesPieces' => TypePiece::all(),

            // 📊 Données statistiques (exemple)
            'chart' => [
                'labels' => ['CNI', 'Passeport', 'Acte de naissance'],
                'data' => [
                    Perte::where('type_piece', 'CNI')->count(),
                    Perte::where('type_piece', 'Passeport')->count(),
                    Perte::where('type_piece', 'Acte')->count(),
                ]
            ]
        ]);
    }
}
