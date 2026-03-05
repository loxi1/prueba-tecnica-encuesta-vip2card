<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between gap-3">
      <div>
        <h2 class="font-semibold text-xl text-gray-800">{{ $encuesta->titulo }}</h2>
        <div class="text-sm text-gray-500">
          {{ $encuesta->publicada ? 'Publicada' : 'Borrador' }}
          · ID #{{ $encuesta->id }}
        </div>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.encuestas.index') }}" class="text-sm px-3 py-2 rounded-lg border bg-white hover:bg-gray-50">← Volver</a>
        <a href="{{ route('admin.encuestas.edit', $encuesta) }}" class="text-sm px-3 py-2 rounded-lg border bg-white hover:bg-gray-50">Editar</a>
        <a href="{{ route('encuestas.form', $encuesta) }}" target="_blank" class="text-sm px-3 py-2 rounded-lg bg-gray-900 text-white hover:opacity-90">Link público</a>

        <form method="POST" action="{{ route('admin.encuestas.destroy', $encuesta) }}"
              onsubmit="return confirm('¿Eliminar encuesta? (se borrará lógico)')">
          @csrf @method('DELETE')
          <button class="text-sm px-3 py-2 rounded-lg border border-red-300 bg-red-50 text-red-700 hover:bg-red-100">
            Eliminar
          </button>
        </form>
      </div>
    </div>
  </x-slot>

  <div class="max-w-6xl mx-auto p-6 space-y-6">

    @if(session('status'))
      <div class="rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">
        {{ session('status') }}
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded-2xl border shadow-sm">
        <div class="text-sm text-gray-500">Preguntas</div>
        <div class="text-2xl font-semibold">{{ $encuesta->preguntas->count() }}</div>
      </div>
      <div class="bg-white p-4 rounded-2xl border shadow-sm">
        <div class="text-sm text-gray-500">Envíos (envio_uuid únicos)</div>
        <div class="text-2xl font-semibold">{{ $totales->envios ?? 0 }}</div>
      </div>
      <div class="bg-white p-4 rounded-2xl border shadow-sm">
        <div class="text-sm text-gray-500">Respuestas totales</div>
        <div class="text-2xl font-semibold">{{ $totales->respuestas ?? 0 }}</div>
      </div>
    </div>

    {{-- Crear pregunta --}}
    <div class="bg-white p-5 rounded-2xl border shadow-sm">
      <h3 class="font-semibold text-lg">Agregar pregunta</h3>
      <form method="POST" action="{{ route('admin.preguntas.store', $encuesta) }}" class="mt-4 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
        @csrf
        <div class="md:col-span-6">
          <label class="text-sm font-medium">Texto</label>
          <input name="texto_pregunta" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
        </div>
        <div class="md:col-span-3">
          <label class="text-sm font-medium">Tipo</label>
          <select name="tipo_pregunta" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
            <option value="unica">Única</option>
            <option value="multiple">Múltiple</option>
            <option value="texto">Texto</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="text-sm font-medium">Orden</label>
          <input type="number" name="orden" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" placeholder="auto">
        </div>
        <div class="md:col-span-1">
          <label class="text-sm font-medium">Req.</label>
          <input type="checkbox" name="requerida" value="1" checked class="mt-3 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
        </div>

        <div class="md:col-span-12">
          <button class="w-full rounded-xl bg-gray-900 text-white py-3 font-semibold hover:opacity-90">
            Agregar
          </button>
        </div>
      </form>
    </div>

    {{-- Preguntas existentes + opciones --}}
    <div class="bg-white p-5 rounded-2xl border shadow-sm">
      <h3 class="font-semibold text-lg">Preguntas y opciones</h3>

      <div class="mt-4 space-y-6">
        @forelse($encuesta->preguntas as $p)
          <div class="rounded-2xl border p-4">
            <div class="flex items-start justify-between gap-3">
              <div>
                <div class="font-semibold">
                  #{{ $p->orden }} · {{ $p->texto_pregunta }}
                  @if($p->requerida) <span class="text-red-600">*</span> @endif
                  <span class="text-xs text-gray-500">({{ $p->tipo_pregunta }})</span>
                </div>
              </div>

              <form method="POST" action="{{ route('admin.preguntas.destroy', $p) }}"
                    onsubmit="return confirm('¿Eliminar pregunta?')">
                @csrf @method('DELETE')
                <button class="text-xs px-3 py-2 rounded-lg border border-red-300 bg-red-50 text-red-700 hover:bg-red-100">
                  Eliminar
                </button>
              </form>
            </div>

            {{-- editar pregunta --}}
            <form method="POST" action="{{ route('admin.preguntas.update', $p) }}" class="mt-3 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
              @csrf @method('PUT')
              <div class="md:col-span-6">
                <label class="text-xs font-medium text-gray-600">Texto</label>
                <input name="texto_pregunta" value="{{ $p->texto_pregunta }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
              </div>
              <div class="md:col-span-3">
                <label class="text-xs font-medium text-gray-600">Tipo</label>
                <select name="tipo_pregunta" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                  <option value="unica" {{ $p->tipo_pregunta==='unica'?'selected':'' }}>Única</option>
                  <option value="multiple" {{ $p->tipo_pregunta==='multiple'?'selected':'' }}>Múltiple</option>
                  <option value="texto" {{ $p->tipo_pregunta==='texto'?'selected':'' }}>Texto</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="text-xs font-medium text-gray-600">Orden</label>
                <input type="number" name="orden" value="{{ $p->orden }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
              </div>
              <div class="md:col-span-1">
                <label class="text-xs font-medium text-gray-600">Req.</label>
                <input type="checkbox" name="requerida" value="1" {{ $p->requerida ? 'checked' : '' }}
                       class="mt-3 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
              </div>

              <div class="md:col-span-12 flex justify-end">
                <button class="text-sm px-4 py-2 rounded-xl bg-gray-900 text-white hover:opacity-90">
                  Guardar pregunta
                </button>
              </div>
            </form>

            {{-- opciones --}}
            @if($p->tipo_pregunta !== 'texto')
              <div class="mt-4">
                <div class="text-sm font-semibold">Opciones</div>

                <div class="mt-2 space-y-2">
                  @forelse($p->opciones as $o)
                    <div class="flex items-center gap-2">
                      <form method="POST" action="{{ route('admin.opciones.update', $o) }}" class="flex-1 flex gap-2">
                        @csrf @method('PUT')
                        <input name="texto_opcion" value="{{ $o->texto_opcion }}"
                               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                        <input type="number" name="orden" value="{{ $o->orden }}"
                               class="w-24 rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                        <button class="px-3 py-2 rounded-lg border bg-white hover:bg-gray-50 text-sm">Guardar</button>
                      </form>

                      <form method="POST" action="{{ route('admin.opciones.destroy', $o) }}"
                            onsubmit="return confirm('¿Eliminar opción?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 rounded-lg border border-red-300 bg-red-50 text-red-700 hover:bg-red-100 text-sm">
                          X
                        </button>
                      </form>
                    </div>
                  @empty
                    <div class="text-sm text-gray-500">Sin opciones aún.</div>
                  @endforelse
                </div>

                {{-- agregar opción --}}
                <form method="POST" action="{{ route('admin.opciones.store', $p) }}" class="mt-3 flex gap-2">
                  @csrf
                  <input name="texto_opcion" placeholder="Nueva opción..."
                         class="flex-1 rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                  <input type="number" name="orden" placeholder="orden" class="w-24 rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                  <button class="px-4 py-2 rounded-xl bg-gray-900 text-white hover:opacity-90">Agregar</button>
                </form>
              </div>
            @endif
          </div>
        @empty
          <div class="text-sm text-gray-500">No hay preguntas todavía.</div>
        @endforelse
      </div>
    </div>

    {{-- Resultados --}}
    <div class="bg-white p-5 rounded-2xl border shadow-sm">
      <h3 class="font-semibold text-lg">Resultados (conteo por opción)</h3>

      <div class="mt-4 space-y-4">
        @foreach($encuesta->preguntas as $p)
          <div class="rounded-xl border p-4">
            <div class="font-semibold">{{ $p->texto_pregunta }}</div>

            @php $rows = $stats[$p->id] ?? collect(); @endphp

            @if($rows->count())
              <div class="mt-3 overflow-x-auto">
                <table class="min-w-full text-sm">
                  <thead class="bg-gray-100">
                    <tr>
                      <th class="px-3 py-2 text-left">Opción</th>
                      <th class="px-3 py-2 text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rows as $row)
                      <tr class="border-t">
                        <td class="px-3 py-2">{{ $row->texto_opcion ?? 'Texto libre' }}</td>
                        <td class="px-3 py-2 text-right font-semibold">{{ $row->total }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="text-sm text-gray-500 mt-2">Sin respuestas.</div>
            @endif
          </div>
        @endforeach
      </div>
    </div>

    {{-- Últimos envíos --}}
    <div class="bg-white p-5 rounded-2xl border shadow-sm">
      <h3 class="font-semibold text-lg">Últimos 25 envíos</h3>

      <div class="mt-3 overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-3 py-2 text-left">envio_uuid</th>
              <th class="px-3 py-2 text-left">Fecha</th>
              <th class="px-3 py-2 text-right">Respuestas</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ultimosEnvios as $e)
              @php
                $count = \App\Models\Respuesta::where('encuesta_id', $encuesta->id)
                  ->where('envio_uuid', $e->envio_uuid)->count();
              @endphp
              <tr class="border-t">
                <td class="px-3 py-2 font-mono text-xs">{{ $e->envio_uuid }}</td>
                <td class="px-3 py-2">{{ \Illuminate\Support\Carbon::parse($e->fecha)->timezone(config('app.timezone'))->format('d/m/Y H:i') }}</td>
                <td class="px-3 py-2 text-right font-semibold">{{ $count }}</td>
              </tr>
            @empty
              <tr><td colspan="3" class="px-3 py-4 text-center text-gray-500">Sin envíos aún</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</x-app-layout>