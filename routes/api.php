<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientApiController;
use App\Http\Controllers\DossierApiController;
use App\Http\Controllers\MetaDataApiController;
use App\Http\Controllers\TypeDossierApiController;
use App\Http\Controllers\TypeFichierApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/MetaData/download/{id}', [MetaDataApiController::class, 'download']);
Route::post('/MetaData/delete', [MetaDataApiController::class, 'destroy']);
Route::post('/MetaData', [MetaDataApiController::class, 'store']);
Route::get('/MetaData/{id_dossier}', [MetaDataApiController::class, 'getMetaData']);

Route::put('/client/edit/{id}',[ClientApiController::class,'update']);
Route::post('/client/create',[ClientApiController::class,'store']);
Route::get('/clients/emails', [ClientApiController::class, 'getEmails']);
Route::get('/clients/{id}', [ClientApiController::class ,'showEmail']);
Route::get('/clients', [ClientApiController::class, 'index']);

Route::get('/dossiers/delete/{id}', [DossierApiController::class ,'destroy']);
Route::get('/dossiertypefichier/{id}', [DossierApiController::class, 'getTypeFichier']);
Route::get('/typeFichierMetaData/{id}', [DossierApiController::class, 'getTypeFichierMetaData']);
Route::get('/dossiers/{id}', [DossierApiController::class ,'show']);
Route::put('/dossier/edit/{id}', [DossierApiController::class, 'update']);
Route::post('/dossier/create', [DossierApiController::class, 'store']);
Route::get('/dossiers', [DossierApiController::class, 'index'])->name('apidossiers.index');


Route::get('/typedossiers/noms', [TypeDossierApiController::class, 'getNoms']);
Route::get('/typedossiers/{id}', [TypeDossierApiController::class, 'showNom']);
Route::put('/typedossier/edit/{id}', [TypeDossierApiController::class, 'update']);
Route::post('/typedossier/create', [TypeDossierApiController::class, 'store']);
Route::get('/typedossiers', [TypeDossierApiController::class, 'index']);

Route::put('/typefichier/edit/{id}', [TypeFichierApiController::class, 'update']);
Route::post('/typefichier/create', [TypeFichierApiController::class, 'store']);
Route::get('/typefichiers', [TypeFichierApiController::class, 'index']);






