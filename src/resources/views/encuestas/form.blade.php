<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $encuesta->titulo }} • {{ config('app.name', 'VIP2CARS') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
  @include('layouts.navigation')

  <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white border rounded-3xl shadow-sm p-6">
      <h1 class="text-2xl font-bold">{{ $encuesta->titulo }}</h1>
      @if($encuesta->descripcion)
        <p class="mt-2 text-gray-600">{{ $encuesta->descripcion }}</p>
      @endif

      @if(session('status'))
        <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('encuestas.submit', $encuesta) }}" class="mt-6 space-y-6">
        @csrf

        @foreach($encuesta->preguntas as $pregunta)
          <div class="rounded-2xl border p-4">
            <div class="font-semibold">
              {{ $pregunta->texto_pregunta }}
              @if($pregunta->requerida) <span class="text-red-600">*</span> @endif
            </div>

            <div class="mt-3">
              @if($pregunta->tipo_pregunta === 'texto')
                <textarea name="respuestas[{{ $pregunta->id }}]" rows="3"
                  class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"></textarea>

              @elseif($pregunta->tipo_pregunta === 'unica')
                <div class="space-y-2">
                  @foreach($pregunta->opciones as $op)
                    <label class="flex items-center gap-2">
                      <input type="radio" name="respuestas[{{ $pregunta->id }}]" value="{{ $op->id }}"
                        class="text-gray-900 focus:ring-gray-900">
                      <span>{{ $op->texto_opcion }}</span>
                    </label>
                  @endforeach
                </div>

              @elseif($pregunta->tipo_pregunta === 'opcion_multiple')
                <div class="space-y-2">
                  @foreach($pregunta->opciones as $op)
                    <label class="flex items-center gap-2">
                      <input type="checkbox" name="respuestas[{{ $pregunta->id }}][]" value="{{ $op->id }}"
                        class="text-gray-900 focus:ring-gray-900">
                      <span>{{ $op->texto_opcion }}</span>
                    </label>
                  @endforeach
                </div>

              @elseif($pregunta->tipo_pregunta === 'escala')
                <input type="number" min="1" max="10" name="respuestas[{{ $pregunta->id }}]"
                  class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                  placeholder="1 a 10">
              @endif
            </div>
          </div>
        @endforeach

        <button type="submit" class="w-full rounded-xl bg-gray-900 text-white py-3 font-semibold hover:opacity-90">
          Enviar respuestas
        </button>

        <p class="text-xs text-gray-500">
          Respuestas anónimas. No se solicita información personal.
        </p>
      </form>
    </div>
  </main>
</body>
</html>