<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function liste_candidat()
    {
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'La Liste de toutes les candidats ont été bien enregistrer.',
            'liste des candidats' => User:: all()
            ]);
            } catch (Exception $e) {
            return response() -> json($e);
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $candidat = new User();
        $candidat -> nom = $request -> nom;
        $candidat -> prenom = $request -> prenom;
        $candidat -> adresse = $request -> adresse;
        $candidat -> telephone = $request -> telephone;
        $candidat -> email = $request -> email;
        $candidat -> password = $request -> password;
        //$candidat -> role = $request -> role;
       if($candidat -> save()){
        
        return response()->json([
            "message" => "candidat créer avec succéss"
        ], 200);
       } else{
        return response()->json([
            "message" => "candidat non enregistrer"
        ], 500);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        //
    }
}
