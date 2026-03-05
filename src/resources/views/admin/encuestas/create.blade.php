<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800">Crear encuesta</h2>
      <a href="{{ route('admin.encuestas.index') }}" class="text-sm px-3 py-2 rounded-lg border bg-white hover:bg-gray-50">← Volver</a>
    </div>
  </x-slot>

  <div class="max-w-3xl mx-auto p-6">
    <form method="POST" action="{{ route('admin.encuestas.store') }}" class="space-y-5">
      @csrf

      <div class="bg-white border rounded-2xl p-5 shadow-sm space-y-4">
        <div>
          <label class="text-sm font-medium">Título</label>
          <input name="titulo" value="{{ old('titulo') }}"
                 class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
          @error('titulo') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-sm font-medium">Descripción</label>
          <textarea name="descripcion" rows="3"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('descripcion') }}</textarea>
          @error('descripcion') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium">Fecha inicio</label>
            <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                   class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
          </div>
          <div>
            <label class="text-sm font-medium">Fecha cierre</label>
            <input type="datetime-local" name="fecha_cierre" value="{{ old('fecha_cierre') }}"
                   class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
          </div>
        </div>

        <label class="inline-flex items-center gap-2">
          <input type="checkbox" name="publicada" value="1" {{ old('publicada') ? 'checked' : '' }}
                 class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
          <span class="text-sm">Publicar encuesta</span>
        </label>
      </div>

      <button class="w-full rounded-xl bg-gray-900 text-white py-3 font-semibold hover:opacity-90">
        Guardar encuesta
      </button>
    </form>
  </div>
</x-app-layout>