<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar cliente</h2>
      <a href="{{ route('admin.clientes.index') }}" class="px-3 py-2 rounded-lg border bg-white">← Volver</a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white rounded-2xl border shadow-sm p-6">
        <form method="POST" action="{{ route('admin.clientes.update', $cliente) }}" class="space-y-4">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-600">Nombre</label>
              <input name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('nombre') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Apellidos</label>
              <input name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('apellidos') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Nro. documento</label>
              <input name="nro_documento" value="{{ old('nro_documento', $cliente->nro_documento) }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('nro_documento') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Correo</label>
              <input name="correo" type="email" value="{{ old('correo', $cliente->correo) }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('correo') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Teléfono</label>
              <input name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('telefono') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
          </div>

          <button class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>