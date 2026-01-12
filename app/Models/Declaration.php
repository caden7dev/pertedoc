<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_piece',
        'numero_piece',
        'nom_piece',
        'prenom_piece',
        'date_delivrance',
        'lieu_delivrance',
        'autorite_delivrance',
        'date_perte',
        'lieu_perte',
        'circonstances',
        'type_perte',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
