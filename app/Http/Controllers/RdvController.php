<?php

namespace App\Http\Controllers;

use App\Models\Rdv;
use Illuminate\Http\Request;

class RdvController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function modifier($id, Request $request)
    {
        $rdv = Rdv::where('id', $id)->where('token', $request->token)->firstOrFail();

        return view('rendez-vous.modifier', ['oldRdv' => $rdv]);
    }

    public function annuler($id, Request $request)
    {
        $rdv = Rdv::where('id', $id)->where('token', $request->token)->firstOrFail();

        #$rdv->update(['status' => 'annulé']);

        return view('rendez-vous.annuler', ['rdv' => $rdv]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Rdv $rdv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rdv $rdv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rdv $rdv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rdv $rdv)
    {
        //
    }
}
