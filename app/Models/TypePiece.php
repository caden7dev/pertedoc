<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePiece extends Model
{
    use HasFactory;

    // Si tu veux remplir des colonnes en masse
    protected $fillable = ['nom', 'description'];
}
