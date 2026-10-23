<p>
    <strong>LogeEtudiant</strong> |
    <a href="{{ route('logements.index') }}">Logements</a> |
    @auth
        @if (Auth::user()->estProprietaire())
            <a href="{{ route('logements.mes') }}">Mes logements</a> |
            <a href="{{ route('logements.create') }}">Ajouter un logement</a> |
            <a href="{{ route('demandes.index') }}">Demandes reçues</a> |
        @else
            <a href="{{ route('favoris.index') }}">Mes favoris</a> |
            <a href="{{ route('demandes.index') }}">Mes demandes</a> |
        @endif
        <a href="{{ route('profil.edit') }}">Mon profil ({{ Auth::user()->prenom }})</a> |
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit">Déconnexion</button>
        </form>
    @else
        <a href="{{ route('login') }}">Connexion</a> |
        <a href="{{ route('register') }}">Inscription</a>
    @endauth
</p>
<hr>

@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
