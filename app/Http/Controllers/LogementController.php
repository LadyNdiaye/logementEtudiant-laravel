<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogementController extends Controller
{
    // Liste des logements disponibles avec filtres (accessible à tous)
    public function index(Request $request)
    {
        $query = Logement::where('statut', 'disponible');

        if ($request->ville) {
            $query->where('ville', 'ilike', '%' . $request->ville . '%');
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->prix_max) {
            $query->where('prix_mensuel', '<=', $request->prix_max);
        }
        if ($request->meuble != '') {
            $query->where('meuble', $request->meuble);
        }

        $logements = $query->latest()->get();

        return view('logements.index', ['logements' => $logements]);
    }

    // Les logements du propriétaire connecté
    public function mesLogements()
    {
        $this->verifierProprietaire();

        $logements = Auth::user()->logements()->withCount('demandes')->latest()->get();

        return view('logements.mes', ['logements' => $logements]);
    }

    public function create()
    {
        $this->verifierProprietaire();

        return view('logements.create');
    }

    public function store(Request $request)
    {
        $this->verifierProprietaire();

        $request->validate([
            'titre' => 'required',
            'type' => 'required|in:chambre,studio,appartement',
            'prix_mensuel' => 'required|integer|min:0',
            'ville' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        Logement::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'prix_mensuel' => $request->prix_mensuel,
            'ville' => $request->ville,
            'quartier' => $request->quartier,
            'meuble' => $request->has('meuble'),
            'photo' => $this->enregistrerPhoto($request),
            'statut' => 'disponible',
            'proprietaire_id' => Auth::id(),
        ]);

        return redirect()->route('logements.mes')->with('success', 'Logement ajouté avec succès');
    }

    public function show(Logement $logement)
    {
        $estFavori = false;
        if (Auth::check()) {
            $estFavori = Auth::user()->favoris()->where('logement_id', $logement->id)->exists();
        }

        return view('logements.show', ['logement' => $logement, 'estFavori' => $estFavori]);
    }

    public function edit(Logement $logement)
    {
        $this->verifierPossession($logement);

        return view('logements.edit', ['logement' => $logement]);
    }

    public function update(Request $request, Logement $logement)
    {
        $this->verifierPossession($logement);

        $request->validate([
            'titre' => 'required',
            'type' => 'required|in:chambre,studio,appartement',
            'prix_mensuel' => 'required|integer|min:0',
            'ville' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photo = $logement->photo;
        if ($request->hasFile('photo')) {
            $photo = $this->enregistrerPhoto($request);
        }

        $logement->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'prix_mensuel' => $request->prix_mensuel,
            'ville' => $request->ville,
            'quartier' => $request->quartier,
            'meuble' => $request->has('meuble'),
            'photo' => $photo,
        ]);

        return redirect()->route('logements.mes')->with('success', 'Logement modifié avec succès');
    }

    public function destroy(Logement $logement)
    {
        $this->verifierPossession($logement);

        $logement->delete();

        return redirect()->route('logements.mes')->with('success', 'Logement supprimé avec succès');
    }

    // Passer un logement de "disponible" à "loue" et inversement
    public function changerStatut(Logement $logement)
    {
        $this->verifierPossession($logement);

        $logement->update([
            'statut' => $logement->statut == 'disponible' ? 'loue' : 'disponible',
        ]);

        return redirect()->route('logements.mes')->with('success', 'Statut mis à jour');
    }

    private function enregistrerPhoto(Request $request)
    {
        if (!$request->hasFile('photo')) {
            return null;
        }
        $nom = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->move(public_path('photos'), $nom);

        return 'photos/' . $nom;
    }

    private function verifierProprietaire()
    {
        if (!Auth::user()->estProprietaire()) {
            abort(403, 'Réservé aux propriétaires');
        }
    }

    private function verifierPossession(Logement $logement)
    {
        if ($logement->proprietaire_id != Auth::id()) {
            abort(403, "Ce logement ne vous appartient pas");
        }
    }
}
