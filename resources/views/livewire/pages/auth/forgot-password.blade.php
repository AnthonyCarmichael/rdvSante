<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ], [
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', 'Aucun utilisateur n\'est associé à cette adresse e-mail.');

            return;
        }

        $this->reset('email');

        session()->flash('status', 'Le lien de réinitialisation vous a été envoyé');
    }
}; ?>

<div>
    <div class="text-center mb-2">
        <label class="text-3xl mt-8 font-medium text-white" for="Title">Mot de passe oublié?</label>
    </div>

    <div>
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Aucun problème. Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Envoyer') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
