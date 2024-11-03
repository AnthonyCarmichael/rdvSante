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
                                {{ $s->prix }}$</td>
                            <?php $solde += $s->prix; ?>
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
                        $solde = 0;
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
                    </td>
                </tr>
                <?php $cpt += 1; }
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
                                {{ $s->prix }}$</td>
                            <?php $solde += $s->prix; ?>
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
                        $solde = 0;
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
                    </td>
                </tr>
                <?php $cpt += 1; }  ?>
            @endforeach


        </table>
    </div>

    <div class="flex justify-end z-0">
        <a href="factureTout/{{ $rdvs }}" class="w-2/12"><button
                class="w-full bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button">Tout
                télécharger</button></a>
    </div>
</div>
