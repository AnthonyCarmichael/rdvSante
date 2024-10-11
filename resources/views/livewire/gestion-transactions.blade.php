<div>
    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Client</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Date et heure</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-1/12">Montant</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Type de transaction
                    </th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/12">Moyen de paiement</th>
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
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                wire:click="desactiverClient({{ $t->id }})">Envoyer le reçu</button>
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                wire:click="formRemboursement({{ $t->id }})">Rembourser</button>
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
                                    {{ $tp->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiements as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-3/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                wire:click="desactiverClient({{ $t->id }})">Envoyer le reçu</button>
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
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                wire:click="desactiverClient({{ $t->id }})">Envoyer le reçu</button><button
                                class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                wire:click="formRemboursement({{ $t->id }})">Rembourser</button>
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
                            <button class="w-5/12 bg-selected-green mx-0.5 my-1 rounded p-0.5" type="button"
                                wire:click="desactiverClient({{ $t->id }})">Envoyer le reçu</button>
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
                <label class="text-md text-center w-full" for="moyenPaiement">De quel façon sera fait le remboursement?</label>
                <select wire:model="moyenPaiement" id="moyenPaiement" name="moyenPaiement" class="h-12 text-md ml-2 w-1/2">
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
