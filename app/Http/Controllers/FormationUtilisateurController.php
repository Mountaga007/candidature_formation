<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Formation_Utilisateur;
use App\Models\User;
use Illuminate\Http\Request;
use FFI\Exception;

use OpenApi\Annotations as OA;
class FormationUtilisateurController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/liste_candidature",
     *     summary="Obtenir la liste de toutes les candidatures",
     *     tags={"Candidatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="code_valide", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="La liste des candidatures a été bien récupérée."),
     *             @OA\Property(property="liste des candidatures", type="array", @OA\Items(ref="#/components/schemas/FormationUtilisateur"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="La liste des candidatures est indisponible",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des candidatures a été bien récupéré.',
            'liste des candidatures' => Formation_Utilisateur::with('Formation', 'User:id,nom,prenom,email')->get()
            ]);
            } catch (Exception $e) {
            return response() -> json($e);
            }
    }


    /**
     * @OA\Get(
     *     path="/api/liste_candidat_refus",
     *     summary="Obtenir la liste des candidatures refusées",
     *     tags={"Candidatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="code_valide", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="La liste des candidatures refusées a été bien récupérée."),
     *             @OA\Property(property="liste des candidatures refusées", type="array", @OA\Items(ref="#/components/schemas/FormationUtilisateur"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="la liste des candidatures refusées est indisponible",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
     */

    //liste des candidatures refusé
    public function refuser(){
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des candidatures refuser ont été bien récupéré.',
            'liste des candidatures refusés' => Formation_Utilisateur::with('Formation', 'User:id,nom,prenom,email')->where('statut_candidature', 'Refuser')->get()
            ]);
            } catch (Exception $e) {
            return response() -> json($e);
            }
    }


    /**
     * @OA\Get(
     *     path="/api/liste_candidat_accept",
     *     summary="Obtenir la liste des candidatures acceptées",
     *     tags={"Candidatures"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="code_valide", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="La liste des candidatures acceptées a été bien récupérée."),
     *             @OA\Property(property="liste des candidatures acceptées", type="array", @OA\Items(ref="#/components/schemas/FormationUtilisateur"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="la liste des candidatures acceptées est indisponible",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
     */

    //liste des candidatures accepter

    public function accepter(){
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'La liste des candidatures accepter ont été bien récupéré.',
            'liste des candidatures acceptés' => Formation_Utilisateur::with('formation', 'user:id,nom,prenom,email')->where('statut_candidature', 'Accepter')->get()
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
        //
    }

    /**
     * @OA\Post(
     *     path="/api/enregistrer_candidature/{id}",
     *     summary="Enregistrer une nouvelle candidature",
     *     tags={"Candidatures"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Informations de la candidature",
     *         @OA\JsonContent(
     *             required={"id_formation"},
     *             @OA\Property(property="id_formation", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Candidature enregistré avec Succè",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Candidature enregistrée avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="échec de la candidature",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Erreur interne du serveur")
     *         )
     *     )
     * )
     */
    public function store(Request $request, $id)
    {
        
        $candidature = new Formation_Utilisateur();

        $user = auth()->user();
        $candidature->id_user = $user->id;
        $candidature->id_formation = $request->id_formation;
        if($candidature->save()){
            return response()->json([
                "message" => "candidature enregistrer avec succéss"
            ], 200);
           } else{
            return response()->json([
                "message" => "candidature non enregistrer"
            ], 500);
           }
    }

    /**
     * Display the specified resource.
     */
    public function show(Formation_Utilisateur $formation_Utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formation_Utilisateur $formation_Utilisateur)
    {
        //
    }

    
       /**
 * @OA\Post(
 *     path="/api/accepter_candidature/{id}",
 *     summary="Accepter une candidature",
 *     description="Accepte la candidature associée à l'ID spécifié.",
 *     tags={"Candidatures"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la candidature",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="statut_candidature",
 *                     type="string",
 *                     example="Accepter",
 *                     description="Nouveau statut de la candidature (Accepter)"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Candidature acceptée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Candidature acceptée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Candidature non trouvée",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Candidature non trouvée")
 *         )
 *     )
 * )
 */



    public function candidature_accepter(Request $request, $id)
    {
        
        $candidature = Formation_Utilisateur::findOrFail($id);
        $candidature->update(['statut_candidature' => 'Accepter']);

        return response(['message' => 'Candidature accepter avec succès'], 200);
    }



 /**
 * @OA\Post(
 *     path="/api/candidature/{id}/refuser",
 *     summary="Refuser une candidature",
 *     description="Refuse la candidature associée à l'ID spécifié.",
 *     tags={"Candidatures"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la candidature",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="statut_candidature",
 *                     type="string",
 *                     example="Refuser",
 *                     description="Nouveau statut de la candidature (Refuser)"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Candidature refusée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Candidature refusée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Candidature non trouvée",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Candidature non trouvée")
 *         )
 *     )
 * )
 */


    public function candidature_refuser(Request $request, $id)
    {
        
        $candidature = Formation_Utilisateur::findOrFail($id);
        $candidature->update(['statut_candidature' => 'Refuser']);

        return response(['message' => 'Candidature refusée avec succès'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation_Utilisateur $formation_Utilisateur)
    {
        //
    }
}
