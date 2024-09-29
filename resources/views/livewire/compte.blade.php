<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="mg-auto center">
        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium">Nom</label>
            <input type="text" id="nom" wire:model="nom" class="mt-1 block w-full">
            @error('nom') <span class="error text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="prenom" class="block text-sm font-medium">Prénom</label>
            <input type="text" id="prenom" wire:model="prenom" class="mt-1 block w-full">
            @error('prenom') <span class="error text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" wire:model="email" class="mt-1 block w-full">
            @error('email') <span class="error text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium">Téléphone</label>
            <input type="text" id="telephone" wire:model="telephone" class="mt-1 block w-full">
            @error('telephone') <span class="error text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="idProfession" class="block text-sm font-medium">Profession</label>
            <select id="idProfession" wire:model="idProfession" class="mt-1 block w-full">
                <option value="">Sélectionnez une profession</option>
                @foreach (\App\Models\Profession::all() as $profession)
                    <option value="{{ $profession->id }}">{{ $profession->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="idRole" class="block text-sm font-medium">Rôle</label>
            <select id="idRole" wire:model="idRole" class="mt-1 block w-full">
                <option value="">Sélectionnez un rôle</option>
                @foreach (\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}">{{ $role->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
