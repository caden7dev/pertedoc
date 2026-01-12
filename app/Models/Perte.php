<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perte extends Model
{
    use HasFactory;

    protected $table = 'pertes'; // Nom de la table

    // Champs pouvant être remplis via Mass Assignment
    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'contact',
        'email',
        'type_piece',
        'numero_piece',
        'date_delivrance',
        'autorite_delivrance',
        'date_perte',
        'lieu_perte',
        'circonstances',
        'copie_piece',
        'declaration_vol',
        'document_complementaire',
        'statut', // si tu veux gérer "en attente"/"validée"
        'date_declaration',
        'date_traitement',
    ];

    // Gestion automatique des dates
    protected $dates = [
        'date_perte',
        'date_delivrance',
        'date_declaration',
        'date_traitement',
        'created_at',
        'updated_at',
    ];

    // Valeurs par défaut
    protected $attributes = [
        'statut' => 'en attente',
        'date_declaration' => null,
        'date_traitement' => null,
    ];

    // Pour remplir automatiquement date_declaration à la création
    protected static function booted()
    {
        static::creating(function ($perte) {
            $perte->date_declaration = now();
        });
    }
}
