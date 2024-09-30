<div>
    <div class="overflow-auto max-h-96">
        <table class="w-full border-solid border border-black mb-8">
            <thead class="sticky top-0">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8">Jour</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/8">Heure de début</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2-8">Heure de fin</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left w-1/8">Action</th>
                </tr>
            </thead>
            @php
                $cpt = 0;
            @endphp

            @foreach ($jour as $j)
                <?php if ($cpt%2 == 0){ ?>
                <tr>
                    <td class="bg-white align-top">
                        {{ $j->nom }}</td>
                    <td class="bg-white">
                        @foreach ($dispo as $d)
                            @if ($d->idJour == $j->id)
                                {{ $d->heureDebut }} <br>
                            @endif
                        @endforeach
                    </td>
                    <td class="bg-white">
                        @foreach ($dispo as $d)
                            @if ($d->idJour == $j->id)
                                {{ $d->heureFin }} <br>
                            @endif
                        @endforeach
                    </td>
                    <td class="bg-white"><button
                            class="bg-selected-green mx-1 my-1 rounded p-0.5 w-1/2" type="button">Modifier</button>
                    </td>
                </tr>
                <?php } else { ?>
                <tr>
                    <td class="bg-table-green align-top">
                        {{ $j->nom }}</td>
                    <td class="bg-table-green">
                        @foreach ($dispo as $d)
                            @if ($d->idJour == $j->id)
                                {{ $d->heureDebut }} <br>
                            @endif
                        @endforeach
                    </td>
                    <td class="bg-table-green pr-4">
                        @foreach ($dispo as $d)
                            @if ($d->idJour == $j->id)
                                {{ $d->heureFin }} <br>
                            @endif
                        @endforeach
                    </td>
                    <td class="bg-table-green"><button
                            class="bg-selected-green mx-1 my-1 rounded p-0.5 w-1/2" type="button">Modifier</button>
                    </td>
                </tr>
                <?php } ?>

                <?php $cpt += 1; ?>
            @endforeach

        </table>
    </div>
</div>
