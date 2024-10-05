<div>
    <label class="text-m text-right font-bold" for="name">Prénom:</label>
    <input wire:change="filtreClient" wire:model="filtrePrenom" type="text" list="prenom" class="h-8 text-m ml-2 mb-4">
    <datalist wire:model="prenom" id="prenom" name="prenom" class="h-8 text-xs ml-2">
        @foreach ($prenomFiltre as $p)
            <option value={{ $p }}> {{ $p }}</option>
        @endforeach
    </datalist>

    <label class="ml-4 text-m text-right font-bold" for="name">Nom:</label>
    <input wire:change="filtreClient" wire:model="filtreNom" type="text" list="name" class="h-8 text-m ml-2 mb-4">
    <datalist wire:model="filtreNom" id="name" name="name" class="h-8 text-xs ml-2">
        @foreach ($nomFiltre as $n)
            <option value={{ $n }}> {{ $n }}</option>
        @endforeach
    </datalist>
    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prénom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Courriel</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Téléphone</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                </tr>
            </thead>
            @php
                $cpt = 0;
            @endphp

            @foreach ($clients as $c)
                <?php if ($cpt%2 == 0){ ?>
                <tr class="cursor-pointer bg-white hover:bg-blue-300">
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->prenom }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->nom }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->courriel }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->telephone }}</td>
                    <td class="w-2/12 pr-4 justify-between"><button
                            class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                            wire:click="getInfoClient({{ $c->id }})">Modifier</button><button
                            class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                            wire:click="desactiverClient({{ $c->id }})">Désactiver</button>
                    </td>
                </tr>
                <?php } else { ?>
                <tr class="cursor-pointer bg-table-green hover:bg-blue-300">
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->prenom }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/1 pr-4">
                        {{ $c->nom }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->courriel }}</td>
                    <td wire:click="consulterClient({{ $c->id }})" class="w-2/12 pr-4">
                        {{ $c->telephone }}</td>
                    <td class="w-2/12 pr-4 justify-between"><button
                            class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                            wire:click="getInfoClient({{ $c->id }})">Modifier</button><button
                            class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                            wire:click="desactiverClient({{ $c->id }})">Désactiver</button>
                    </td>
                </tr>
                <?php } ?>

                <?php $cpt += 1; ?>
            @endforeach

        </table>
    </div>
    <div class="flex justify-end z-0">
        <button wire:click="formAjout" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide"
            type="button">Ajouter</button>
    </div>
    <x-modal title="Ajouter un client" name="ajouterClient" :show="false">
        <form wire:submit.prevent="ajoutClient" class="bg-white p-4 rounded-lg">
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du client</legend>
                <div class="grid grid-cols-4 gap-y-4">

                    <label class="text-sm text-right" for="prenom">Prénom:*</label>
                    <input wire:model="prenom" class="h-8 text-xs ml-2" type="text" id="prenom" name="prenom" />

                    <label class="text-sm text-right" for="nom">Nom:*</label>
                    <input wire:model="nom" class="h-8 text-xs ml-2" type="text" id="nom" name="nom" />

                    <label class="text-sm text-right" for="courriel">Courriel:*</label>
                    <input wire:model="courriel" class="h-8 text-xs ml-2" type="email" id="courriel"
                        name="courriel" />

                    <label class="text-sm text-right" for="telephone">Téléphone:* <br> <span
                            class="text-xs text-slate-400">Format:(123)
                            456-7890</span></label>
                    <input placeholder="(123) 456-7890" wire:model="telephone" class="h-8 text-xs ml-2" type="tel"
                        id="telephone" name="telephone" />

                    <label class="text-sm text-right" for="ddn">Date de naissance:</label>
                    <input wire:model="ddn" class="h-8 text-xs ml-2" type="date" id="ddn"
                        name="ddn" />


                    <label class="text-sm text-right" for="genre">Genre:*</label>
                    <select wire:model="genre" id="genre" name="genre" class="h-8 text-xs ml-2">
                        @foreach ($genres as $g)
                            <option value={{ $g->id }} {{ $g->id === $genre ? 'selected' : '' }}>
                                {{ $g->nom }}</option>
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

                    <label class="text-sm text-right" for="codePostal">Code postal: <br> <span
                            class="text-xs text-slate-400">Format:A0A 0A0</span></label>
                    <input placeholder="ex: A0A 0A0" wire:model="codePostal" class="h-8 text-xs ml-2" type="text"
                        id="codePostal" name="codePostal" />

                    <label class="text-sm text-right" for="ville">Ville:</label>
                    <input wire:model="ville" type="text" list="ville" class="h-8 text-xs ml-2">
                    <datalist wire:model="ville" id="ville" name="ville" class="h-8 text-xs ml-2">
                        @foreach ($villes as $v)
                            <option value={{ $v->nom }}> {{ $v->nom }}</option>
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
        <form wire:submit.prevent="modifClient" class="bg-white p-4 rounded-lg">
            <fieldset class="border-solid border-2 border-black p-4 m-4 rounded">
                <legend class="font-bold">Informations du client</legend>
                <div class="grid grid-cols-4 gap-y-4">

                    <label class="text-sm text-right" for="prenom">Prénom:*</label>
                    <input wire:model="prenom" class="h-8 text-xs ml-2" type="text" id="prenom"
                        name="prenom" />

                    <label class="text-sm text-right" for="nom">Nom:*</label>
                    <input wire:model="nom" class="h-8 text-xs ml-2" type="text" id="nom"
                        name="nom" />

                    <label class="text-sm text-right" for="courriel">Courriel:*</label>
                    <input wire:model="courriel" class="h-8 text-xs ml-2" type="email" id="courriel"
                        name="courriel" />

                    <label class="text-sm text-right" for="telephone">Téléphone:* <br> <span
                            class="text-xs text-slate-400">Format:(123)
                            456-7890</span></label>
                    <input wire:model="telephone" class="h-8 text-xs ml-2" type="tel" id="telephone"
                        name="telephone" />

                    <label class="text-sm text-right" for="ddn">Date de naissance:</label>
                    <input wire:model="ddn" class="h-8 text-xs ml-2" type="date" id="ddn"
                        name="ddn" />


                    <label class="text-sm text-right" for="genre">Genre:*</label>
                    <select wire:model="genre" id="genre" name="genre" class="h-8 text-xs ml-2">
                        @foreach ($genres as $g)
                            <option value={{ $g->id }}> {{ $g->nom }}</option>
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

                    <label class="text-sm text-right" for="codePostal">Code postal: <br> <span
                            class="text-xs text-slate-400">Format:A0A 0A0</span></label>
                    <input placeholder="ex: A0A 0A0" wire:model="codePostal" class="h-8 text-xs ml-2" type="text"
                        id="codePostal" name="codePostal" />

                    <label class="text-sm text-right" for="ville">Ville:</label>
                    <input wire:model="ville" type="text" list="ville" class="h-8 text-xs ml-2">
                    <datalist wire:model="ville" id="ville" name="ville" class="h-8 text-xs ml-2">
                        @foreach ($villes as $v)
                            <option value={{ $v->nom }}> {{ $v->nom }}</option>
                        @endforeach
                    </datalist>
                </div>

            </fieldset>
            <div class="flex justify-center">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>
        </form>
    </x-modal>

    <x-modal title="Informations du client" name="consulterClient" :show="false" maxWidth="4xl">
        <div class="border-solid border-2 border-black p-4 m-4 rounded">
            <div class="grid grid-cols-4 gap-y-4">

                <p class="text-sm text-right font-bold" for="nom">Prénom:</p>
                <p class="h-8 text-sm ml-2"> {{ $prenom }}</p>

                <p class="text-sm text-right font-bold" for="nom">Nom:</p>
                <p class="h-8 text-sm ml-2 "> {{ $nom }}</p>

                <p class="text-sm text-right font-bold" for="nom">Courriel:</p>
                <p class="h-8 text-sm ml-2"> {{ $courriel }}</p>

                <p class="text-sm text-right font-bold" for="nom">Téléphone:</p>
                <p class="h-8 text-sm ml-2"> {{ $telephone }}</p>

                <p class="text-sm text-right font-bold" for="nom">Date de naissance:</p>
                <p class="h-8 text-sm ml-2"> {{ $ddn }}</p>

                <p class="text-sm text-right font-bold" for="nom">Genre:</p>
                <p class="h-8 text-sm ml-2"> {{ $genre }}</p>

            </div>

        </div>
        <div class="border-solid border-2 border-black p-4 m-4 rounded">
            <div class="grid grid-cols-6 gap-y-4">

                <p class="text-sm text-right font-bold col-span-2" for="nom">Nom du responsable:</p>
                <p class="h-8 text-sm ml-2"> {{ $nomResponsable }}</p>

                <p class="text-sm text-right font-bold col-span-2" for="nom">Prénom du responsable:</p>
                <p class="h-8 text-sm ml-2"> {{ $prenomResponsable }}</p>

                <p class="text-sm text-right font-bold col-span-2" for="nom">Lien avec le client:</p>
                <p class="h-8 text-sm ml-2"> {{ $lienResponsable }}</p>
            </div>
        </div>
        <div class="border-solid border-2 border-black p-4 m-4 rounded">

            <div class="grid grid-cols-4 gap-y-4">
                <p class="text-sm text-right font-bold" for="nom">Rue:</p>
                <p class="h-8 text-sm ml-2"> {{ $rue }}</p>

                <p class="text-sm text-right font-bold" for="nom">Numéro civique:</p>
                <p class="h-8 text-sm ml-2"> {{ $noCivique }}</p>

                <p class="text-sm text-right font-bold" for="nom">Code postal:</p>
                <p class="h-8 text-sm ml-2"> {{ $codePostal }}</p>

                <p class="text-sm text-right font-bold" for="nom">Ville:</p>
                <p class="h-8 text-sm ml-2"> {{ $ville }}</p>
            </div>

        </div>
        <div class="flex justify-center">
            <button wire:click="getInfoClient({{ $idClient }})"
                class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Modifier</button>
        </div>
    </x-modal>

    <x-modal title="Désactiver un client" name="desactiverClient" :show="false">
        <form wire:submit.prevent="desacClient" class="bg-white p-4 rounded-lg">
            <div class="">
                <p>Êtes vous sûr de vouloir désactiver ce client</p><br>
                <p>{{ $prenom }} {{ $nom }} </p>

            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>
</div>
