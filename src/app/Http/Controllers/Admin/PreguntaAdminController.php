<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreguntaRequest;
use App\Http\Requests\PreguntaUpdateRequest;
use App\Models\Encuesta;
use App\Models\Pregunta;

class PreguntaAdminController extends Controller
{
  public function store(PreguntaRequest $req, Encuesta $encuesta)
  {
    $orden = $req->input('orden') ?? ($encuesta->preguntas()->max('orden') ?? 0) + 1;

    Pregunta::create([
      'encuesta_id'    => $encuesta->id,
      'texto_pregunta' => $req->texto_pregunta,
      'tipo_pregunta'  => $req->tipo_pregunta,
      'orden'          => $orden,
      'requerida'      => $req->boolean('requerida', true),
    ]);

    return back()->with('status', 'Pregunta agregada.');
  }

  public function update(PreguntaUpdateRequest $req, Pregunta $pregunta)
  {
    $pregunta->update([
      'texto_pregunta' => $req->texto_pregunta,
      'tipo_pregunta'  => $req->tipo_pregunta,
      'orden'          => $req->orden ?? $pregunta->orden,
      'requerida'      => $req->boolean('requerida', true),
    ]);

    return back()->with('status', 'Pregunta actualizada.');
  }

  public function destroy(Pregunta $pregunta)
  {
    $pregunta->delete();
    return back()->with('status', 'Pregunta eliminada.');
  }
}
