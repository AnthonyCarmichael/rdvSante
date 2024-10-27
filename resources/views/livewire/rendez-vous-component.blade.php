<div>
    <x-modal title="Ajouter un rendez-vous" name="ajouterRdv" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="createRdv">
                <p class="block text-sm font-medium text-gray-700">Date et heure sélectionnées:</p>
                <p class="mb-5">{{$formattedDate}}</p>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="client">Choisir un client :</label>
                    <input type="text" wire:model.live="filter" name="recherche" id="recherche" placeholder="Recherche" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <select required name="client" wire:model="clientSelected" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" size="5">
                        <option class="font-bold" value="" disabled>Sélectionnez un client</option>
                        @if (!is_null($clients))
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->prenom." ".$client->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                    <select required id="service" name="serviceSelected" wire:model="serviceSelected" size="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="">Sélectionnez un service</option>
                        @if (!is_null($services))
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>


                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                    <select required id="clinique" wire:model="cliniqueSelected" name="clinique" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="">Sélectionnez une clinique</option>
                        @if (!is_null($cliniques))
                            @foreach($cliniques as $clinique)
                                <option value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="raison">Raison du rendez-vous :</label>
                    <textarea name="raison" id="raison" wire:model="raison"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="4"></textarea>
                </div>

                <div class="mt-8">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Consulter et modifier -->
    <x-modal title="Rendez-vous" name="consulterRdv" :show="false">
        <div class="border-b flex text-sm">
            <button type="button" 
                class="px-4 py-2 rounded  {{ $sousMenuConsult === 'rdv' ? 'bg-green  cursor-default text-white' : 'bg-pale-green hover:bg-green hover:text-white' }}"
                wire:click="changeSousMenu('rdv')"
                >Rendez-vous</button>
            <button type="button" 
                class="px-4 py-2 rounded {{ $sousMenuConsult === 'facture' ? 'bg-green  cursor-default text-white' : 'bg-pale-green hover:bg-green hover:text-white' }}"
                wire:click="changeSousMenu('facture')"
                >Facturation</button>
            
        </div>

        @if ($sousMenuConsult==="rdv")
            <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ editable: false }" @reset-editable.window="editable = false">
                <form wire:submit.prevent="modifierRdv">

                    <div>
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Erreurs :</strong>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div x-show="!editable">
                            <p class="block text-sm font-medium text-gray-700">Date: <p class="">{{$formattedDate}}</p></p>
                            <p class="block mt-3 text-sm font-medium text-gray-700">Début: <p class="">{{$formattedDateDebut}}</p></p>
                            <p class="block mt-3 text-sm font-medium text-gray-700">Fin: <p class="">{{$formattedDateFin}}</p></p>
                        </div>
                        <div x-show="editable">
                            <p class="block text-sm font-medium text-gray-700">Date et heure sélectionnées:</p>
                            <p class="mb-5">{{$formattedDate}}</p>
                        </div>
                    </div>


                    <div>
                        <div x-show="!editable">
                            <label class="block mt-3 text-sm font-medium text-gray-700" for="client">Client :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{$rdv->client->prenom}} {{$rdv->client->nom}}
                                @endif
                            </p>
                        </div>

                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="client">Choisir un client :</label>
                            <input type="text" wire:model.live="filter" name="recherche" id="recherche" placeholder="Recherche"  
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <select required name="client" wire:model="clientSelected" :disabled="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" size="5">
                                <option class="font-bold" value="" disabled>Sélectionnez un client</option>
                                @if (!is_null($clients))
                                    @foreach($clients as $client)
                                        @if (isset($rdv) && $client->id == $rdv->client->id)
                                            <option selected value="{{ $client->id }}">{{ $client->prenom." ".$client->nom }}</option>
                                        @else
                                            <option value="{{ $client->id }}">{{ $client->prenom." ".$client->nom }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                    </div>

                    <div class="mt-3">

                        <div x-show="!editable">
                            <label class="block text-sm font-medium text-gray-700" for="client">Service :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{$rdv->service->nom}}
                                @endif
                            </p>
                        </div>
                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                            <select required id="service" name="serviceSelected" wire:model="serviceSelected" size="1" :disabled="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option class="font-bold" value="">Sélectionnez un service</option>
                                @if (!is_null($services))
                                    @foreach($services as $service)
                                        @if (isset($rdv) && $service->id == $rdv->service->id)
                                            <option selected value="{{ $service->id }}">{{ $service->nom }}</option>
                                        @else
                                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                        @endif
                                        
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    <div class="mt-3">
                        <div x-show="!editable">
                            <label class="block text-sm font-medium text-gray-700" for="client">Clinique :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{$rdv->clinique->nom}}
                                @endif
                            </p>
                        </div>

                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                            <select required id="clinique" wire:model="cliniqueSelected" name="clinique" :readonly="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option class="font-bold" value="">Sélectionnez une clinique</option>
                                @if (!is_null($cliniques))
                                    @foreach($cliniques as $clinique)
                                        @if (isset($rdv) && $clinique->id == $rdv->clinique->id)
                                            <option selected value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                                        @else
                                            <option value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700" for="raison">Raison du rendez-vous :</label>
                        <div x-show="!editable">
                            <p class="">
                                @if (isset($raison))
                                    {{$raison}}
                                @else
                                    Non spécifiée
                                @endif
                            </p>
                        </div>

                        <div x-show="editable">
                            
                            <textarea name="raison" id="raison" wire:model="raison" :readonly="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="4">
                            </textarea>
                        </div>

                    </div>

                    <div class="flex mt-6">
                        <div x-show="editable">
                            <button type="submit" class="mr-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                        </div>
                        <button type="button" @click="editable = false; @this.annuler()" x-show="editable" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">
                            Annuler
                        </button>
                        <button type="button" @click="editable = !editable" x-show="!editable" class="px-4 py-2 text-white rounded bg-orange-500 hover:bg-orange-700">
                            Modifier
                        </button>
                        <button type="button" @click="$dispatch('open-modal', { name: 'confirmDeleteRdvModal' });" x-show="!editable" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded bg-red-500 hover:bg-red-700">
                            Supprimer
                        </button>
                    </div>
                </form>
            </div>
        @elseif($sousMenuConsult==="facture")
            <!-- Permet de consulter les informations lier a la facturation d'un rdv -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p>Facture</p>
            </div>
        @endif

    </x-modal>

    <x-modal title="Confirmer la Suppression" name="confirmDeleteRdvModal" :show="false">
        <p class="block text-sm font-medium text-gray-700">Êtes-vous sûr de vouloir supprimer ce rendez-vous ?</p>
        <p class="block text-sm font-medium text-gray-700">Si des transactions ont été effectuées, le client sera <b>remboursé</b>.</p>

        <div class="flex mt-8">
            <button wire:click="deleteRdv" class="mr-4 px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">Supprimer</button>
            <button @click="$dispatch('open-modal', { name: 'consulterRdv' });" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">Annuler</button>
        </div>
    </x-modal>
</div>
