<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function index()
    {
        $this->verifierEtudiant();

        $logements = Auth::user()->favoris()->get();

        return view('favoris.index', ['logements' => $logements]);
    }

    public function store(Logement $logement)
    {
        $this->verifierEtudiant();

        Auth::user()->favoris()->syncWithoutDetaching([$logement->id]);

        return back()->with('success', 'Logement ajouté à vos favoris');
    }

    public function destroy(Logement $logement)
    {
        $this->verifierEtudiant();

        Auth::user()->favoris()->detach($logement->id);

        return back()->with('success', 'Logement retiré de vos favoris');
    }

    private function verifierEtudiant()
    {
        if (!Auth::user()->estEtudiant()) {
            abort(403, 'Réservé aux étudiants');
        }
    }
}
