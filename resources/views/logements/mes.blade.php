<!DOCTYPE html>
<html>
<head>
    <title>Mes logements</title>
</head>
<body>
    @include('partials.nav')

    <h2>Mes logements</h2>
    <a href="{{ route('logements.create') }}">+ Ajouter un logement</a><br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>Titre</th>
            <th>Type</th>
            <th>Ville</th>
            <th>Prix / mois</th>
            <th>Statut</th>
            <th>Demandes</th>
            <th>Actions</th>
        </tr>
        @forelse ($logements as $logement)
            <tr>
                <td><a href="{{ route('logements.show', $logement) }}">{{ $logement->titre }}</a></td>
                <td>{{ $logement->type }}</td>
                <td>{{ $logement->ville }}</td>
                <td>{{ number_format($logement->prix_mensuel, 0, ',', ' ') }} FCFA</td>
                <td>{{ $logement->statut == 'disponible' ? 'Disponible' : 'Loué' }}</td>
                <td>{{ $logement->demandes_count }}</td>
                <td>
                    <a href="{{ route('logements.edit', $logement) }}">Modifier</a>

                    <form action="{{ route('logements.statut', $logement) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            {{ $logement->statut == 'disponible' ? 'Marquer loué' : 'Marquer disponible' }}
                        </button>
                    </form>

                    <form action="{{ route('logements.destroy', $logement) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce logement ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Vous n'avez publié aucun logement.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
