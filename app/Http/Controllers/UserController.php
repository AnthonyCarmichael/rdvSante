<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\InvitationMailable;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function sendInvitation(Request $request)
    {
        $validatedData = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Créez un token unique pour l'invitation
        $invitationToken = Str::random(32);

        // Enregistrez temporairement les données de l'utilisateur et le token dans le cache
        Cache::put('invitation_' . $invitationToken, [
            'prenom' => $validatedData['prenom'],
            'nom' => $validatedData['nom'],
            'email' => $validatedData['email'],
        ], now()->addDays(3)); // Expire après 3 jours

        // Générez l'URL d'invitation
        $invitationLink = url('register?token=' . $invitationToken);

        // Envoyez l'e-mail avec le lien d'invitation
        Mail::to($validatedData['email'])->send(new InvitationMailable($invitationLink));

        session()->flash('status', 'Invitation envoyée avec succès');

        return back();
    }
}
