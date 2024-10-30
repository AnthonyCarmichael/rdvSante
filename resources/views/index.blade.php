<x-admin-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-4xl font-bold mb-6">Bienvenue sur votre tableau de bord</h2>
    </div>
    @php
        $photo = false;
        $service = false;
        $clinique = false;
        $description = false;
        $dispo = false;
    @endphp
    @if (!$photo || !$service || !$clinique || !$description || !$dispo)
        <div class="container mx-auto p-4">
            <h3 class="text-2xl font-bold mb-6">Voici une liste de choses à faire pour officielement activé votre compte!
            </h3>
            <ul class="mx-auto p-4 text-xl">
                @if (!$photo)
                    <li class="list-disc">Envoyer une photo à l'administrateur pour l'ajouter à votre profil</li>
                @endif
                @if (!$service)
                    <li class="list-disc">Ajouter au moins un service</li>
                @endif
                @if (!$clinique)
                    <li class="list-disc">Ajouter au moins une clinique</li>
                @endif
                @if (!$description)
                    <li class="list-disc">Ajouter une description de vous à votre profil</li>
                @endif
                @if (!$dispo)
                    <li class="list-disc">Ajouter vos disponibilités dans l'onglet profil</li>
                @endif
            </ul>
        </div>
    @endif

</x-admin-layout>
