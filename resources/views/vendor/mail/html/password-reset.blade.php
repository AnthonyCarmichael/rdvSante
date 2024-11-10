<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
    <p>Bonjour !</p>

    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>

    <p>
        <a href="{{ $resetUrl }}">Réinitialiser le mot de passe</a>
    </p>

    <p>Ce lien de réinitialisation de mot de passe expirera dans 60 minutes.</p>

    <p>Si vous n'êtes pas à l'origine de cette demande, aucune action supplémentaire n'est requise.</p>

    <p>Cordialement,</p>
    <p>L'équipe Laravel</p>
</body>
</html>
