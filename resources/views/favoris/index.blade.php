<!DOCTYPE html>
<html>
<head>
    <title>Mes favoris</title>
</head>
<body>
    @include('partials.nav')

    <h2>Mes favoris</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>Titre</th>
            <th>Ville</th>
            <th>Prix / mois</th>
            <th>Statut</th>
            <th>Ajouté le</th>
            <th>Actions</th>
        </tr>
        @forelse ($logements as $logement)
            <tr>
                <td>{{ $logement->titre }}</td>
                <td>{{ $logement->ville }}</td>
                <td>{{ number_format($logement->prix_mensuel, 0, ',', ' ') }} FCFA</td>
                <td>{{ $logement->statut == 'disponible' ? 'Disponible' : 'Loué' }}</td>
                <td>{{ \Carbon\Carbon::parse($logement->pivot->created_at)->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('logements.show', $logement) }}">Voir</a>
                    <form action="{{ route('favoris.destroy', $logement) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Retirer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Aucun favori pour le moment.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
