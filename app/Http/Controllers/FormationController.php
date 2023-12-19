<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Exception;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
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
     */
    public function show(Formation $formation)
    {
        if($formation->exists()){
            return response()->json([
                'statut'=>1,
                'formation'=> $formation,
            ]);
        }else{
            return response()->json([
                'statut'=>0,
                'message'=> 'formation non trouvée',
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

