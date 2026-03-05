<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoRequest;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
  public function index()
  {
    return Vehiculo::with('cliente')->latest()->paginate(20);
  }

  public function store(VehiculoRequest $req)
  {
    $v = Vehiculo::create($req->validated());
    return response()->json($v->load('cliente'), 201);
  }

  public function show(Vehiculo $vehiculo)
  {
    return $vehiculo->load('cliente');
  }

  public function update(VehiculoRequest $req, Vehiculo $vehiculo)
  {
    $vehiculo->update($req->validated());
    return $vehiculo->fresh('cliente');
  }

  public function destroy(Vehiculo $vehiculo)
  {
    $vehiculo->delete();
    return response()->noContent();
  }
}
