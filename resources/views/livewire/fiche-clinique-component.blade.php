<section>

    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)"
            class="border-none bg-mid-green">
            @foreach ($typeFiches as $typeFiche )
                <option  wire:model="typeFicheId" value="{{$typeFiche->id}}">{{$typeFiche->nom}}</option>
            @endforeach
        </select>
    </div>


    <form wire:submit.prevent="ajouterFiche">

    </form>
</section>
