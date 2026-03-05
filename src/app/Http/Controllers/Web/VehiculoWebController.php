<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehiculoRequest;
use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoWebController extends Controller
{
  public function index(Request $request)
  {
    $q = trim((string) $request->get('q', ''));

    $vehiculos = Vehiculo::query()
      ->with('cliente')
      ->when($q !== '', function ($query) use ($q) {
        $query->where('placa', 'like', "%$q%")
          ->orWhere('marca', 'like', "%$q%")
          ->orWhere('modelo', 'like', "%$q%")
          ->orWhere('anio_fabricacion', 'like', "%$q%")
          ->orWhereHas('cliente', function ($qc) use ($q) {
            $qc->where('nombre', 'like', "%$q%")
              ->orWhere('apellidos', 'like', "%$q%")
              ->orWhere('nro_documento', 'like', "%$q%");
          });
      })
      ->latest()
      ->paginate(15)
      ->withQueryString();

    return view('admin.vehiculos.index', compact('vehiculos', 'q'));
  }

  public function create()
  {
    $clientes = Cliente::orderBy('apellidos')->orderBy('nombre')->get();
    return view('admin.vehiculos.create', compact('clientes'));
  }

  public function store(VehiculoRequest $request)
  {
    Vehiculo::create($request->validated());
    return redirect()->route('admin.vehiculos.index')->with('status', 'Vehículo creado');
  }

  public function edit(Vehiculo $vehiculo)
  {
    $clientes = Cliente::orderBy('apellidos')->orderBy('nombre')->get();
    return view('admin.vehiculos.edit', compact('vehiculo', 'clientes'));
  }

  public function update(VehiculoRequest $request, Vehiculo $vehiculo)
  {
    $vehiculo->update($request->validated());
    return redirect()->route('admin.vehiculos.index')->with('status', 'Vehículo actualizado');
  }

  public function destroy(Vehiculo $vehiculo)
  {
    $vehiculo->delete();
    return redirect()->route('admin.vehiculos.index')->with('status', 'Vehículo eliminado');
  }

  public function show(Vehiculo $vehiculo)
  {
    return redirect()->route('admin.vehiculos.edit', $vehiculo);
  }
}
