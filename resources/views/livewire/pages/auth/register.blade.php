<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $nom = '';
    public string $prenom = '';
    public string $email = '';
    public string $telephone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $description = '';
    public string $lien = '';
    public int $idRole = 2;
    public bool $actif = false;
    public ?string $token = null;

    public function mount($token = null)
    {
        $this->token = $token;

        // Récupérer les informations d'invitation depuis le cache
        $userData = Cache::pull('invitation_' . $this->token);

        /*if (!$userData) {
            abort(403, 'Lien d\'invitation invalide ou expiré.');
        }*/
    }

    /**
     * Handle an incoming registration request.
     */
    public function register()
    {
        $validated = $this->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telephone' => ['required', 'string', 'max:20', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
            'password' => ['required', 'string', 'confirmed'],
            'description' => ['nullable', 'string'],
            'lien' => ['nullable', 'string'],
            'idRole' => ['required', 'integer'],
            'actif' => ['required', 'boolean']
        ],  [
            'nom.required' => 'Le champ nom est obligatoire.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'email.required' => 'Veuillez fournir une adresse e-mail.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'email.string' => 'Entrez une chaîne de caractères valide.',
            'email.lowercase' => 'L’email doit être en minuscules.',
            'email.max' => 'L’email ne peut pas dépasser 255 caractères.',
            'telephone.required' => 'Le champ téléphone est obligatoire.',
            'telephone.regex' => 'Respecter le format télephonique',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'password' => $validated['password'],
            'description' => $validated['description'] ?? null,
            'lien' => $validated['lien'] ?? null,
            'idRole' => $validated['idRole'],
            'actif' => $validated['actif'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('index')->with('success', 'Inscription réussie!');
    }
};
?>

<div>
    <div class="text-center">
        <label class="text-3xl mt-8 font-medium text-white" for="Title">Inscription</label>
    </div>

    <div>
        <form wire:submit="register">
            <!-- Nom -->
            <div>
                <x-input-label for="nom" :value="__('Nom *')" />
                <x-text-input wire:model="nom" id="nom" class="block mt-1 w-full" type="text" name="nom" required autofocus autocomplete="nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <!-- Prénom -->
            <div>
                <x-input-label for="prenom" :value="__('Prénom *')" />
                <x-text-input wire:model="prenom" id="prenom" class="block mt-1 w-full" type="text" name="prenom" required autofocus autocomplete="prenom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email *')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Téléphone -->
            <div class="mt-4">
                <x-input-label for="telephone" :value="__('Téléphone *')" />
                <x-text-input wire:model="telephone" id="telephone" class="block mt-1 w-full" type="text" name="telephone" required autocomplete="telephone" placeholder="(123) 456-7890"/>
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe *')" />
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmer le mot de passe -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe *')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description de votre/vos fonction(s)')" />
                <textarea wire:model="description" id="description" class="block mt-1 w-full" name="description" autocomplete="description"></textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Lien -->
            <div class="mt-4">
                <x-input-label for="lien" :value="__('Lien vers votre site web')" />
                <x-text-input wire:model="lien" id="lien" class="block mt-1 w-full" type="text" name="lien" autocomplete="lien" />
                <x-input-error :messages="$errors->get('lien')" class="mt-2" />
            </div>

            <!-- Soumettre -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                    {{ __('Déjà inscrit?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
