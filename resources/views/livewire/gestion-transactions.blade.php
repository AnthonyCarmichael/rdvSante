<div>
    <label class="text-m text-right font-bold" for="name">Nom:</label>
    <input wire:change="filtrePaiement" wire:model="filtreClient" type="text" list="filtreClient"
        class="h-8 text-m ml-2 mb-4">
    <datalist wire:model="filtreClient" id="filtreClient" name="filtreClient" class="h-8 text-xs ml-2">
        @foreach ($clients as $c)
            <option data-value={{ $c->id }}>{{ $c->prenom }} {{ $c->nom }}</option>
        @endforeach
    </datalist>

    <label class="ml-4 text-m text-right font-bold" for="name">Période:</label>
    <select wire:change="filtrePaiement" wire:model="filtrePeriode" id="filtrePeriode" name="filtrePeriode"
        class="h-8 text-m ml-2 mb-4 py-0">
        <option value='1' selected>Aujourd'hui</option>
        <option value='2'>Le dernier mois</option>
        <option value='3'>Les trois derniers mois</option>
        <option value='4'>Les six derniers mois</option>
        <option value='5'>La dernière année</option>
        <option value='6'>Tous</option>
    </select>


    <label class="ml-4 text-m text-right font-bold" for="filtreType">Type de transaction:</label>
    <select wire:change="filtrePaiement" wire:model="filtreType" id="filtreType" name="filtreType"
        class="h-8 text-m ml-2 mb-4 py-0">
        <option value='1' selected>Paiement</option>
        <option value='2'>Remboursement</option>
        <option value='3'>Tous</option>
    </select>
    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Client</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Date et heure</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-1/12">Montant</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Type de transaction
                    </th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Moyen de paiement
                    </th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/12">Actions</th>
                </tr>
            </thead>
            @php
                $cpt = 0;
            @endphp

            @foreach ($transactions as $t)
                <?php if ($cpt%2 == 0){ ?>
                <tr class="bg-white">
                    @if ($t->idTypeTransaction == 1)
                        @foreach ($rdvs as $r)
                            @if ($r->id == $t->idRdv)
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
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4">
                            {{ $t->dateHeure }}</td>
                        <td class="w-1/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tt)
                            @if ($tt->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tt->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiements as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        @php
                            $rdv = 0;
                            $client = 0;
                            foreach ($rdvs as $r) {
                                if ($r->id == $t->idRdv) {
                                    $rdv = $r;
                                }

                                foreach ($dossiers as $d) {
                                    if ($r->idDossier == $d->id) {
                                        foreach ($clients as $c) {
                                            if ($c->id == $d->idClient) {
                                                $client = $c;
                                            }
                                        }
                                    }
                                }
                            }

                        @endphp
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"><a
                                    href="pdf/{{ $client->id }}/{{ $t->id }}/{{ $rdv->idClinique }}/{{ $rdv->id }}/{{ $rdv->idService }}">Envoyer
                                    le
                                    reçu</a></button>
                            {{ $trouve = false }}
                            @foreach ($remboursements as $r)
                                @if ($r->idTransaction == $t->id)
                                    <?php
                                    $trouve = true;
                                    break; ?>
                                @endif
                            @endforeach
                            @if ($trouve == false)
                                <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                    wire:click="formRemboursement({{ $t->id }})">Rembourser</button>
                            @endif
                    @endif
                    @if ($t->idTypeTransaction == 2)
                        @foreach ($rdvs as $r)
                            @if ($r->id == $t->idRdv)
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
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4">
                            {{ $t->dateHeure }}</td>
                        <td class="w-1/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tt)
                            @if ($tt->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tt->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiements as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"><a
                                    href="pdf/{{ $client->id }}/{{ $t->id }}/{{ $rdv->idClinique }}/{{ $rdv->id }}/{{ $rdv->idService }}">Envoyer
                                    le
                                    reçu</a></button>
                        </td>
                    @endif
                </tr>
                <?php } else { ?>
                <tr class="bg-table-green">
                    @if ($t->idTypeTransaction == 1)
                        @foreach ($rdvs as $r)
                            @if ($r->id == $t->idRdv)
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
                            @endif
                        @endforeach
                        <td class="w-2/1 pr-4">
                            {{ $t->dateHeure }}</td>
                        <td class="w-1/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tt)
                            @if ($tt->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tt->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiements as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"><a
                                    href="pdf/{{ $client->id }}/{{ $t->id }}/{{ $rdv->idClinique }}/{{ $rdv->id }}/{{ $rdv->idService }}">Envoyer
                                    le reçu</a></button>
                            {{ $trouve = false }}
                            @foreach ($remboursements as $r)
                                @if ($r->idTransaction == $t->id)
                                    <?php
                                    $trouve = true;
                                    break; ?>
                                @endif
                            @endforeach
                            @if ($trouve == false)
                                <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                    wire:click="formRemboursement({{ $t->id }})">Rembourser</button>
                            @endif
                    @endif
                    @if ($t->idTypeTransaction == 2)
                        @foreach ($rdvs as $r)
                            @if ($r->id == $t->idRdv)
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
                            @endif
                        @endforeach
                        <td class="w-2/1 pr-4">
                            {{ $t->dateHeure }}</td>
                        <td class="w-1/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tt)
                            @if ($tt->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tt->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiements as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"><a
                                    href="pdf/{{ $client->id }}/{{ $t->id }}/{{ $rdv->idClinique }}/{{ $rdv->id }}/{{ $rdv->idService }}">Envoyer
                                    le reçu</a></button>
                        </td>
                    @endif
                </tr>
                <?php } ?>

                <?php $cpt += 1; ?>
            @endforeach

        </table>
    </div>
    <x-modal title="Remboursement" name="rembourserPaiement" :show="false">
        <ul class="ml-8">

        </ul>

        <form wire:submit.prevent="remboursementPaiement" class="bg-white p-4 rounded-lg">

            <div class=" flex justify-center wrap gap-y-4 w-full">
                <label class="text-md text-center w-full" for="moyenPaiement">De quel façon sera fait le
                    remboursement?</label>
                <select wire:model="moyenPaiement" id="moyenPaiement" name="moyenPaiement"
                    class="h-12 text-md ml-2 w-1/2">
                    @foreach ($moyenPaiements as $m)
                        <option value={{ $m->id }} {{ $m->id === $moyenPaiement ? 'selected' : '' }}>
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
