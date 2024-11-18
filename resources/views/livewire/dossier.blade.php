<div class="flex min-h-screen">
    <div class="w-1/5 p-4 border-r border-gray-300">
        <div class="items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mb-2">

            <!--<label class="ml-4 text-m text-right font-bold" for="actif">Statut:</label>
            <select wire:change="filtreDossier" wire:model="filtreActif" id="filtreActif" name="filtreActif"
                class="h-8 text-m ml-2 py-0 rounded mb-2">
                <option value='1' selected>Actif</option>
                <option value='0'>Inactif</option>
                <option value='2'>Tous</option>
            </select>

            <button wire:click="resetFilters"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">
                Réinitialiser les filtres
            </button>-->
        </div>

        <table class="table-auto w-full border-solid border-2 border-gray-400">
            <thead>
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        Dossier
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        Clients
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dossiers as $value)
                    @php
                        $isInactive = $value->client->actif == 0;
                        $isSelected = $dossier && $value->id == $dossier->id;

                        $rowClass = $isSelected ? 'bg-blue-300' : ($loop->odd ? 'bg-white' : 'bg-table-green');
                        $textClass = $isInactive ? 'text-red-500' : '';
                    @endphp

                    <tr class="{{ $rowClass }} hover:bg-blue-300 cursor-pointer">
                        <td wire:click="consulterDossier({{ $value->id }})" class="w-auto pr-4 {{ $textClass }}">{{ $value->client->id }}</td>
                        <td wire:click="consulterDossier({{ $value->id }})" class="w-auto pr-4 {{ $textClass }}">{{ $value->client->nom }} {{ $value->client->prenom }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="w-4/5 p-4">
        <div class="w-full bg-green flex">
            @if ($client)
                <div class="w-1/2 p-2">
                    <h1 class="text-xl font-bold mb-2">{{ $client->prenom }} {{ $client->nom }}</h1>
                    <p class="text-x">Date de naissance : {{ $client->ddn ?? 'Non complétée' }}</p>
                </div>

                <div class="w-1/2 p-2">
                    <p class="text-right"><strong>Téléphone : </strong>{{ $client->telephone }}</p>
                    <p class="text-right"><strong>Courriel : </strong>{{ $client->courriel }}</p>

                    @php
                        $adresseComplete = $client->noCivique && $client->rue && $client->codePostal && $client->ville?->nom && $client->ville?->province?->nom;
                    @endphp
                    <p class="text-right font-semibold">
                        Adresse :
                        @if ($adresseComplete)
                            {{ $client->noCivique }} {{ $client->rue }},
                            {{ $client->codePostal }},
                            {{ $client->ville->nom }}
                            ({{ $client->ville->province->nom }})
                        @else
                            Non complétée
                        @endif
                    </p>
                </div>
            @else
                <p>Sélectionnez un client dans le tableau pour voir ses informations.</p>
            @endif
        </div>

        <div class="pt-12 pb-0 mb-0">
            <div class="flex space-x-4 mb-4 bg-dark-green">
                @if ($client)
                    @if ($view)
                        @if ($view == "Fiches")
                            <button wire:click="setView('Fiches')" class="btn w-1/3 p-2 bg-green">Fiches du dossier</button>
                            <button wire:click="setView('Images')" class="btn w-1/3 p-2">Images</button>
                            <button wire:click="setView('Documents')" class="btn w-1/3 p-2">Documents</button>
                        @elseif ($view == "Images")
                            <button wire:click="setView('Fiches')" class="btn w-1/3 p-2">Fiches du dossier</button>
                            <button wire:click="setView('Images')" class="btn w-1/3 p-2 bg-green">Images</button>
                            <button wire:click="setView('Documents')" class="btn w-1/3 p-2">Documents</button>
                        @else
                            <button wire:click="setView('Fiches')" class="btn w-1/3 p-2">Fiches du dossier</button>
                            <button wire:click="setView('Images')" class="btn w-1/3 p-2">Images</button>
                            <button wire:click="setView('Documents')" class="btn w-1/3 p-2 bg-green">Documents</button>
                        @endif
                    @else
                        <button wire:click="setView('Fiches')" class="btn w-1/3 p-2">Fiches du dossier</button>
                        <button wire:click="setView('Images')" class="btn w-1/3 p-2">Images</button>
                        <button wire:click="setView('Documents')" class="btn w-1/3 p-2">Documents</button>
                    @endif
                @endif
            </div>
        </div>


        @if ($view == "Fiches")
            <div class="flex z-0">
                <button wire:click="redirectAjouterFiche" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide">
                    Ajouter
                </button>

                <input wire:model.live="searchFiche" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mb-2 ml-auto">
            </div>

            <table class="table-auto w-full border-solid border-2 border-gray-400">
                <thead>
                    <tr>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByFiche('id')" class="font-bold">
                                Numéro
                                @if ($sortField === 'id')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByFiche('typeFiche.nom')" class="font-bold">
                                Type fiche
                                @if ($sortField === 'typeFiche.nom')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByFiche('dateHeure')" class="font-bold">
                                Date de dernière modification
                                @if ($sortField === 'dateHeure')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($fiches)
                        @foreach ($fiches as $fiche)
                            <tr
                                class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                                <td wire:click="consulterFiche({{ $fiche->id }})" class="w-auto pr-4">{{ $fiche->id }}</td>
                                <td wire:click="consulterFiche({{ $fiche->id }})" class="w-auto pr-4">{{ $fiche->TypeFiche->nom }}</td>
                                <td wire:click="consulterFiche({{ $fiche->id }})" class="w-auto pr-4">{{ $fiche->dateHeure }}</td>
                                <td wire:click="consulterFiche({{ $fiche->id }})" class="w-auto pr-4 justify-between">
                                    <button wire:click="redirectModifierFiche({{$fiche->id}})" type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                        Modifier
                                    </button>

                                    <button wire:click="supprimerFiche({{$fiche->id}})" type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>

        @elseif ($view == "Images")

            <div class="flex z-0">
                <button wire:click="openModalAjouterImage()" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide">
                    Ajouter
                </button>

                <input wire:model.live="searchImage" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mb-2 ml-auto">
            </div>

            <table class="table-auto w-full border-solid border-2 border-gray-400">
                <thead>
                    <tr>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByImage('id')" class="font-bold">
                                Numéro
                                @if ($sortField === 'id')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByImage('nom')" class="font-bold">
                                Nom de l'image
                                @if ($sortField === 'nom')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByImage('dateHeureAjout')" class="font-bold">
                                Date de dernière modification
                                @if ($sortField === 'dateHeureAjout')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByImage('lien')" class="font-bold">
                                Lien
                                @if ($sortField === 'lien')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($images)
                        @foreach ($images as $image)
                            <tr
                                class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                                <td class="w-auto pr-4">{{ $image->id }}</td>
                                <td class="w-auto pr-4">{{ $image->nom }}</td>
                                <td class="w-auto pr-4">{{ $image->dateHeureAjout }}</td>
                                <td class="w-auto pr-4">
                                    <a href="{{ asset('storage/' . $image->lien) }}" target="_blank" class="text-blue-500 hover:underline">
                                        Voir l'image
                                    </a>
                                </td>
                                <td class="w-auto pr-4 justify-between">
                                    <button wire:click="modifierImage({{ $image->id }})" type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                        Modifier
                                    </button>

                                    <button type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5" wire:click="confirmDelete({{ $image->id }})">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>

        @elseif ($view == "Documents")

            <div class="flex z-0">
                <button wire:click="openModalAjouterDocument()" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide">
                    Ajouter
                </button>

                <input wire:model.live="searchDocument" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mb-2 ml-auto">
            </div>

            <table class="table-auto w-full border-solid border-2 border-gray-400">
                <thead>
                    <tr>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByDocument('id')" class="font-bold">
                                Numéro
                                @if ($sortField === 'id')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByDocument('nom')" class="font-bold">
                                Nom du document
                                @if ($sortField === 'nom')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByDocument('dateHeureAjout')" class="font-bold">
                                Date de dernière modification
                                @if ($sortField === 'dateHeureAjout')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortByDocument('lien')" class="font-bold">
                                Lien
                                @if ($sortField === 'lien')
                                    @if ($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </button>
                        </th>

                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($documents)
                        @foreach ($documents as $document)
                            <tr
                                class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                                <td class="w-auto pr-4">{{ $document->id }}</td>
                                <td class="w-auto pr-4">{{ $document->nom }}</td>
                                <td class="w-auto pr-4">{{ $document->dateHeureAjout }}</td>
                                <td class="w-auto pr-4">
                                    <a href="{{ asset('storage/' . $document->lien) }}" target="_blank" class="text-blue-500 hover:underline">
                                        Voir le document
                                    </a>
                                </td>
                                <td class="w-auto pr-4 justify-between">
                                    <button wire:click="modifierImage({{ $document->id }})" type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                        Modifier
                                    </button>

                                    <button type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5" wire:click="confirmDeleteDocument({{ $document->id }})">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        @endif
    </div>

    <x-modal title="Ajouter une image" name="ajouterImage" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="ajouterImage">
                <div class="mb-4">
                    <label for="nomImage" class="block text-sm font-medium text-gray-700">Nom de l'image *</label>
                    <input required minlength="3" type="text" name="nomImage" id="nomImage"
                        wire:model="nomImage"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium">Image *</label>
                    <input type="file" accept=".jpg, .jpeg, .png" id="image" wire:model="image"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('image')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    @if ($showDeleteConfirmation)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirmation de suppression</h2>
                <p>Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.</p>
                <div class="mt-6 flex justify-end">
                    <button wire:click="cancelDelete"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-2">
                        Annuler
                    </button>
                    <button wire:click="deleteImage"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    @endif

    <x-modal title="Modifier l'image" name="modifierImage" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="updateImage">
                <div class="mb-4">
                    <label for="nomImage" class="block text-sm font-medium text-gray-700">Nom de l'image *</label>
                    <input required minlength="3" type="text" name="nomImage" id="nomImage"
                        wire:model="nomImage"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium">Image *</label>
                    <input type="file" accept=".jpg, .jpeg, .png" id="image" wire:model="image"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('image')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </x-modal>



    <x-modal title="Ajouter un document" name="ajouterDocument" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="ajouterDocument">
                <div class="mb-4">
                    <label for="nomDocument" class="block text-sm font-medium text-gray-700">Nom du document *</label>
                    <input required minlength="3" type="text" name="nomDocument" id="nomDocument"
                        wire:model="nomDocument"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="document" class="block text-sm font-medium">Document *</label>
                    <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" id="document" wire:model="document"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('document')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    @if ($showDeleteConfirmationDocument)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Confirmation de suppression</h2>
                <p>Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irréversible.</p>
                <div class="mt-6 flex justify-end">
                    <button wire:click="cancelDelete"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-2">
                        Annuler
                    </button>
                    <button wire:click="deleteDocument"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    @endif

    <x-modal title="Modifier le document" name="modifierDocument" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="updateDocument">
                <div class="mb-4">
                    <label for="nomDocument" class="block text-sm font-medium text-gray-700">Nom du document *</label>
                    <input required minlength="3" type="text" name="nomDocument" id="nomDocument"
                        wire:model="nomDocument"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="document" class="block text-sm font-medium">Document *</label>
                    <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" id="document" wire:model="document"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('document')
                        <span class="error text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

</div>
