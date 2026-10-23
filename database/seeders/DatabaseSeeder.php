<?php

namespace Database\Seeders;

use App\Models\Logement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $proprio = User::create([
            'nom' => 'Diop', 'prenom' => 'Moussa', 'email' => 'proprio@test.com',
            'telephone' => '771234567', 'password' => Hash::make('password'), 'role' => 'proprietaire',
        ]);

        User::create([
            'nom' => 'Fall', 'prenom' => 'Awa', 'email' => 'etudiant@test.com',
            'telephone' => '781234567', 'password' => Hash::make('password'), 'role' => 'etudiant',
        ]);

        Logement::create([
            'titre' => "Chambre meublée près de l'ISEP", 'description' => 'Chambre calme avec wifi et eau chaude.',
            'type' => 'chambre', 'prix_mensuel' => 35000, 'ville' => 'Diamniadio', 'quartier' => 'Cité Keur Gorgui',
            'meuble' => true, 'statut' => 'disponible', 'proprietaire_id' => $proprio->id,
        ]);

        Logement::create([
            'titre' => 'Studio moderne', 'description' => 'Studio avec cuisine équipée et salle de bain.',
            'type' => 'studio', 'prix_mensuel' => 75000, 'ville' => 'Rufisque', 'quartier' => 'Centre-ville',
            'meuble' => false, 'statut' => 'disponible', 'proprietaire_id' => $proprio->id,
        ]);

        Logement::create([
            'titre' => 'Appartement 2 pièces à partager', 'description' => 'Idéal pour 2 étudiants en colocation.',
            'type' => 'appartement', 'prix_mensuel' => 120000, 'ville' => 'Dakar', 'quartier' => 'Liberté 6',
            'meuble' => true, 'statut' => 'disponible', 'proprietaire_id' => $proprio->id,
        ]);
    }
}
