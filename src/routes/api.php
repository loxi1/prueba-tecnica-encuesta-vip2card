<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  ClienteController,
  VehiculoController,
  EncuestaPublicController,
  EncuestaAdminController
};

/*
|--------------------------------------------------------------------------
| Rutas API públicas (anónimas)
|--------------------------------------------------------------------------
*/

Route::get('/encuestas/{encuesta}', [EncuestaPublicController::class, 'show']);          // JSON de encuesta publicada
Route::post('/encuestas/{encuesta}/iniciar', [EncuestaPublicController::class, 'iniciar']); // devuelve envio_uuid
Route::post('/encuestas/{encuesta}/responder', [EncuestaPublicController::class, 'responder']);

/*
|--------------------------------------------------------------------------
| Rutas API administrativas (proteger luego con auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
  Route::apiResource('clientes', ClienteController::class);
  Route::apiResource('vehiculos', VehiculoController::class);
  Route::apiResource('encuestas', EncuestaAdminController::class);
  Route::post('/encuestas/{encuesta}/preguntas', [EncuestaAdminController::class, 'agregarPregunta']);
});
