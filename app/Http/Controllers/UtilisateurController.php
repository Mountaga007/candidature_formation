<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

use OpenApi\Annotations as OA;

class UtilisateurController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/liste_candidat",
     *     summary="Obtenir la liste de tous les candidats",
     *     tags={"Candidats"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="code_valide", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="La liste des candidats a été bien enregistrée."),
     *             @OA\Property(property="liste des candidats", type="array", @OA\Items(ref="#/components/schemas/User"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="La liste des candidats est indisponible",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
     */
    public function liste_candidat()
    {
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'La Liste de toutes les candidats ont été bien enregistrer.',
            'liste des candidats' => User:: all() -> where('role', 'candidat')
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
     * @OA\Post(
     *     path="/api/create_candidat",
     *     summary="Enregistrer un nouveau candidat",
     *     tags={"Candidats"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du candidat à enregistrer",
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="telephone", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Candidat enregistré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Candidat enregistré avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Candidat non enregistré",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
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
