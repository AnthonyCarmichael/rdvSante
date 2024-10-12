<div>
    <div class="overflow-auto max-h-96">
        <table class="table-auto w-full">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Client</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Date et heure</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Montant</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Type de transactions</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Moyen de paiement</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Remboursement</th>
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
                        <td class="w-2/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tp)
                            @if ($tp->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tp->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiement as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4 justify-between">
                            <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                wire:click="desactiverClient({{ $t->id }})">Rembourser</button>
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
                        <td class="w-2/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tp)
                            @if ($tp->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tp->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiement as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4 justify-between">
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
                        <td class="w-2/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tp)
                            @if ($tp->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tp->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiement as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4 justify-between"><button
                                class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                wire:click="getInfoClient({{ $t->id }})">Rembourser</button>
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
                        <td class="w-2/12 pr-4">
                            {{ $t->montant }}</td>
                        @foreach ($typeTransactions as $tp)
                            @if ($tp->id == $t->idTypeTransaction)
                                <td class="w-2/12 pr-4">
                                    {{ $tp->nom }}</td>
                            @endif
                        @endforeach
                        @foreach ($moyenPaiement as $m)
                            @if ($m->id == $t->idMoyenPaiement)
                                <td class="w-2/12 pr-4">
                                    {{ $m->nom }}</td>
                            @endif
                        @endforeach
                        <td class="w-2/12 pr-4 justify-between">
                    @endif
                    </td>
                </tr>
                <?php } ?>

                <?php $cpt += 1; ?>
            @endforeach

        </table>
    </div>
</div>
