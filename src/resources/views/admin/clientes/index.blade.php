<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clientes</h2>
      <a href="{{ route('admin.clientes.create') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold">
        + Nuevo
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
      @if (session('status'))
        <div class="p-3 rounded-lg bg-green-50 text-green-800 border">{{ session('status') }}</div>
      @endif

      <form class="flex gap-2" method="GET">
        <input name="q" value="{{ $q ?? '' }}" class="w-full rounded-lg border-gray-300"
               placeholder="Buscar por nombre, doc, correo, teléfono...">
        <button class="px-4 py-2 rounded-lg border bg-white">Buscar</button>
      </form>

      <div class="bg-white rounded-2xl border shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-gray-700">
            <tr>
              <th class="px-4 py-3 text-left">Cliente</th>
              <th class="px-4 py-3 text-left">Documento</th>
              <th class="px-4 py-3 text-left">Correo</th>
              <th class="px-4 py-3 text-left">Teléfono</th>
              <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($clientes as $c)
              <tr class="border-t">
                <td class="px-4 py-3 font-medium">{{ $c->apellidos }}, {{ $c->nombre }}</td>
                <td class="px-4 py-3">{{ $c->nro_documento }}</td>
                <td class="px-4 py-3">{{ $c->correo }}</td>
                <td class="px-4 py-3">{{ $c->telefono }}</td>
                <td class="px-4 py-3 text-right space-x-2">
                  <a class="px-3 py-1 rounded-lg border bg-white text-xs" href="{{ route('admin.clientes.edit', $c) }}">Editar</a>
                  <form class="inline" method="POST" action="{{ route('admin.clientes.destroy', $c) }}" onsubmit="return confirm('¿Eliminar cliente?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 rounded-lg bg-red-600 text-white text-xs">Eliminar</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay clientes</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div>{{ $clientes->links() }}</div>
    </div>
  </div>
</x-app-layout>