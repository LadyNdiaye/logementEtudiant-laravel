<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nom', 'prenom', 'email', 'telephone', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    // Un propriétaire publie plusieurs logements (1 à N)
    public function logements()
    {
        return $this->hasMany(Logement::class, 'proprietaire_id');
    }

    // Un étudiant a plusieurs logements en favoris (N à N via favoris)
    public function favoris()
    {
        return $this->belongsToMany(Logement::class, 'favoris', 'etudiant_id', 'logement_id')->withTimestamps();
    }

    // Un étudiant envoie plusieurs demandes de visite
    public function demandes()
    {
        return $this->hasMany(DemandeVisite::class, 'etudiant_id');
    }

    public function estProprietaire()
    {
        return $this->role == 'proprietaire';
    }

    public function estEtudiant()
    {
        return $this->role == 'etudiant';
    }
}
