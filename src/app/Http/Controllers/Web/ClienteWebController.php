<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteWebController extends Controller
{
  public function index(Request $request)
  {
    $q = trim((string) $request->get('q', ''));

    $clientes = Cliente::query()
      ->when($q !== '', function ($query) use ($q) {
        $query->where('nombre', 'like', "%$q%")
          ->orWhere('apellidos', 'like', "%$q%")
          ->orWhere('nro_documento', 'like', "%$q%")
          ->orWhere('correo', 'like', "%$q%")
          ->orWhere('telefono', 'like', "%$q%");
      })
      ->latest()
      ->paginate(15)
      ->withQueryString();

    return view('admin.clientes.index', compact('clientes', 'q'));
  }

  public function create()
  {
    return view('admin.clientes.create');
  }

  public function store(ClienteRequest $request)
  {
    Cliente::create($request->validated());
    return redirect()->route('admin.clientes.index')->with('status', 'Cliente creado');
  }

  public function edit(Cliente $cliente)
  {
    return view('admin.clientes.edit', compact('cliente'));
  }

  public function update(ClienteRequest $request, Cliente $cliente)
  {
    $cliente->update($request->validated());
    return redirect()->route('admin.clientes.index')->with('status', 'Cliente actualizado');
  }

  public function destroy(Cliente $cliente)
  {
    $cliente->delete();
    return redirect()->route('admin.clientes.index')->with('status', 'Cliente eliminado');
  }

  public function show(Cliente $cliente)
  {
    return redirect()->route('admin.clientes.edit', $cliente);
  }
}
