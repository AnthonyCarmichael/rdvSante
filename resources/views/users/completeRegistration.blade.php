<!-- resources/views/users/complete-registration.blade.php -->

<form action="{{ route('completeRegistration') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ request('token') }}">

    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>

    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone" id="telephone" required>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>

    <label for="description">Description :</label>
    <textarea name="description" id="description"></textarea>

    <label for="actif">Actif :</label>
    <select name="actif" id="actif" required>
        <option value="1">Oui</option>
        <option value="0">Non</option>
    </select>

    <label for="lien">Lien :</label>
    <input type="text" name="lien" id="lien">

    <button type="submit">Enregistrer</button>
</form>
