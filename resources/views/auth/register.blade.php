<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    @include('partials.nav')

    <h2>Inscription</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label>Nom :</label><br>
        <input type="text" name="nom" value="{{ old('nom') }}"><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" value="{{ old('prenom') }}"><br><br>

        <label>Email :</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>

        <label>Téléphone :</label><br>
        <input type="text" name="telephone" value="{{ old('telephone') }}"><br><br>

        <label>Je suis :</label><br>
        <select name="role">
            <option value="">-- Choisir --</option>
            <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
            <option value="proprietaire" {{ old('role') == 'proprietaire' ? 'selected' : '' }}>Propriétaire</option>
        </select><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password"><br><br>

        <label>Confirmer le mot de passe :</label><br>
        <input type="password" name="password_confirmation"><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
</body>
</html>
