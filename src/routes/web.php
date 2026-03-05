<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EncuestaPublicController;
use App\Http\Controllers\Web\ClienteWebController;
use App\Http\Controllers\Web\VehiculoWebController;
use App\Http\Controllers\EncuestaAdminController;
use App\Http\Controllers\Admin\PreguntaAdminController;
use App\Http\Controllers\Admin\OpcionAdminController;
/*
|--------------------------------------------------------------------------
| Público
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

// Público (anónimo)
Route::get('/encuestas/{encuesta}', [EncuestaPublicController::class, 'show']);
Route::post('/encuestas/{encuesta}/iniciar', [EncuestaPublicController::class, 'iniciar']);
Route::post('/encuestas/{encuesta}/responder', [EncuestaPublicController::class, 'responder']);
Route::get('/encuestas/{encuesta}/form', [EncuestaPublicController::class, 'viewForm'])->name('encuestas.form');
Route::post('/encuestas/{encuesta}/form', [EncuestaPublicController::class, 'submitForm'])->name('encuestas.submit');


/*
|--------------------------------------------------------------------------
| Dashboard / Perfil (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => view('dashboard'))
  ->middleware(['auth', 'verified'])
  ->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin protegido
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->group(function () {
  Route::get('/', fn() => redirect()->route('admin.clientes.index'))->name('admin.home');

  Route::resource('clientes',  ClienteWebController::class)->names('admin.clientes');
  Route::resource('vehiculos', VehiculoWebController::class)->names('admin.vehiculos');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

  Route::get('/encuestas', [EncuestaAdminController::class, 'indexAdmin'])->name('encuestas.index');
  Route::get('/encuestas/create', [EncuestaAdminController::class, 'create'])->name('encuestas.create');
  Route::post('/encuestas', [EncuestaAdminController::class, 'storeWeb'])->name('encuestas.store');

  Route::get('/encuestas/{encuesta}', [EncuestaAdminController::class, 'showAdmin'])->name('encuestas.show');
  Route::get('/encuestas/{encuesta}/edit', [EncuestaAdminController::class, 'edit'])->name('encuestas.edit');
  Route::put('/encuestas/{encuesta}', [EncuestaAdminController::class, 'updateWeb'])->name('encuestas.update');
  Route::delete('/encuestas/{encuesta}', [EncuestaAdminController::class, 'destroyWeb'])->name('encuestas.destroy');

  // Preguntas
  Route::post('/encuestas/{encuesta}/preguntas', [PreguntaAdminController::class, 'store'])->name('preguntas.store');
  Route::put('/preguntas/{pregunta}', [PreguntaAdminController::class, 'update'])->name('preguntas.update');
  Route::delete('/preguntas/{pregunta}', [PreguntaAdminController::class, 'destroy'])->name('preguntas.destroy');

  // Opciones
  Route::post('/preguntas/{pregunta}/opciones', [OpcionAdminController::class, 'store'])->name('opciones.store');
  Route::put('/opciones/{opcion}', [OpcionAdminController::class, 'update'])->name('opciones.update');
  Route::delete('/opciones/{opcion}', [OpcionAdminController::class, 'destroy'])->name('opciones.destroy');
});

require __DIR__ . '/auth.php';
