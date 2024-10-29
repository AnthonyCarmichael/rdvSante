<!-- resources/views/emails/invitation.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation</title>
</head>
<body>
    <h1>Bonjour,</h1>
    <p>Vous avez été invité à créer un compte. Veuillez cliquer sur le lien ci-dessous pour finaliser votre inscription.</p>
    <p>
        <a href="{{ $url }}">Créer mon compte</a>
    </p>
    <p>Ce lien expirera dans 3 jours.</p>
</body>
</html>
