<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perte extends Model
{
    use HasFactory;

    /**
     * Nom de la table
     */
    protected $table = 'pertes';

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'user_id',
        'type_piece_id',
        'numero_piece',
        'date_perte',
        'lieu_perte',
        'description',
        'statut',
        'motif_rejet',
        'numero_declaration',
        'validated_at',
        'validated_by',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'date_perte' => 'date',
        'validated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Statuts possibles
     */
    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_VALIDEE = 'validee';
    const STATUT_REJETEE = 'rejetee';

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le type de pièce
     */
    public function typePiece()
    {
        return $this->belongsTo(TypePiece::class);
    }

    /**
     * Relation avec l'agent validateur
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Scope pour les déclarations en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', self::STATUT_EN_ATTENTE);
    }

    /**
     * Scope pour les déclarations validées
     */
    public function scopeValidees($query)
    {
        return $query->where('statut', self::STATUT_VALIDEE);
    }

    /**
     * Scope pour les déclarations rejetées
     */
    public function scopeRejetees($query)
    {
        return $query->where('statut', self::STATUT_REJETEE);
    }

    /**
     * Accesseur pour le badge de statut
     */
    public function getStatutBadgeAttribute()
    {
        $badges = [
            'en_attente' => '<span class="badge bg-warning">En Attente</span>',
            'validee' => '<span class="badge bg-success">Validée</span>',
            'rejetee' => '<span class="badge bg-danger">Rejetée</span>',
        ];

        return $badges[$this->statut] ?? '';
    }

    /**
     * Accesseur pour le statut en français
     */
    public function getStatutTextAttribute()
    {
        $statuts = [
            'en_attente' => 'En Attente',
            'validee' => 'Validée',
            'rejetee' => 'Rejetée',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    /**
     * Générer un numéro de déclaration unique
     */
    public static function generateNumeroDeclaration()
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('DECL-%04d-%05d', $year, $count);
    }

    /**
     * Boot method pour générer automatiquement le numéro
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($perte) {
            if (empty($perte->numero_declaration)) {
                $perte->numero_declaration = self::generateNumeroDeclaration();
            }
        });
    }
}