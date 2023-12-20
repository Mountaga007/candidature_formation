<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\FormationUtilisateurController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class ,'me']);

});

    //connexion
    Route::middleware('auth:api', 'MiddlewareAdmin')->group(function(){
     Route::post('create_formation', [FormationController::class,'store']);
     Route::get('existe_formation', [FormationController::class,'show']);
     Route::put('modifie_formation/{formation}', [FormationController::class,'update']);
     Route::delete('supprimer_formation/{formation}', [FormationController::class,'destroy']);
     Route::get('liste_cabdidature', [FormationUtilisateurController::class, 'index']);
     Route::get('statut_candidature', [FormationUtilisateurController::class, 'update']);
     Route::get('liste_candidat', [UtilisateurController::class, 'liste_candidat']);
     Route::get('modifi_statut_candidature/{candidature}', [FormationUtilisateurController::class, 'update']);
        
 });

 Route::middleware('auth:api', 'MiddlewareUser_candidat')->group(function(){
        Route::post('create_candidat', [UtilisateurController::class,'store']);
        Route::post('enregistrer_candidature/{id}', [FormationUtilisateurController::class, 'store']);
        Route::get('liste_candidat_refus', [FormationUtilisateurController::class, 'refuser']);
        Route::get('liste_candidat_accept', [FormationUtilisateurController::class, 'accepter']);
 });

 Route::get('liste_formation', [FormationController::class, 'index']);
 Route::get('exister_formation/{formation}', [FormationController::class,'show']);