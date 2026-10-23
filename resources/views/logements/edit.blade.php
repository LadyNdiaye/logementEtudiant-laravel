<!DOCTYPE html>
<html>
<head>
    <title>Modifier un logement</title>
</head>
<body>
    @include('partials.nav')

    <h2>Modifier : {{ $logement->titre }}</h2>
    <a href="{{ route('logements.mes') }}">Retour à mes logements</a>

    <form action="{{ route('logements.update', $logement) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Titre :</label><br>
        <input type="text" name="titre" value="{{ $logement->titre }}"><br><br>

        <label>Description :</label><br>
        <textarea name="description">{{ $logement->description }}</textarea><br><br>

        <label>Type :</label><br>
        <select name="type">
            <option value="chambre" {{ $logement->type == 'chambre' ? 'selected' : '' }}>Chambre</option>
            <option value="studio" {{ $logement->type == 'studio' ? 'selected' : '' }}>Studio</option>
            <option value="appartement" {{ $logement->type == 'appartement' ? 'selected' : '' }}>Appartement</option>
        </select><br><br>

        <label>Prix mensuel (FCFA) :</label><br>
        <input type="number" name="prix_mensuel" value="{{ $logement->prix_mensuel }}"><br><br>

        <label>Ville :</label><br>
        <input type="text" name="ville" value="{{ $logement->ville }}"><br><br>

        <label>Quartier :</label><br>
        <input type="text" name="quartier" value="{{ $logement->quartier }}"><br><br>

        <label>
            <input type="checkbox" name="meuble" value="1" {{ $logement->meuble ? 'checked' : '' }}> Meublé
        </label><br><br>

        @if ($logement->photo)
            <img src="{{ asset($logement->photo) }}" width="120"><br>
        @endif
        <label>Changer la photo :</label><br>
        <input type="file" name="photo"><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
