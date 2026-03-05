<x-guest-layout>
  <div class="max-w-3xl mx-auto p-6">
    <div class="bg-white rounded-2xl border shadow-sm p-6">
      <h1 class="text-2xl font-bold text-gray-900">{{ $encuesta->titulo }}</h1>
      @if($encuesta->descripcion)
        <p class="mt-2 text-gray-600">{{ $encuesta->descripcion }}</p>
      @endif

      @if (session('status'))
        <div class="mt-4 rounded-lg border border-green-200 bg-green-50 p-3 text-green-800">
          {{ session('status') }}
        </div>
      @endif
    </div>

    <form method="POST" action="{{ url('/encuestas/'.$encuesta->id.'/responder') }}" class="mt-6 space-y-4">
      @csrf

      <div class="bg-white rounded-2xl border shadow-sm p-6 space-y-6">
        @foreach($encuesta->preguntas as $p)
          <div>
            <div class="flex items-start justify-between gap-3">
              <label class="font-semibold text-gray-900">
                {{ $loop->iteration }}. {{ $p->texto_pregunta }}
                @if($p->requerida)
                  <span class="text-red-600">*</span>
                @endif
              </label>
              <span class="text-xs text-gray-500">{{ $p->tipo_pregunta }}</span>
            </div>

            <div class="mt-3 space-y-2">
              {{-- Tipo: unica --}}
              @if($p->tipo_pregunta === 'unica')
                @foreach($p->opciones as $o)
                  <label class="flex items-center gap-2 text-gray-800">
                    <input
                      type="radio"
                      name="respuestas[{{ $p->id }}]"
                      value="{{ $o->id }}"
                      class="h-4 w-4"
                      @checked(old('respuestas.'.$p->id) == $o->id)
                      @if($p->requerida) required @endif
                    >
                    <span>{{ $o->texto_opcion }}</span>
                  </label>
                @endforeach
              @endif

              {{-- Tipo: multiple --}}
              @if($p->tipo_pregunta === 'multiple')
                @foreach($p->opciones as $o)
                  <label class="flex items-center gap-2 text-gray-800">
                    <input
                      type="checkbox"
                      name="respuestas[{{ $p->id }}][]"
                      value="{{ $o->id }}"
                      class="h-4 w-4"
                      @checked(collect(old('respuestas.'.$p->id, []))->contains($o->id))
                    >
                    <span>{{ $o->texto_opcion }}</span>
                  </label>
                @endforeach
              @endif

              {{-- Tipo: texto --}}
              @if($p->tipo_pregunta === 'texto')
                <textarea
                  name="respuestas[{{ $p->id }}]"
                  rows="3"
                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Escribe tu respuesta..."
                  @if($p->requerida) required @endif
                >{{ old('respuestas.'.$p->id) }}</textarea>
              @endif
            </div>

            @error('respuestas.'.$p->id)
              <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
          </div>
        @endforeach
      </div>

      <div class="flex items-center justify-end gap-3">
        <a href="{{ url('/') }}" class="px-4 py-2 rounded-lg border bg-white hover:bg-gray-50">
          Cancelar
        </a>
        <button type="submit" class="px-5 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
          Enviar encuesta
        </button>
      </div>
    </form>
  </div>
</x-guest-layout>