<div>
    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prénom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Courriel</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Téléphone</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Date de naissance</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                </tr>
            </thead>
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
                            class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button" wire:click="getInfoClient({{ $client->id }})" x-data
                            x-on:click="$dispatch('open-modal', { name : 'modifierClient'  })">Modifier</button><button
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
                            class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button" x-data
                            x-on:click="$dispatch('open-modal', { name : 'modifierClient'  })">Modifier</button><button
                            class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button">Supprimer</button>
                    </td>
                </tr>
                <?php } ?>

                <?php $cpt += 1; ?>
            @endforeach

        </table>
    </div>
    <div class="flex justify-end z-0">
        <button x-data x-on:click="$dispatch('open-modal', { name : 'ajouterClient'  })"
            class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button">Ajouter</button>
    </div>
    <x-modal title="Ajouter un client" name="ajouterClient" :show="false">
        <form wire:submit.prevent="ajoutClient" class="bg-white p-4 rounded-lg">
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du client</legend>
                <div class="grid grid-cols-4 gap-y-4">

                    <label class="text-sm text-right" for="nom">Nom:*</label>
                    <input wire:model="nom" class="h-8 text-xs ml-2" type="text" id="nom" name="nom" />

                    <label class="text-sm text-right" for="prenom">Prénom:*</label>
                    <input wire:model="prenom" class="h-8 text-xs ml-2" type="text" id="prenom" name="prenom" />

                    <label class="text-sm text-right" for="courriel">Courriel:*</label>
                    <input wire:model="courriel" class="h-8 text-xs ml-2" type="email" id="courriel"
                        name="courriel" />

                    <label class="text-sm text-right" for="telephone">Téléphone:*</label>
                    <input placeholder="(123) 456-7890" wire:model="telephone" class="h-8 text-xs ml-2" type="tel"
                        id="telephone" name="telephone" />

                    <label class="text-sm text-right" for="ddn">Date de naissance:*</label>
                    <input wire:model="ddn" class="h-8 text-xs ml-2" type="date" id="ddn" name="ddn" />


                    <label class="text-sm text-right" for="genre">Genre:*</label>
                    <select wire:model="genre" id="genre" name="genre" class="h-8 text-xs ml-2">
                        @foreach ($genres as $genre)
                            <option value={{ $genre->id }}> {{ $genre->nom }}</option>
                        @endforeach
                    </select>

                </div>

            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du responsable</legend>

                <div class="grid grid-cols-4 gap-y-4">
                    <label class="text-sm text-right" for="nomResponsable">Nom du responsable:</label>
                    <input wire:model="nomResponsable" class="h-8 text-xs ml-2" type="text" id="nomResponsable"
                        name="nomResponsable" />

                    <label class="text-sm text-right" for="prenomResponsable">Prénom du responsable:</label>
                    <input wire:model="prenomResponsable" class="h-8 text-xs ml-2" type="text" id="prenomResponsable"
                        name="prenomResponsable" />

                    <label class="text-sm text-right" for="lienResponsable">Lien avec le client:</label>
                    <input wire:model="lienResponsable" class="h-8 text-xs ml-2" type="text" id="lienResponsable"
                        name="lienResponsable" />
                </div>
            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Adresse</legend>

                <div class="grid grid-cols-4 gap-y-4">
                    <label class="text-sm text-right" for="rue">Rue:</label>
                    <input wire:model="rue" class="h-8 text-xs ml-2" type="text" id="rue"
                        name="rue" />

                    <label class="text-sm text-right" for="noCivique">Numéro civique:</label>
                    <input wire:model="noCivique" class="h-8 text-xs ml-2" type="text" id="noCivique"
                        name="noCivique" />

                    <label class="text-sm text-right" for="codePostal">Code postal:</label>
                    <input placeholder="ex: A0A 0A0" wire:model="codePostal" class="h-8 text-xs ml-2" type="text"
                        id="codePostal" name="codePostal" />

                    <label class="text-sm text-right" for="ville">Ville:</label>
                    <input wire:model="ville" type="text" list="ville" class="h-8 text-xs ml-2">
                    <datalist wire:model="ville" id="ville" name="ville" class="h-8 text-xs ml-2">
                        @foreach ($villes as $ville)
                            <option value={{ $ville->nom }}> {{ $ville->nom }}</option>
                        @endforeach
                    </datalist>
                </div>

            </fieldset>
            <div class="flex justify-center">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Modifier un client" name="modifierClient" :show="false">
        <form wire:submit.prevent="ajoutClient" class="bg-white p-4 rounded-lg">
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du client</legend>
                <div class="grid grid-cols-4 gap-y-4">

                    <label class="text-sm text-right" for="nom">Nom:*</label>
                    <input wire:model="nom" class="h-8 text-xs ml-2" type="text" id="nom"
                        name="nom"/>

                    <label class="text-sm text-right" for="prenom">Prénom:*</label>
                    <input wire:model="prenom" class="h-8 text-xs ml-2" type="text" id="prenom"
                        name="prenom" />

                    <label class="text-sm text-right" for="courriel">Courriel:*</label>
                    <input wire:model="courriel" class="h-8 text-xs ml-2" type="email" id="courriel"
                        name="courriel" />

                    <label class="text-sm text-right" for="telephone">Téléphone:*</label>
                    <input placeholder="(123) 456-7890" wire:model="telephone" class="h-8 text-xs ml-2"
                        type="tel" id="telephone" name="telephone" />

                    <label class="text-sm text-right" for="ddn">Date de naissance:*</label>
                    <input wire:model="ddn" class="h-8 text-xs ml-2" type="date" id="ddn"
                        name="ddn" />


                    <label class="text-sm text-right" for="genre">Genre:*</label>
                    <select wire:model="genre" id="genre" name="genre" class="h-8 text-xs ml-2">
                        @foreach ($genres as $genre)
                            <option value={{ $genre->id }}> {{ $genre->nom }}</option>
                        @endforeach
                    </select>

                </div>

            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du responsable</legend>

                <div class="grid grid-cols-4 gap-y-4">
                    <label class="text-sm text-right" for="nomResponsable">Nom du responsable:</label>
                    <input wire:model="nomResponsable" class="h-8 text-xs ml-2" type="text" id="nomResponsable"
                        name="nomResponsable" />

                    <label class="text-sm text-right" for="prenomResponsable">Prénom du responsable:</label>
                    <input wire:model="prenomResponsable" class="h-8 text-xs ml-2" type="text"
                        id="prenomResponsable" name="prenomResponsable" />

                    <label class="text-sm text-right" for="lienResponsable">Lien avec le client:</label>
                    <input wire:model="lienResponsable" class="h-8 text-xs ml-2" type="text" id="lienResponsable"
                        name="lienResponsable" />
                </div>
            </fieldset>
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Adresse</legend>

                <div class="grid grid-cols-4 gap-y-4">
                    <label class="text-sm text-right" for="rue">Rue:</label>
                    <input wire:model="rue" class="h-8 text-xs ml-2" type="text" id="rue"
                        name="rue" />

                    <label class="text-sm text-right" for="noCivique">Numéro civique:</label>
                    <input wire:model="noCivique" class="h-8 text-xs ml-2" type="text" id="noCivique"
                        name="noCivique" />

                    <label class="text-sm text-right" for="codePostal">Code postal:</label>
                    <input placeholder="ex: A0A 0A0" wire:model="codePostal" class="h-8 text-xs ml-2" type="text"
                        id="codePostal" name="codePostal" />

                    <label class="text-sm text-right" for="ville">Ville:</label>
                    <input wire:model="ville" type="text" list="ville" class="h-8 text-xs ml-2">
                    <datalist wire:model="ville" id="ville" name="ville" class="h-8 text-xs ml-2">
                        @foreach ($villes as $ville)
                            <option value={{ $ville->nom }}> {{ $ville->nom }}</option>
                        @endforeach
                    </datalist>
                </div>

            </fieldset>
            <div class="flex justify-center">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>
</div>
