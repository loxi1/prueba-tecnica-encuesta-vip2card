<?php

namespace App\Http\Controllers;

use App\Http\Requests\EncuestaRequest;
use App\Http\Requests\PreguntaRequest;
use App\Models\Encuesta;
use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncuestaAdminController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return $this->indexAdmin();
  }

  public function indexAdmin()
  {
    // total_respuestas = filas en respuestas
    // total_envios = conteo de envio_uuid distintos
    $encuestas = Encuesta::query()
      ->withCount([
        'respuestas as total_respuestas',
        // subconsulta para conteo de envíos únicos
        'respuestas as total_envios' => function ($q) {
          $q->select(\Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT envio_uuid)'));
        },
        // cuántas preguntas activas tiene
        'preguntas as total_preguntas'
      ])
      ->latest()
      ->paginate(15);

    return view('admin.encuestas.index', compact('encuestas'));
  }

  public function showAdmin(Encuesta $encuesta)
  {
    // Métricas por encuesta
    $totales = Respuesta::query()
      ->selectRaw('COUNT(*) as respuestas, COUNT(DISTINCT envio_uuid) as envios')
      ->where('encuesta_id', $encuesta->id)
      ->first();

    // Últimos envíos (agrupados por envio_uuid)
    $ultimosEnvios = Respuesta::query()
      ->select('envio_uuid', \Illuminate\Support\Facades\DB::raw('MIN(created_at) as fecha'))
      ->where('encuesta_id', $encuesta->id)
      ->groupBy('envio_uuid')
      ->orderByDesc('fecha')
      ->limit(25)
      ->get();

    // Preguntas con opciones (para referencia)
    $encuesta->load(['preguntas' => function ($q) {
      $q->orderBy('orden')->with(['opciones' => fn($qq) => $qq->orderBy('orden')]);
    }]);

    $stats = DB::table('respuestas as r')
      ->join('preguntas as p', 'p.id', '=', 'r.pregunta_id')
      ->leftJoin('opciones as o', 'o.id', '=', 'r.opcion_id')
      ->where('r.encuesta_id', $encuesta->id)
      ->selectRaw('p.id as pregunta_id, p.texto_pregunta, o.texto_opcion, COUNT(*) as total')
      ->groupBy('p.id', 'p.texto_pregunta', 'o.texto_opcion')
      ->orderBy('p.id')
      ->get()
      ->groupBy('pregunta_id');

    return view('admin.encuestas.show', [
      'encuesta' => $encuesta,
      'totales' => $totales,
      'ultimosEnvios' => $ultimosEnvios,
      'stats' => $stats,
    ]);
  }

  public function viewForm(Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      abort(404, 'Encuesta no disponible');
    }

    $encuesta->load(['preguntas.opciones' => fn($q) => $q->orderBy('orden')]);
    return view('encuestas.form', compact('encuesta'));
  }

  public function submitForm(Request $request, Encuesta $encuesta)
  {
    if (!$encuesta->publicada) {
      abort(404, 'Encuesta no disponible');
    }

    $data = $request->validate([
      'respuestas'   => ['required', 'array'],
      'respuestas.*' => ['nullable'], // cada respuesta puede ser string o array
    ]);

    $uuid = (string) \Illuminate\Support\Str::uuid();

    foreach ($encuesta->preguntas as $pregunta) {
      $valor = $data['respuestas'][$pregunta->id] ?? null;

      if (is_array($valor)) {
        foreach ($valor as $opcionId) {
          Respuesta::create([
            'envio_uuid' => $uuid,
            'encuesta_id' => $encuesta->id,
            'pregunta_id' => $pregunta->id,
            'opcion_id' => $opcionId,
          ]);
        }
      } elseif ($valor) {
        Respuesta::create([
          'envio_uuid' => $uuid,
          'encuesta_id' => $encuesta->id,
          'pregunta_id' => $pregunta->id,
          'respuesta_texto' => $valor,
        ]);
      }
    }

    return redirect()->route('encuestas.form', $encuesta)
      ->with('status', '¡Gracias por participar! Tu respuesta se registró.');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(EncuestaRequest $req)
  {
    return DB::transaction(function () use ($req) {
      $encuesta = Encuesta::create($req->safe()->only(['titulo', 'descripcion', 'fecha_inicio', 'fecha_cierre', 'publicada']));
      foreach ($req->input('preguntas', []) as $p) {
        $preg = Pregunta::create([
          'encuesta_id'    => $encuesta->id,
          'texto_pregunta' => $p['texto_pregunta'],
          'tipo_pregunta'  => $p['tipo_pregunta'],
          'orden'          => $p['orden'] ?? 0,
          'requerida'      => $p['requerida'] ?? true,
        ]);
        foreach ($p['opciones'] ?? [] as $o) {
          Opcion::create([
            'pregunta_id' => $preg->id,
            'texto_opcion' => $o['texto_opcion'],
            'orden'       => $o['orden'] ?? 0,
          ]);
        }
      }
      return response()->json($encuesta->load('preguntas.opciones'), 201);
    });
  }

  /**
   * Display the specified resource.
   */
  public function show(Encuesta $encuesta)
  {
    return $this->showAdmin($encuesta);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(EncuestaRequest $req, Encuesta $encuesta)
  {
    $encuesta->update($req->safe()->only(['titulo', 'descripcion', 'fecha_inicio', 'fecha_cierre', 'publicada']));
    return $encuesta->fresh('preguntas.opciones');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Encuesta $encuesta)
  {
    $encuesta->delete();
    return response()->noContent();
  }

  // Crear una pregunta suelta en una encuesta existente
  public function agregarPregunta(PreguntaRequest $req, Encuesta $encuesta)
  {
    $preg = Pregunta::create([
      'encuesta_id'    => $encuesta->id,
      'texto_pregunta' => $req->texto_pregunta,
      'tipo_pregunta'  => $req->tipo_pregunta,
      'orden'          => $req->orden ?? 0,
      'requerida'      => $req->boolean('requerida', true),
    ]);
    foreach ($req->input('opciones', []) as $o) {
      Opcion::create([
        'pregunta_id' => $preg->id,
        'texto_opcion' => $o['texto_opcion'],
        'orden'       => $o['orden'] ?? 0,
      ]);
    }
    return response()->json($preg->load('opciones'), 201);
  }

  public function create()
  {
    return view('admin.encuestas.create');
  }

  public function storeWeb(\App\Http\Requests\EncuestaRequest $req)
  {
    $encuesta = Encuesta::create([
      'titulo' => $req->titulo,
      'descripcion' => $req->descripcion,
      'fecha_inicio' => $req->fecha_inicio,
      'fecha_cierre' => $req->fecha_cierre,
      'publicada' => $req->boolean('publicada'),
    ]);

    return redirect()->route('admin.encuestas.show', $encuesta)
      ->with('status', 'Encuesta creada.');
  }

  public function edit(Encuesta $encuesta)
  {
    return view('admin.encuestas.edit', compact('encuesta'));
  }

  public function updateWeb(\App\Http\Requests\EncuestaUpdateRequest $req, Encuesta $encuesta)
  {
    $encuesta->update([
      'titulo' => $req->titulo,
      'descripcion' => $req->descripcion,
      'fecha_inicio' => $req->fecha_inicio,
      'fecha_cierre' => $req->fecha_cierre,
      'publicada' => $req->boolean('publicada'),
    ]);

    return redirect()->route('admin.encuestas.show', $encuesta)
      ->with('status', 'Encuesta actualizada.');
  }

  public function destroyWeb(Encuesta $encuesta)
  {
    $encuesta->delete();
    return redirect()->route('admin.encuestas.index')->with('status', 'Encuesta eliminada.');
  }
}
