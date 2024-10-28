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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
        ]);

        // Enregistrez l’utilisateur
        $user = User::create($validatedData);

        // Générer un lien signé avec une expiration de 72 heures (3 jours)
        $url = URL::temporarySignedRoute('invitation.register', now()->addDays(3), ['user' => $user->id]);

        // Envoyer l'email d'invitation
        Mail::to($user->email)->send(new InvitationMailable($url));

        return redirect()->route('users.create')->with('success', 'Invitation envoyée avec succès.');
    }

    public function register(Request $request)
    {
        // Vérification de la signature et de la validité du lien
        if (!$request->hasValidSignature()) {
            abort(403, 'Lien d\'invitation expiré ou non valide.');
        }

        $email = $request->query('email');

        // Vérifie que l'e-mail n'est pas déjà utilisé
        if (User::where('email', $email)->exists()) {
            abort(403, 'Cet utilisateur est déjà enregistré.');
        }

        // Affiche le formulaire d'inscription avec l'email en tant que champ caché
        return view('users.completeRegistration', compact('email'));
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
        $invitationLink = url('/register?token=' . $invitationToken);

        // Envoyez l'e-mail avec le lien d'invitation
        Mail::to($validatedData['email'])->send(new \App\Mail\InvitationMailable($invitationLink));

        return back()->with('success', 'Invitation envoyée avec succès.');
    }

    public function showRegistrationForm(Request $request)
    {
        $token = $request->query('token');

        // Récupérez les informations de l'invitation via le cache
        $userData = Cache::get('invitation_' . $token);

        if (!$userData) {
            abort(403, 'Lien d\'invitation invalide ou expiré.');
        }

        return view('users.completeRegistration', ['userData' => $userData]);
    }


    public function completeRegistration(Request $request)
    {
        $validatedData = $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'required|string',
            'idRole' => 'required|integer',
            'description' => 'nullable|string',
            'lien' => 'nullable|string',
        ]);

        // Récupérer les informations d'invitation depuis le cache
        $userData = Cache::pull('invitation_' . $validatedData['token']);

        if (!$userData) {
            abort(403, 'Lien d\'invitation invalide ou expiré.');
        }

        // Enregistrement du nouvel utilisateur dans la base de données
        $user = User::create([
            'prenom' => $userData['prenom'],
            'nom' => $userData['nom'],
            'email' => $userData['email'],
            'password' => bcrypt($validatedData['password']),
            'telephone' => $validatedData['telephone'],
            'idRole' => $validatedData['idRole'],
            'description' => $validatedData['description'] ?? null,
            'actif' => true, // Activer l'utilisateur par défaut
            'lien' => $validatedData['lien'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie!');
    }


}
