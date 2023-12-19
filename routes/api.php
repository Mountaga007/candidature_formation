<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UtilisateurController;

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

Route::get('liste_formation', [FormationController::class, 'index']);
Route::get('liste_candidat', [UtilisateurController::class, 'liste_candidat']);
Route::post('create_candidat', [UtilisateurController::class,'store']);
Route::post('create_formation', [FormationController::class,'store']);
Route::get('existe_formation', [FormationController::class,'show']);
Route::put('modifie_formation/{formation}', [FormationController::class,'update']);
Route::delete('supprimer_formation/{formation}', [FormationController::class,'destroy']);