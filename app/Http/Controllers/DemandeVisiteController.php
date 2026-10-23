<?php

namespace App\Http\Controllers;

use App\Models\DemandeVisite;
use App\Models\Logement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeVisiteController extends Controller
{
    // Étudiant : ses demandes envoyées / Propriétaire : les demandes reçues
    public function index()
    {
        $user = Auth::user();

        if ($user->estEtudiant()) {
            $demandes = $user->demandes()->with('logement')->latest()->get();
        } else {
            $demandes = DemandeVisite::whereIn('logement_id', $user->logements()->pluck('id'))
                ->with(['logement', 'etudiant'])
                ->latest()
                ->get();
        }

        return view('demandes.index', ['demandes' => $demandes]);
    }

    public function store(Request $request, Logement $logement)
    {
        if (!Auth::user()->estEtudiant()) {
            abort(403, 'Réservé aux étudiants');
        }

        $request->validate([
            'date_souhaitee' => 'required|date|after_or_equal:today',
        ]);

        DemandeVisite::create([
            'etudiant_id' => Auth::id(),
            'logement_id' => $logement->id,
            'date_souhaitee' => $request->date_souhaitee,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('demandes.index')->with('success', 'Demande de visite envoyée');
    }

    public function accepter(DemandeVisite $demande)
    {
        $this->verifierProprietaireDuLogement($demande);

        $demande->update(['statut' => 'acceptee']);

        return back()->with('success', 'Demande acceptée');
    }

    public function refuser(DemandeVisite $demande)
    {
        $this->verifierProprietaireDuLogement($demande);

        $demande->update(['statut' => 'refusee']);

        return back()->with('success', 'Demande refusée');
    }

    private function verifierProprietaireDuLogement(DemandeVisite $demande)
    {
        if ($demande->logement->proprietaire_id != Auth::id()) {
            abort(403, "Cette demande ne concerne pas vos logements");
        }
    }
}
