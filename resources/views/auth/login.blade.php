<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    @include('partials.nav')

    <h2>Connexion</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label>Email :</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
</body>
</html>
