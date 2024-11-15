<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\FicheClinique;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FicheCliniqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id, Request $request)
    {
        $dossierClient = Dossier::where('id', $id)->first();


        if ( $dossierClient != null ) {


            foreach ($dossierClient->professionnels as $professionnel) {

                if($professionnel->id == Auth::user()->id) {
                    return view('dossier/ficheClinique',  ['dossierClient' => $dossierClient]);
                }
            }


        }

        abort(404);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($ficheCliniqueId)
    {
        $ficheSelected = FicheClinique::find($ficheCliniqueId);

        #dd($fiche->dossier->client->prenom);


        // revoir la suite

        $dossierClient = Dossier::find($ficheSelected->dossier->id);


        if ( $dossierClient != null ) {


            foreach ($dossierClient->professionnels as $professionnel) {

                if($professionnel->id == Auth::user()->id) {
                    return view('dossier/ficheClinique',  ['dossierClient' => $dossierClient, 'ficheSelected' => $ficheSelected]);
                }
            }


        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FicheClinique $ficheClinique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FicheClinique $ficheClinique)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FicheClinique $ficheClinique)
    {
        //
    }
}
