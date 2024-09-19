
<div class="">
    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)"
            class="border-none bg-mid-green">
            <option value="semaine" {{ $view === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois" {{ $view === 'mois' ? 'selected' : '' }}>Mois</option>
        </select>
    </div>

    <!-- Affichage de la vue sélectionnée -->
    <div>
        @if($view === 'semaine')
            <!-- Affichage de la vue semaine -->
            <p>Vue Semaine {{$startingDate->format('d-M-Y')}} </p>
            
        @elseif($view === 'mois')
            <!-- Affichage de la vue mois -->
            <p>Vue Mois {{$startingDate}}</p>
        @endif
    </div>

    
    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
        <thead>
            <tr class="bg-mid-green">
                <!-- Titre col -->
                <th class="border-black">Heure </th>
                <th>Dim {{$startingDate->format('d-M-Y')}}</th>
                <th>Lun </th>
                <th>Mar </th>
                <th>Mer </th>
                <th>Jeu </th>
                <th>Ven </th>
                <th>Sam </th>

            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>

        </tfoot>
    </table> 
</div>



