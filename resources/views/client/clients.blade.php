<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl ml-20 sm:px-6 lg:px-8">

            <table class="table-auto">
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prénom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Courriel</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Téléphone</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Date de naissance</th>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                </tr>
                @php
                    $cpt = 0;
                @endphp
                @foreach ($clients as $client)
                    <?php if ($cpt%2 == 0){ ?>
                    <tr>
                        <td class="w-2/12 bg-white pr-4">{{ $client->prenom }}</td>
                        <td class="w-2/12 bg-white pr-4">{{ $client->nom }}</td>
                        <td class="w-2/12 bg-white pr-4">{{ $client->courriel }}</td>
                        <td class="w-2/12 bg-white pr-4">{{ $client->telephone }}</td>
                        <td class="w-2/12 bg-white pr-4">{{ $client->ddn }}</td>
                        <td class="w-2/12 bg-white pr-4 justify-between"><button
                                class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5"
                                type="button">Modifier</button><button
                                class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button">Supprimer</button>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td class="w-2/12 bg-table-green pr-4">{{ $client->prenom }}</td>
                        <td class="w-2/12 bg-table-green pr-4">{{ $client->nom }}</td>
                        <td class="w-2/12 bg-table-green pr-4">{{ $client->courriel }}</td>
                        <td class="w-2/12 bg-table-green pr-4">{{ $client->telephone }}</td>
                        <td class="w-2/12 bg-table-green pr-4">{{ $client->ddn }}</td>
                        <td class="w-2/12 bg-table-green pr-4 justify-between"><button
                                class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5"
                                type="button">Modifier</button><button
                                class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button">Supprimer</button>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php $cpt += 1; ?>
                @endforeach

            </table>
            <div class="flex justify-end">
                <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5" type="button">Ajouter</button>
            </div>

        </div>


    </div>
    </div>
    </x-app-layout>
