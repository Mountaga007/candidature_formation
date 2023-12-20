<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Formation_Utilisateur;
use App\Models\User;
use Illuminate\Http\Request;
use FFI\Exception;
class FormationUtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, Formation $Eformation)
    public function store(Request $request, $id)
    {
        
        $candidature = new Formation_Utilisateur();

        $user = auth()->user();
        $candidature->id_user = $user->id;
        $candidature->id_formation = $id;
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formation_Utilisateur $candidature)
    {
        if($candidature){
            
            $request->validate([
                "statut_candidature" => ['required', 'string', 'min:5', 'max:80'],
                // "id_formation" => ['required'],
                // "id_user" => ['required'],
            ]);
            $candidature->statut_candidature = $request['statut_candidature'];
            // $statuts_candidatures->id_formation = $request['id_formation'];
            // $statuts_candidatures->id_user = $request['id_user'] ;
            if($candidature->update()){
                return response()->json([
                    'statut'=>1,
                    'message'=> 'statut candidature modifié',
                ]);
            }else{
                return response()->json([
                    'statut'=>0,
                    'message'=> 'statut candidature non modifié',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation_Utilisateur $formation_Utilisateur)
    {
        //
    }
}
