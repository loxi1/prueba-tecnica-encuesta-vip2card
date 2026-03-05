<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
  public function index()
  {
    $clientes = Cliente::orderBy('apellidos')->paginate(15);
    return view('admin.clientes.index', compact('clientes'));
  }

  public function create()
  {
    return view('admin.clientes.form', ['cliente' => new Cliente()]);
  }

  public function store(ClienteRequest $request)
  {
    Cliente::create($request->validated());
    return redirect()->route('admin.clientes.index')->with('ok', 'Cliente creado.');
  }

  public function edit(Cliente $cliente)
  {
    return view('admin.clientes.form', compact('cliente'));
  }

  public function update(ClienteRequest $request, Cliente $cliente)
  {
    $cliente->update($request->validated());
    return redirect()->route('admin.clientes.index')->with('ok', 'Cliente actualizado.');
  }

  public function destroy(Cliente $cliente)
  {
    $cliente->delete();
    return back()->with('ok', 'Cliente eliminado.');
  }
}
