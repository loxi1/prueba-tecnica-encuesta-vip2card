<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo vehiculo</h2>
      <a href="{{ route('admin.vehiculos.index') }}" class="px-3 py-2 rounded-lg border bg-white">← Volver</a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white rounded-2xl border shadow-sm p-6">
        <form method="POST" action="{{ route('admin.vehiculos.store') }}" class="space-y-4">
          @csrf

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-gray-600">Placa</label>
              <input name="placa" value="{{ old('placa') }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('placa') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Marca</label>
              <input name="marca" value="{{ old('marca') }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('marca') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">Modelo</label>
              <input name="modelo" value="{{ old('modelo') }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('modelo') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="text-sm text-gray-600">anio_fabricacion</label>
              <input name="anio_fabricacion" type="number" value="{{ old('anio_fabricacion') }}" class="mt-1 w-full rounded-lg border-gray-300">
              @error('anio_fabricacion') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
              <select name="cliente_id" class="mt-1 w-full rounded-lg border-gray-300">
                @foreach($clientes as $c)
                  <option value="{{ $c->id }}" @selected(old('cliente_id', $vehiculo->cliente_id ?? null) == $c->id)>
                    {{ $c->apellidos }}, {{ $c->nombre }} ({{ $c->nro_documento }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <button class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>