<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponderEncuestaRequest;
use App\Models\Encuesta;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EncuestaPublicController extends Controller
{
  /**
   * Devuelve la encuesta en formato JSON (API pública).
   */
  public function show(Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      return response()->json(['message' => 'Encuesta no disponible'], 404);
    }

    $encuesta->load([
      'preguntas' => function ($q) {
        $q->orderBy('orden')
          ->with(['opciones' => fn($qq) => $qq->orderBy('orden')]);
      }
    ]);

    return $encuesta;
  }

  /**
   * Inicializa la participación: devuelve un UUID de envío.
   */
  public function iniciar(Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      return response()->json(['message' => 'Encuesta no disponible'], 404);
    }

    return ['envio_uuid' => (string) Str::uuid()];
  }

  /**
   * Recibe y guarda las respuestas vía API.
   */
  public function responder(ResponderEncuestaRequest $req, Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      return response()->json(['message' => 'Encuesta no disponible'], 404);
    }

    $data = $req->validated();

    foreach ($data['respuestas'] as $r) {
      Respuesta::create([
        'envio_uuid'      => $data['envio_uuid'],
        'encuesta_id'     => $encuesta->id,
        'pregunta_id'     => $r['pregunta_id'],
        'opcion_id'       => $r['opcion_id'] ?? null,
        'respuesta_texto' => $r['respuesta'] ?? null,
        'meta'            => $data['meta'] ?? null,
      ]);
    }

    return response()->json(['ok' => true], 201);
  }

  /**
   * Muestra el formulario Blade (público).
   */
  public function viewForm(Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      abort(404, 'Encuesta no disponible');
    }

    $encuesta->load(['preguntas.opciones' => fn($q) => $q->orderBy('orden')]);

    return view('encuestas.form', compact('encuesta'));
  }

  /**
   * Procesa respuestas del formulario Blade.
   */
  public function submitForm(Request $request, Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      abort(404, 'Encuesta no disponible');
    }

    $data = $request->validate([
      'respuestas'   => ['required', 'array'],
      'respuestas.*' => ['nullable'], // cada respuesta puede ser string o array
    ]);

    $uuid = (string) Str::uuid();

    foreach ($encuesta->preguntas as $pregunta) {
      $valor = $data['respuestas'][$pregunta->id] ?? null;

      if (is_array($valor)) {
        foreach ($valor as $opcionId) {
          Respuesta::create([
            'envio_uuid'  => $uuid,
            'encuesta_id' => $encuesta->id,
            'pregunta_id' => $pregunta->id,
            'opcion_id'   => $opcionId,
          ]);
        }
      } elseif ($valor) {
        Respuesta::create([
          'envio_uuid'      => $uuid,
          'encuesta_id'     => $encuesta->id,
          'pregunta_id'     => $pregunta->id,
          'respuesta_texto' => $valor,
        ]);
      }
    }

    return redirect()
      ->route('encuestas.form', $encuesta)
      ->with('status', '¡Gracias por participar! Tu respuesta se registró.');
  }
}
