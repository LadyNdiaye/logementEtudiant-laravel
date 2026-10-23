<!DOCTYPE html>
<html>
<head>
    <title>Demandes de visite</title>
</head>
<body>
    @include('partials.nav')

    @if (Auth::user()->estProprietaire())
        <h2>Demandes de visite reçues</h2>
    @else
        <h2>Mes demandes de visite</h2>
    @endif

    <table border="1" cellpadding="5">
        <tr>
            <th>Logement</th>
            @if (Auth::user()->estProprietaire())
                <th>Étudiant</th>
                <th>Téléphone</th>
            @endif
            <th>Date souhaitée</th>
            <th>Message</th>
            <th>Statut</th>
            @if (Auth::user()->estProprietaire())
                <th>Actions</th>
            @endif
        </tr>
        @forelse ($demandes as $demande)
            <tr>
                <td><a href="{{ route('logements.show', $demande->logement) }}">{{ $demande->logement->titre }}</a></td>
                @if (Auth::user()->estProprietaire())
                    <td>{{ $demande->etudiant->prenom }} {{ $demande->etudiant->nom }}</td>
                    <td>{{ $demande->etudiant->telephone }}</td>
                @endif
                <td>{{ \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') }}</td>
                <td>{{ $demande->message }}</td>
                <td>
                    @if ($demande->statut == 'en_attente')
                        En attente
                    @elseif ($demande->statut == 'acceptee')
                        <span style="color:green">Acceptée</span>
                    @else
                        <span style="color:red">Refusée</span>
                    @endif
                </td>
                @if (Auth::user()->estProprietaire())
                    <td>
                        @if ($demande->statut == 'en_attente')
                            <form action="{{ route('demandes.accepter', $demande) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Accepter</button>
                            </form>
                            <form action="{{ route('demandes.refuser', $demande) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Refuser</button>
                            </form>
                        @endif
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="7">Aucune demande pour le moment.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
