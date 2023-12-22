<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="Formations",
 *     description="Endpoints pour la gestion des formations"
 * )
 */

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/liste_formation",
     *     tags={"Formations"},
     *     summary="Liste des formations",
     *     description="Récupère une liste de toutes les formations.",
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="/components/schemas/Formation")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne du serveur",
     *     )
     * )
     */

    public function index()
    {
        try {
            return response()->json([
            'code_valide' => 200,
            'message' => 'Les Formations ont été récupérés.',
            'liste des formations' => Formation:: all()
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/create_formation",
     *     tags={"Formations"},
     *     summary="Créer une nouvelle formation",
     *     description="Crée une nouvelle formation.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom_formation", type="string"),
     *             @OA\Property(property="dure_formation", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formation créée avec succès",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Formation non créer",
     *     )
     * )
     */

    public function store(Request $request)
    {
       $formation = new Formation();
       $formation-> nom_formation = $request->nom_formation;
       $formation-> dure_formation = $request->dure_formation;
       $formation-> adresse = $request->adresse;
    if($formation->save()){
        return response()->json([
            "message" => "formation créer avec succéss"
        ], 200);
       } else{
        return response()->json([
            "message" => "formation non enregistrer"
        ], 500);
       }
    }


    /**
     * Display the specified resource.
     *
     * @param  string $formation
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/exister_formation/{formation}",
     *     tags={"Formations"},
     *     summary="Afficher une formation spécifique",
     *     description="Affiche les détails d'une formation spécifique.",
     *     @OA\Parameter(
     *         name="formation",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *         @OA\JsonContent(ref="/components/schemas/Formation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formation non trouvée",
     *     )
     * )
     */

    public function show(string $formation)
    {
        
        try {
            if($formations=Formation::find($formation)){
                return response()->json([
                    'statut'=>1,
                    'formation'=> $formations,
                ]);
            }else{
                return response()->json([
                    'statut'=>0,
                    'message'=>'formation non trouvée',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'statut'=>0,
                'message'=>'formation non trouvée',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formation $formation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Formation $formation
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *     path="/api/modifie_formation/{formation}",
     *     tags={"Formations"},
     *     summary="Mettre à jour une formation",
     *     description="Met à jour les détails d'une formation spécifique.",
     *     @OA\Parameter(
     *         name="formation",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom_formation", type="string"),
     *             @OA\Property(property="dure_formation", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formation modifiée avec succès",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formation non modifiée",
     *     )
     * )
     */

    public function update(Request $request, Formation $formation)
    {
        if($formation){
            
        $request->validate([
            "nom_formation" => ['required', 'string', 'min:5', 'max:100'],
            "dure_formation" => ['required', 'string'],
            "adresse" => ['required', 'string' , 'min:5', 'max:80'],
        ]);
        
        $formation->nom_formation = $request['nom_formation'];
        $formation->dure_formation = $request['dure_formation'];
        $formation->adresse = $request['adresse'] ;
        if($formation->update()){
            return response()->json([
                'statut'=>1,
                'message'=> 'formation modifié',
            ]);
        }else{
            return response()->json([
                'statut'=>0,
                'message'=> 'formation non modifié',
            ]);
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Formation $formation
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/supprimer_formation/{formation}",
     *     tags={"Formations"},
     *     summary="Supprimer une formation",
     *     description="Supprime une formation spécifique.",
     *     @OA\Parameter(
     *         name="formation",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formation supprimée avec succès",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formation non supprimée",
     *     )
     * )
     */

    public function destroy(Formation $formation)
    {
        if($formation){
           //dd($formation);
            if($formation->delete()){
                
                    return response()->json([
                        'statut'=>1,
                        'message'=> 'Formation supprimée',
                    ]);
                }else{
                    return response()->json([
                        'statut'=>0,
                        'message'=> 'Formation non supprimée',
                    ]);
                }
        }
    }
}

