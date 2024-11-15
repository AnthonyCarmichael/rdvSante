<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\FicheCliniqueController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Agenda;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\UserController;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('index');
})->middleware('auth')->name('index');

Route::get('/agenda', function () {
    return view('agenda');
})->middleware('auth')->name('agenda');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('auth')->name('profile.destroy');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/Clients', 'index')->middleware('auth')->name('clients');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('/Paiements', 'index')->middleware('auth')->name('paiements');
});

Route::get('/Transactions', function () {
    return view('transaction/transactions');
})->middleware('auth')->name('transactions');

//Routes pour les services
Route::controller(ServiceController::class)->group(function () {
    Route::post('/service/ajouterService', 'store')->middleware('auth')->name('ajouterService');
});

Route::get('/recuPaiement/{client}/{transaction}/{clinique}/{rdv}/{service}', [PdfController::class, 'recuPaiement'])->name('pdf');

Route::get('/recuRemboursement/{client}/{transaction}/{clinique}/{rdv}/{service}', [PdfController::class, 'recuRemboursement'])->name('pdf');

Route::view('profile', 'profile')
    ->middleware(['auth'])->name('profile');

Route::view('/welcome', 'welcome');

Route::get('/facture/{client}/{clinique}/{rdv}/{service}', [PdfController::class, 'facture'])->name('facture');

Route::get('/factureTout/{rdvs}', [PdfController::class, 'factureTout'])->name('factureTout');

/*
Route::get('/profil', function () {
    return view('profil');
})->middleware('auth')->name('profil');
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('/profil/profil', function () {
    return view('profil/profil');
})->middleware('auth')->name('profil');

Route::get('/profil/services', function () {
    return view('profil/services');
})->middleware('auth')->name('services');

Route::get('/profil/professions', function () {
    return view('profil/professions');
})->middleware('auth')->name('professions');

Route::get('/clinique', function () {
    return view('clinique');
})->middleware('auth')->name('clinique');

Route::get('/dossier', function () {
    return view('dossier');
})->middleware('auth')->name('dossier');

Route::get('/dossier/{id}',[DossierController::class, 'show'])->middleware('auth')->name('dossierClient');


Route::get('/profil/disponibilites', function () {
    return view('profil/disponibilites');
})->middleware('auth')->name('disponibilites');

Route::get('/rendezVous', function () {
    return view('rendezVous');
})->name('rendezVous');

Route::get('/rendez-vous/modifier/{id}', [RdvController::class, 'modifier']);
Route::get('/rendez-vous/annuler/{id}', [RdvController::class, 'annuler']);

Route::get('/users/create', [UserController::class, 'create'])->middleware(CheckRole::class)->name('users.create');
Route::post('/users', [UserController::class, 'sendInvitation'])->name('sendInvitation');

Route::get('/message', [UserController::class, 'message'])->name('message');
Route::post('/messagePersonalise', [UserController::class, 'updateMessage'])->name('updateMessage');

Route::get('/registration', [UserController::class, 'showRegistrationForm'])->name('invitation.showRegistrationForm');
Route::post('/registration/complete', [UserController::class, 'completeRegistration'])->name('completeRegistration');


Route::get('/dossier/ficheClinique/{id}',[FicheCliniqueController::class, 'create'])->middleware('auth')->name('ficheClinique');


require __DIR__.'/auth.php';
