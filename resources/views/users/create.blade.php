<!-- resources/views/users/create.blade.php -->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Créer un Utilisateur</title>
    </head>

    <body>
        <h1>Créer un Utilisateur</h1>

        @if (session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        <!-- Formulaire de création d'utilisateur -->
        <form action="{{ route('sendInvitation') }}" method="POST">
            @csrf

            <!-- Champ nom -->
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}">
            @error('nom')
                <div style="color: red;">{{ $message }}</div>
            @enderror

            <!-- Champ prénom -->
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}">
            @error('prenom')
                <div style="color: red;">{{ $message }}</div>
            @enderror

            <!-- Champ email -->
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror

            <button type="submit">Créer</button>
        </form>
    </body>
</html>
