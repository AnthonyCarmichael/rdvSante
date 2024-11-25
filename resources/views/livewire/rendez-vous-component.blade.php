<div>
    <x-modal title="Ajouter un rendez-vous" name="ajouterRdv" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="createRdv">
                <p class="block text-sm font-medium text-gray-700">Date et heure sélectionnées:</p>
                <p class="mb-5">{{ $formattedDate }}</p>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="client">Choisir un client :</label>
                    <input type="text" wire:model.live="filter" name="recherche" id="recherche" placeholder="Recherche"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <select required name="client" wire:model="clientSelected"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        size="5">
                        <option class="font-bold" value="" disabled>Sélectionnez un client</option>
                        @if (!is_null($clients))
                            @foreach ($clients as $dossier)
                                <option value="{{ $dossier->client->id }}">
                                    {{ $dossier->client->prenom . ' ' . $dossier->client->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                    <select required id="service" name="serviceSelected" wire:model="serviceSelected" size="1"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="">Sélectionnez un service</option>
                        @if (!is_null($services))
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>


                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                    <select required id="clinique" wire:model="cliniqueSelected" name="clinique"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="">Sélectionnez une clinique</option>
                        @if (!is_null($cliniques))
                            @foreach ($cliniques as $clinique)
                                <option value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="raison">Raison du rendez-vous
                        :</label>
                    <textarea name="raison" id="raison" wire:model="raison"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        rows="4"></textarea>
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Consulter et modifier -->
    <x-modal title="Rendez-vous" name="consulterRdv" :show="false">
        <div class="border-b flex text-sm">
            <button type="button"
                class="px-4 py-2 rounded  {{ $sousMenuConsult === 'rdv' ? 'bg-green  cursor-default text-white' : 'bg-pale-green hover:bg-dark-green hover:text-white' }}"
                wire:click="changeSousMenu('rdv')">Rendez-vous</button>
            <button type="button"
                class="px-4 py-2 rounded {{ $sousMenuConsult === 'facture' ? 'bg-green  cursor-default text-white' : 'bg-pale-green hover:bg-dark-green hover:text-white' }}"
                wire:click="changeSousMenu('facture')">Facturation</button>

        </div>

        @if ($sousMenuConsult === 'rdv')
            <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ editable: false }"
                @reset-editable.window="editable = false">
                <form wire:submit.prevent="modifierRdv">
                    <div>
                        <div x-show="!editable">
                            <p class="block text-sm font-medium text-gray-700">Date:
                            <p class="">{{ $formattedDate }}</p>
                            </p>
                            <p class="block mt-3 text-sm font-medium text-gray-700">Début:
                            <p class="">{{ $formattedDateDebut }}</p>
                            </p>
                            <p class="block mt-3 text-sm font-medium text-gray-700">Fin:
                            <p class="">{{ $formattedDateFin }}</p>
                            </p>
                        </div>
                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="selectedTime">Date et heure
                                actuel du rendez-vous:</label>
                            <p class="mb-5">{{ $formattedDate }}</p>

                            @error('selectedDate')
                                <div>
                                    <p class="error text-red-400">{{ $message }}</p>
                                </div>
                            @enderror
                            <input type="datetime-local" wire:model="selectedTime" name="selectedTime">


                        </div>
                    </div>


                    <div>
                        <div x-show="!editable">
                            <label class="block mt-3 text-sm font-medium text-gray-700" for="client">Client :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{ $rdv->client->prenom }} {{ $rdv->client->nom }}
                                @endif
                            </p>
                        </div>

                    </div>

                    <div class="mt-3">

                        <div x-show="!editable">
                            <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{ $rdv->service->nom }}
                                @endif
                            </p>
                        </div>
                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                            <select required id="service" name="serviceSelected" wire:model="serviceSelected"
                                size="1" :disabled="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option class="font-bold" value="">Sélectionnez un service</option>
                                @if (!is_null($services))
                                    @foreach ($services as $service)
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
                            <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                            <p class="">
                                @if (isset($rdv))
                                    {{ $rdv->clinique->nom }}
                                @endif
                            </p>
                        </div>

                        <div x-show="editable">
                            <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                            <select required id="clinique" wire:model="cliniqueSelected" name="clinique"
                                :readonly="!editable"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option class="font-bold" value="">Sélectionnez une clinique</option>
                                @if (!is_null($cliniques))
                                    @foreach ($cliniques as $clinique)
                                        @if (isset($rdv) && $clinique->id == $rdv->clinique->id)
                                            <option selected value="{{ $clinique->id }}">{{ $clinique->nom }}
                                            </option>
                                        @else
                                            <option value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700" for="raison">Raison du rendez-vous
                            :</label>
                        <div x-show="!editable">
                            <p class="">
                                @if (isset($raison))
                                    {{ $raison }}
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
                            <button type="submit"
                                class="mr-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                        </div>
                        <button type="button" @click="editable = false; @this.annuler()" x-show="editable"
                            class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">
                            Annuler
                        </button>


                        <button type="button" @click="editable = !editable" x-show="!editable"
                        class="px-4 py-2 text-white rounded bg-orange-500 hover:bg-orange-700">
                            Modifier
                        </button>


                        <button type="button" @click="$dispatch('open-modal', { name: 'confirmDeleteRdvModal' });"
                            x-show="!editable"
                            class="ml-4 px-4 py-2 bg-blue-500 text-white rounded bg-red-500 hover:bg-red-700">
                            Supprimer
                        </button>
                    </div>
                </form>
            </div>
        @elseif($sousMenuConsult === 'facture')
            <!-- Permet de consulter les informations lier a la facturation d'un rdv -->

            <div class="bg-white p-6 rounded-lg shadow-md">

                <div class="flex">

                    <div class="w-1/2 border-b ">
                        <div class="flex justify-between">
                            <div>
                                <p class="inline">Sous-total</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                            </div>
                            <p class="inline pr-6">{{ $rdv->service->prix }} $</p>
                        </div>
                        @php
                            $totalvalue = $rdv->service->prix;
                        @endphp

                        @foreach ($this->taxes as $taxe)
                            <div class="flex justify-between text-xs">
                                <p class="">{{ $taxe->nom . '(' . number_format($taxe->valeur, 3) . '%)' }}</p>
                                <p class="inline pr-6">
                                    @php
                                        $taxeValue = round(($taxe->valeur / 100) * $rdv->service->prix,2);
                                        $totalvalue += $taxeValue;
                                    @endphp
                                    {{ number_format($taxeValue, 2) }} $
                                </p>
                            </div>
                        @endforeach

                    </div>
                    <div class="w-1/2 border-l border-b pl-6 flex flex-col items-end text-xs">

                        @php
                            $totalPaiement = $totalvalue;
                        @endphp
                        @foreach ($rdv->transactions as $transaction)
                            <div class="w-full flex justify-between">
                                <p class="{{ $transaction->idTypeTransaction == 2 ? 'text-red-500' : '' }}">
                                    {{ $transaction->moyenPaiement->nom }}</p>
                                <p class="{{ $transaction->idTypeTransaction == 2 ? 'text-red-500' : '' }}">
                                    {{ $transaction->dateHeure }}</p>
                                <p class="{{ $transaction->idTypeTransaction == 2 ? 'text-red-500' : '' }}">
                                    {{ $transaction->montant }} $</p>
                            </div>
                            @if ($transaction->idTypeTransaction == 2)
                            <p class="text-red-500">remboursement</p>

                            @endif


                            @php
                                if ($transaction->idTypeTransaction == 1) {
                                    $totalPaiement -= round($transaction->montant,2);
                                } elseif ($transaction->idTypeTransaction == 2) {
                                    $totalPaiement += round($transaction->montant,2);
                                }

                            @endphp
                        @endforeach


                    </div>

                </div>
                <div class="flex">
                    <div class="flex justify-between w-1/2">
                        <p>Total</p>
                        <p class="pr-6">{{ number_format($totalvalue, 2) }} $</p>

                    </div>

                    <div class=" w-1/2 flex justify-between">

                        <p class="inline pl-6">Solde</p>
                        <p class="inline">{{ number_format($totalPaiement,2)}} $</p>
                    </div>
                </div>


                <div class="border-b">
                    <button type="button" class="text-blue-300 hover:text-blue-700"
                        wire:click="addPaiement({{ $totalPaiement }})">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Ajouter un paiement
                        </div>
                    </button>
                </div>
            </div>
        @endif

    </x-modal>

    <x-modal title="Ajouter un paiement" name="ajouterPaiement" :show="false">
        <ul class="ml-8">
            @error('montant')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
        </ul>

        <form wire:submit.prevent="ajoutPaiement" class="bg-white p-4 rounded-lg">

            <div class=" grid grid-cols-2 justify-center gap-y-4 w-full">
                <label class="text-md text-center w-full" for="montant">Il reste
                    {{ number_format($restePayer, 2) }}$
                    à payer. Quel
                    est le montant du
                    paiement?</label>
                <input wire:model="montant" class="h-12 text-md ml-2 w-full" type="number" step="0.01"
                    id="montant" name="montant" max={{ number_format($restePayer, 2) }} />

                <label class="text-md text-center w-full" for="moyenPaiement">De quel façon sera
                    fait le
                    paiement?</label>
                <select wire:model="moyenPaiement" id="moyenPaiement" name="moyenPaiement"
                    class="h-12 text-md ml-2 w-full" required>
                    <option value="" selected>Sélectionner un mode de paiement</option>
                    @foreach ($moyenPaiements as $m)
                        @if ($user->cleStripe == null)
                            @if ($m->id != 1)
                                <option value={{ $m->id }}>
                                    {{ $m->nom }}</option>
                            @endif
                        @else
                            <option value={{ $m->id }}>
                                {{ $m->nom }}</option>
                        @endif
                    @endforeach
                </select>


            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Confirmer la Suppression" name="confirmDeleteRdvModal" :show="false">
        <p class="block text-sm font-medium text-gray-700">Êtes-vous sûr de vouloir supprimer ce rendez-vous ?</p>

        <div class="flex mt-8">
            <button wire:click="deleteRdv"
                class="mr-4 px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">Supprimer</button>
            <button @click="$dispatch('open-modal', { name: 'consulterRdv' });"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">Annuler</button>
        </div>
    </x-modal>
</div>
