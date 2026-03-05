<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpcionRequest;
use App\Models\Opcion;
use App\Models\Pregunta;

class OpcionAdminController extends Controller
{
  public function store(OpcionRequest $req, Pregunta $pregunta)
  {
    $orden = $req->input('orden') ?? ($pregunta->opciones()->max('orden') ?? 0) + 1;

    Opcion::create([
      'pregunta_id'   => $pregunta->id,
      'texto_opcion'  => $req->texto_opcion,
      'orden'         => $orden,
    ]);

    return back()->with('status', 'Opción agregada.');
  }

  public function update(OpcionRequest $req, Opcion $opcion)
  {
    $opcion->update([
      'texto_opcion' => $req->texto_opcion,
      'orden'        => $req->orden ?? $opcion->orden,
    ]);

    return back()->with('status', 'Opción actualizada.');
  }

  public function destroy(Opcion $opcion)
  {
    $opcion->delete();
    return back()->with('status', 'Opción eliminada.');
  }
}
