
<div class="">
    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)">
            <option value="semaine" {{ $view === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois" {{ $view === 'mois' ? 'selected' : '' }}>Mois</option>
        </select>
    </div>

    <!-- Affichage de la vue sélectionnée -->
    <div>
        @if($view === 'semaine')
            <!-- Affichage de la vue semaine -->
            <p>Vue Semaine {{$startingDate}} </p>
            
        @elseif($view === 'mois')
            <!-- Affichage de la vue mois -->
            <p>Vue Mois {{$startingDate}}</p>
        @endif
    </div>

    
    <table class="text-left table-fixed">
        <thead>
            <tr>
                <!-- Titre col -->
                <th>Heure</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
                <th>Dimanche</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>

        </tfoot>
    </table> 
</div>



