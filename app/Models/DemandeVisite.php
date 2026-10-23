<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeVisite extends Model
{
    use HasFactory;

    protected $table = 'demandes_visite';

    protected $fillable = ['etudiant_id', 'logement_id', 'date_souhaitee', 'message', 'statut'];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function logement()
    {
        return $this->belongsTo(Logement::class, 'logement_id');
    }
}
