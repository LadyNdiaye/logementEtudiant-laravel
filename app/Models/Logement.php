<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logement extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'type', 'prix_mensuel', 'ville',
        'quartier', 'meuble', 'photo', 'statut', 'proprietaire_id',
    ];

    // Un logement appartient à un seul propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Les étudiants qui ont mis ce logement en favori
    public function etudiantsFavoris()
    {
        return $this->belongsToMany(User::class, 'favoris', 'logement_id', 'etudiant_id')->withTimestamps();
    }

    // Les demandes de visite reçues pour ce logement
    public function demandes()
    {
        return $this->hasMany(DemandeVisite::class, 'logement_id');
    }
}
