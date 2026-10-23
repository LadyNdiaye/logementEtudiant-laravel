<!DOCTYPE html>
<html>
<head>
    <title>Logements disponibles</title>
</head>
<body>
    @include('partials.nav')

    <h2>Logements disponibles</h2>

    <form action="{{ route('logements.index') }}" method="GET">
        <input type="text" name="ville" placeholder="Ville" value="{{ request('ville') }}">

        <select name="type">
            <option value="">-- Type --</option>
            <option value="chambre" {{ request('type') == 'chambre' ? 'selected' : '' }}>Chambre</option>
            <option value="studio" {{ request('type') == 'studio' ? 'selected' : '' }}>Studio</option>
            <option value="appartement" {{ request('type') == 'appartement' ? 'selected' : '' }}>Appartement</option>
        </select>

        <input type="number" name="prix_max" placeholder="Prix max (FCFA)" value="{{ request('prix_max') }}">

        <select name="meuble">
            <option value="">-- Meublé ? --</option>
            <option value="1" {{ request('meuble') === '1' ? 'selected' : '' }}>Meublé</option>
            <option value="0" {{ request('meuble') === '0' ? 'selected' : '' }}>Non meublé</option>
        </select>

        <button type="submit">Rechercher</button>
        <a href="{{ route('logements.index') }}">Réinitialiser</a>
    </form>
    <br>

    <table border="1" cellpadding="5">
        <tr>
            <th>Photo</th>
            <th>Titre</th>
            <th>Type</th>
            <th>Ville</th>
            <th>Quartier</th>
            <th>Prix / mois</th>
            <th>Meublé</th>
            <th>Action</th>
        </tr>
        @forelse ($logements as $logement)
            <tr>
                <td>
                    @if ($logement->photo)
                        <img src="{{ asset($logement->photo) }}" width="80">
                    @endif
                </td>
                <td>{{ $logement->titre }}</td>
                <td>{{ $logement->type }}</td>
                <td>{{ $logement->ville }}</td>
                <td>{{ $logement->quartier }}</td>
                <td>{{ number_format($logement->prix_mensuel, 0, ',', ' ') }} FCFA</td>
                <td>{{ $logement->meuble ? 'Oui' : 'Non' }}</td>
                <td><a href="{{ route('logements.show', $logement) }}">Voir</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Aucun logement trouvé.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
