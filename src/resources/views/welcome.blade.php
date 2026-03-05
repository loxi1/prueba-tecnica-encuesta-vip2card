<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'VIP2CARS') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
  @include('layouts.navigation')

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white border rounded-3xl shadow-sm p-8">
      <div class="flex flex-col gap-6">
        <div>
          <h1 class="text-3xl font-bold">Prueba Técnica • VIP2CARS</h1>
          <p class="mt-2 text-gray-600">
            Mini proyecto en Laravel con CRUD (Clientes / Vehículos) y módulo de encuestas anónimas.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          @auth
            <a href="{{ route('dashboard') }}"
               class="rounded-2xl border p-5 hover:bg-gray-50">
              <div class="font-semibold">Ir al Dashboard</div>
              <div class="text-sm text-gray-600 mt-1">Acceso al panel y módulos.</div>
            </a>

            <a href="{{ route('admin.home') }}"
               class="rounded-2xl border p-5 hover:bg-gray-50">
              <div class="font-semibold">Ir al Admin</div>
              <div class="text-sm text-gray-600 mt-1">Clientes, vehículos y encuestas.</div>
            </a>
          @else
            <a href="{{ route('login') }}"
               class="rounded-2xl border p-5 hover:bg-gray-50">
              <div class="font-semibold">Iniciar sesión</div>
              <div class="text-sm text-gray-600 mt-1">Acceso al panel admin.</div>
            </a>

            <a href="{{ route('register') }}"
               class="rounded-2xl border p-5 hover:bg-gray-50">
              <div class="font-semibold">Crear cuenta</div>
              <div class="text-sm text-gray-600 mt-1">Registro (si está habilitado).</div>
            </a>
          @endauth

          {{-- Encuesta pública: ideal para evaluar sin credenciales --}}
          <a href="{{ url('/encuestas/1/form') }}"
             class="rounded-2xl border p-5 hover:bg-gray-50">
            <div class="font-semibold">Responder encuesta demo</div>
            <div class="text-sm text-gray-600 mt-1">Flujo anónimo (público).</div>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="rounded-2xl border bg-gray-50 p-4">
            <div class="font-semibold">Módulos evaluables</div>
            <ul class="mt-2 text-sm text-gray-700 list-disc pl-5 space-y-1">
              <li>CRUD Clientes (validaciones + búsqueda/paginación)</li>
              <li>CRUD Vehículos (validaciones + búsqueda/paginación)</li>
              <li>Encuestas anónimas (público + admin)</li>
            </ul>
          </div>

          <div class="rounded-2xl border bg-gray-50 p-4">
            <div class="font-semibold">Credenciales demo</div>
            <div class="mt-2 text-sm text-gray-700">
              <div>Email: <span class="font-mono">anibal.cayetano@gmail.com</span></div>
              <div>Password: <span class="font-mono">acme654123</span></div>
              <div class="text-xs text-gray-500 mt-2">
                (También puedes registrar un usuario si el registro está habilitado)
              </div>
            </div>
          </div>
        </div>

        <div class="text-xs text-gray-500">
          Tip: La app corre en <span class="font-mono">http://localhost:8080</span> (Docker).
        </div>
      </div>
    </div>
  </main>
</body>
</html>