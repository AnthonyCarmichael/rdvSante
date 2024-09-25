<div>
    <h3>Indisponibilités</h3>
    <ul>
        @foreach($indisponibilites as $indisponibilite)
            <li>{{ $indisponibilite->note }} ({{ $indisponibilite->dateHeureDebut }} - {{ $indisponibilite->dateHeureFin }})</li>
        @endforeach
    </ul>

</div>
