<!DOCTYPE html>
<html>
<head>
    <title>{{ $logement->titre }}</title>
</head>
<body>
    @include('partials.nav')

    <a href="{{ route('logements.index') }}">Retour à la liste</a>

    <h2>{{ $logement->titre }}</h2>

    @if ($logement->photo)
        <img src="{{ asset($logement->photo) }}" width="300"><br>
    @endif

    <p><strong>Type :</strong> {{ $logement->type }}</p>
    <p><strong>Prix :</strong> {{ number_format($logement->prix_mensuel, 0, ',', ' ') }} FCFA / mois</p>
    <p><strong>Ville :</strong> {{ $logement->ville }} — {{ $logement->quartier }}</p>
    <p><strong>Meublé :</strong> {{ $logement->meuble ? 'Oui' : 'Non' }}</p>
    <p><strong>Statut :</strong> {{ $logement->statut == 'disponible' ? 'Disponible' : 'Loué' }}</p>
    <p><strong>Description :</strong><br>{{ $logement->description }}</p>

    <h3>Propriétaire</h3>
    <p>{{ $logement->proprietaire->prenom }} {{ $logement->proprietaire->nom }}</p>
    <p>Téléphone : {{ $logement->proprietaire->telephone }}</p>
    <p>Email : {{ $logement->proprietaire->email }}</p>

    @auth
        @if (Auth::user()->estEtudiant())
            <hr>
            @if ($estFavori)
                <form action="{{ route('favoris.destroy', $logement) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Retirer des favoris</button>
                </form>
            @else
                <form action="{{ route('favoris.store', $logement) }}" method="POST">
                    @csrf
                    <button type="submit">Ajouter aux favoris</button>
                </form>
            @endif

            @if ($logement->statut == 'disponible')
                <h3>Demander une visite</h3>
                <form action="{{ route('demandes.store', $logement) }}" method="POST">
                    @csrf
                    <label>Date souhaitée :</label><br>
                    <input type="date" name="date_souhaitee"><br><br>

                    <label>Message :</label><br>
                    <textarea name="message"></textarea><br><br>

                    <button type="submit">Envoyer la demande</button>
                </form>
            @endif
        @endif
    @else
        <p><a href="{{ route('login') }}">Connectez-vous</a> pour ajouter ce logement en favori ou demander une visite.</p>
    @endauth
</body>
</html>
