<x-admin-layout>
    @if (session('success'))
        <div class="alert alert-success text-dark-green text-2xl mt-4 ml-4 text-center">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <div class="container mx-auto p-4">
            <div class="bg-dark-green text-white w-full p-6 border-b">
                <h2>Information du dossier sélectionné</h2>
                <p class="text-xs">no dossier: {{$dossierClient->id}}</p>
                <p class="text-xs">prenom: {{$dossierClient->client->prenom}}</p>
                <p class="text-xs">nom: {{$dossierClient->client->nom}}</p>
            </div>

            <div class="bg-dark-green text-white w-full">
                @if (isset($ficheSelected))
                    @livewire('FicheCliniqueComponent', ['dossierClient' => $dossierClient, 'ficheSelected' => $ficheSelected])
                @else
                    @livewire('FicheCliniqueComponent', ['dossierClient' => $dossierClient])
                @endif

            </div>

        </div>


    </div>

</x-admin-layout>
