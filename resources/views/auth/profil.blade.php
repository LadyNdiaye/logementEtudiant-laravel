<!DOCTYPE html>
<html>
<head>
    <title>Mon profil</title>
</head>
<body>
    @include('partials.nav')

    <h2>Mon profil</h2>
    <p>Rôle : <strong>{{ $user->role }}</strong></p>

    <form action="{{ route('profil.update') }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nom :</label><br>
        <input type="text" name="nom" value="{{ $user->nom }}"><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" value="{{ $user->prenom }}"><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" value="{{ $user->email }}"><br><br>

        <label>Téléphone :</label><br>
        <input type="text" name="telephone" value="{{ $user->telephone }}"><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
