<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use Illuminate\Http\Request;


class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $groupes = Groupe::all();
           return view('groupes.index', compact('groupes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('groupes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $groupe = Groupe::create($request->all());

    

    return redirect()->route('groupes.index')->with('success', 'Groupe créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groupe $groupe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        //
    }
}
