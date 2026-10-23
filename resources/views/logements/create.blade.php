<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un logement</title>
</head>
<body>
    @include('partials.nav')

    <h2>Nouveau logement</h2>
    <a href="{{ route('logements.mes') }}">Retour à mes logements</a>

    <form action="{{ route('logements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Titre :</label><br>
        <input type="text" name="titre" value="{{ old('titre') }}"><br><br>

        <label>Description :</label><br>
        <textarea name="description">{{ old('description') }}</textarea><br><br>

        <label>Type :</label><br>
        <select name="type">
            <option value="">-- Choisir --</option>
            <option value="chambre">Chambre</option>
            <option value="studio">Studio</option>
            <option value="appartement">Appartement</option>
        </select><br><br>

        <label>Prix mensuel (FCFA) :</label><br>
        <input type="number" name="prix_mensuel" value="{{ old('prix_mensuel') }}"><br><br>

        <label>Ville :</label><br>
        <input type="text" name="ville" value="{{ old('ville') }}"><br><br>

        <label>Quartier :</label><br>
        <input type="text" name="quartier" value="{{ old('quartier') }}"><br><br>

        <label>
            <input type="checkbox" name="meuble" value="1"> Meublé
        </label><br><br>

        <label>Photo :</label><br>
        <input type="file" name="photo"><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
