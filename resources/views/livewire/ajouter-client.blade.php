<div>
    <table class="table-auto z-0">
        <tr>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prénom</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Courriel</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Téléphone</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Date de naissance</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
        </tr>
        @php
            $cpt = 0;
        @endphp
        @foreach ($clients as $client)
            <?php if ($cpt%2 == 0){ ?>
            <tr>
                <td class="w-2/12 bg-white pr-4">{{ $client->prenom }}</td>
                <td class="w-2/12 bg-white pr-4">{{ $client->nom }}</td>
                <td class="w-2/12 bg-white pr-4">{{ $client->courriel }}</td>
                <td class="w-2/12 bg-white pr-4">{{ $client->telephone }}</td>
                <td class="w-2/12 bg-white pr-4">{{ $client->ddn }}</td>
                <td class="w-2/12 bg-white pr-4 justify-between"><button
                        class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button">Modifier</button><button
                        class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button">Supprimer</button>
                </td>
            </tr>
            <?php } else { ?>
            <tr>
                <td class="w-2/12 bg-table-green pr-4">{{ $client->prenom }}</td>
                <td class="w-2/12 bg-table-green pr-4">{{ $client->nom }}</td>
                <td class="w-2/12 bg-table-green pr-4">{{ $client->courriel }}</td>
                <td class="w-2/12 bg-table-green pr-4">{{ $client->telephone }}</td>
                <td class="w-2/12 bg-table-green pr-4">{{ $client->ddn }}</td>
                <td class="w-2/12 bg-table-green pr-4 justify-between"><button
                        class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button">Modifier</button><button
                        class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button">Supprimer</button>
                </td>
            </tr>
            <?php } ?>

            <?php $cpt += 1; ?>
        @endforeach

    </table>
    <div class="flex justify-end z-0">
        <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button"
            wire:click="ajouterClient()">Ajouter</button>
    </div>
    @if ($action == 'Ajouter')
        @livewire('ombrage')
        <form action="ajouterClient" method="post" class="bg-white p-4 rounded-lg z-10 absolute top-12 left-32">
            <h2 class="text-2xl font-bold mb-8">Ajouter un client</h2>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du client</legend>
                <div class="grid grid-cols-6 gap-y-4 mr-16">

                    <label class="text-sm text-right" for="nom">Nom:*</label>
                    <input class="h-8 text-xs ml-2" type="text" id="nom" name="nom" />

                    <label class="text-sm text-right" for="prenom">Prénom:*</label>
                    <input class="h-8 text-xs ml-2" type="text" id="prenom" name="prenom" />

                    <label class="text-sm text-right" for="courriel">Courriel:*</label>
                    <input class="h-8 text-xs ml-2" type="email" id="courriel" name="courriel" />

                    <label class="text-sm text-right" for="telephone">Téléphone:*</label>
                    <input class="h-8 text-xs ml-2" type="tel" id="telephone" name="telephone" />

                    <label class="text-sm text-right" for="ddn">Date de naissance:*</label>
                    <input class="h-8 text-xs ml-2" type="date" id="ddn" name="ddn" />


                    <label class="text-sm text-right" for="genre">Genre:*</label>
                    <select id="genre" name="genre" class="h-8 text-xs ml-2">
                        @foreach ($genres as $genre)
                            <option value={{ $genre->nom }}> {{ $genre->nom }}</option>
                        @endforeach
                    </select>

                </div>

            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du responsable</legend>

                <div class="grid grid-cols-4 gap-y-4 mr-16">
                    <label class="text-sm text-right" for="nomResponsable">Nom du responsable:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="nomResponsable" name="nomResponsable" />

                    <label class="text-sm text-right" for="prenomResponsable">Prénom du responsable:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="prenomResponsable" name="prenomResponsable" />

                    <label class="text-sm text-right" for="lienResponsable">Lien avec le client:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="lienResponsable" name="lienResponsable" />
                </div>
            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Adresse</legend>

                <div class="grid grid-cols-4 gap-y-4 mr-28">
                    <label class="text-sm text-right" for="rue">Rue:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="rue" name="rue" />

                    <label class="text-sm text-right" for="noCivique">Numéro civique:</label>
                    <input class="h-8 text-xs ml-2" type="number" id="noCivique" name="noCivique" />

                    <label class="text-sm text-right" for="codePostal">Code postal:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="codePostal" name="codePostal" />

                    <label class="text-sm text-right" for="ville">Ville:</label>
                    <select id="ville" name="ville" class="h-8 text-xs ml-2">
                        <option value="aucune"> Aucune </option>
                        @foreach ($villes as $ville)
                            <option value={{ $ville->nom }}> {{ $ville->nom }}</option>
                        @endforeach
                    </select>

                    <label class="text-sm text-right" for="codePostal">Code postal:</label>
                    <input class="h-8 text-xs ml-2" type="text" id="codePostal" name="codePostal" />
                </div>

            </fieldset>
            <div class="flex justify-center">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button">Confirmer</button>
                <button class="w-3/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button" wire:click="annulerAjouteClient()">Annuler</button>
            </div>

        </form>

    @endif
</div>
