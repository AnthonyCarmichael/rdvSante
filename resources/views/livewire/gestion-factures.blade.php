<div>
    <label class="text-m text-right font-bold" for="name">Nom:</label>
    <input wire:change="filtrePaiement" wire:model="filtreClient" type="text" list="filtreClient"
        class="h-8 text-m ml-2 mb-4">
    <datalist wire:model="filtreClient" id="filtreClient" name="filtreClient" class="h-8 text-xs ml-2">
        @foreach ($clients as $c)
            <option data-value={{ $c->id }}>{{ $c->prenom }} {{ $c->nom }}</option>
        @endforeach
    </datalist>

    <label class="ml-4 text-m text-right font-bold" for="dateDebut">Date de début:</label>
    <input wire:change="filtrePaiement" wire:model="dateDebut" type="date" class="h-8 text-m ml-2 mb-4">

    <label class="ml-4 text-m text-right font-bold" for="dateFin">Date de fin:</label>
    <input wire:change="filtrePaiement" wire:model="dateFin" type="date" class="h-8 text-m ml-2 mb-4">

    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-1/12">No facture</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Client</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Date</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Total
                    </th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Solde
                    </th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/12">Action</th>
                </tr>
            </thead>
            @php
                $cpt = 0;
                $solde = 0;
            @endphp
            @foreach ($rdvs as $r)
                <?php if ($cpt%2 == 0){ ?>
                <tr class="bg-white">
                    <td> {{ $r->id }} </td>
                    @foreach ($dossiers as $d)
                        @if ($r->idDossier == $d->id)
                            @foreach ($clients as $c)
                                @if ($c->id == $d->idClient)
                                    <td class="w-2/12 pr-4">
                                        {{ $c->prenom }} {{ $c->nom }}</td>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <td> {{ $r->dateHeureDebut }} </td>

                    @foreach ($services as $s)
                        @if ($r->idService == $s->id)
                            <td class="w-2/12 pr-4">
                                {{ number_format($s->prix + ($s->prix * $tvq->valeur) / 100 + ($s->prix * $tps->valeur) / 100, 2) }}$
                            </td>
                            <?php $solde += $s->prix + ($s->prix * $tvq->valeur) / 100 + ($s->prix * $tps->valeur) / 100; ?>
                        @endif
                    @endforeach
                    @foreach ($transactions as $t)
                        @if ($t->idRdv == $r->id)
                            @if ($t->idTypeTransaction == 1)
                                <?php $solde -= $t->montant; ?>
                            @endif
                            @if ($t->idTypeTransaction == 2)
                                <?php $solde += $t->montant; ?>
                            @endif
                        @endif
                    @endforeach
                    <td>{{ number_format($solde, 2) }}$</td>
                    @php

                        $client = 0;

                        foreach ($dossiers as $d) {
                            if ($r->idDossier == $d->id) {
                                foreach ($clients as $c) {
                                    if ($c->id == $d->idClient) {
                                        $client = $c;
                                    }
                                }
                            }
                        }

                    @endphp
                    <td>
                        <a
                            href="facture/{{ $client->id }}/{{ $r->idClinique }}/{{ $r->id }}/{{ $r->idService }}">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5"
                                type="button">Télécharger
                            </button>
                        </a>
                        <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5"
                            wire:click="addPaiement({{ $r->id }}, {{ $solde }})" type="button">Payer
                        </button>
                    </td>
                </tr>
                <?php $cpt += 1;
                $solde = 0; }
                else{ ?>
                <tr class="bg-table-green">
                    <td> {{ $r->id }} </td>

                    @foreach ($dossiers as $d)
                        @if ($r->idDossier == $d->id)
                            @foreach ($clients as $c)
                                @if ($c->id == $d->idClient)
                                    <td class="w-2/12 pr-4">
                                        {{ $c->prenom }} {{ $c->nom }}</td>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <td> {{ $r->dateHeureDebut }} </td>

                    @foreach ($services as $s)
                        @if ($r->idService == $s->id)
                            <td class="w-2/12 pr-4">
                                {{ number_format($s->prix + ($s->prix * $tvq->valeur) / 100 + ($s->prix * $tps->valeur) / 100, 2) }}$
                            </td>
                            <?php $solde += $s->prix + ($s->prix * $tvq->valeur) / 100 + ($s->prix * $tps->valeur) / 100; ?>
                        @endif
                    @endforeach
                    @foreach ($transactions as $t)
                        @if ($t->idRdv == $r->id)
                            @if ($t->idTypeTransaction == 1)
                                <?php $solde -= $t->montant; ?>
                            @endif
                            @if ($t->idTypeTransaction == 2)
                                <?php $solde += $t->montant; ?>
                            @endif
                        @endif
                    @endforeach
                    <td>{{ number_format($solde, 2) }}$</td>

                    @php

                        $client = 0;

                        foreach ($dossiers as $d) {
                            if ($r->idDossier == $d->id) {
                                foreach ($clients as $c) {
                                    if ($c->id == $d->idClient) {
                                        $client = $c;
                                    }
                                }
                            }
                        }

                    @endphp
                    <td><a
                            href="facture/{{ $client->id }}/{{ $r->idClinique }}/{{ $r->id }}/{{ $r->idService }}">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5"
                                type="button">Télécharger
                            </button>
                        </a>
                        <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5"
                            wire:click="addPaiement({{ $r->id }}, {{ $solde }})" type="button">Payer
                        </button>
                    </td>
                </tr>
                <?php $cpt += 1;
            $solde = 0; }  ?>
            @endforeach


        </table>
    </div>

    <div class="flex justify-end z-0">
        <a href="factureTout/{{ $rdvs }}" class="w-2/12"><button
                class="w-full bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button">Tout
                télécharger</button></a>
    </div>

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
                <label class="text-md text-center w-full" for="montant">Il reste {{ number_format($restePayer, 2) }}$ à
                    payer. Quel est le montant du
                    paiement?</label>
                <input wire:model="montant" class="h-12 text-md ml-2 w-full" type="number" step="0.01"
                    id="montant" name="montant" max={{ $restePayer }} />

                <label class="text-md text-center w-full" for="moyenPaiement">De quel façon sera
                    fait le
                    paiement?</label>
                <select wire:model="moyenPaiement" id="moyenPaiement" name="moyenPaiement"
                    class="h-12 text-md ml-2 w-full">
                    @foreach ($moyenPaiements as $m)
                        <option value={{ $m->id }}>
                            {{ $m->nom }}</option>
                    @endforeach
                </select>


            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>
</div>
