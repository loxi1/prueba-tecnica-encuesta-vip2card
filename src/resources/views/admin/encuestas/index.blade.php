<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl leading-tight">Encuestas (Admin)</h2>

      <a href="{{ route('admin.encuestas.create') }}"
        class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:opacity-90">
        + Nueva encuesta
      </a>
    </div>
  </x-slot>

  <div class="overflow-x-auto bg-white rounded-2xl border shadow-sm">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-4 py-3 text-left">Título</th>
          <th class="px-4 py-3 text-left">Estado</th>
          <th class="px-4 py-3 text-right">Preguntas</th>
          <th class="px-4 py-3 text-right">Envíos</th>
          <th class="px-4 py-3 text-right">Respuestas</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($encuestas as $e)
          <tr class="border-t">
            <td class="px-4 py-3 font-medium">{{ $e->titulo }}</td>
            <td class="px-4 py-3">
              @if($e->publicada)
                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Publicada</span>
              @else
                <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">Borrador</span>
              @endif
            </td>
            <td class="px-4 py-3 text-right">{{ $e->total_preguntas }}</td>
            <td class="px-4 py-3 text-right">{{ $e->total_envios }}</td>
            <td class="px-4 py-3 text-right">{{ $e->total_respuestas }}</td>
            <td class="px-4 py-3 text-right">
              <a href="{{ route('admin.encuestas.show', $e) }}"
                 class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded bg-gray-900 text-white hover:opacity-90">
                Ver
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay encuestas</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $encuestas->links() }}
  </div>
</x-app-layout>