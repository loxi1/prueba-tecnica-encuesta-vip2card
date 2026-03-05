<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'VIP2CARS') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
      <div class="mb-4 text-center">
        <a href="{{ url('/') }}" class="font-bold text-xl">{{ config('app.name', 'VIP2CARS') }}</a>
        <div class="text-sm text-gray-500">Prueba técnica • Laravel • CRUD + Encuestas</div>
      </div>

      <div class="bg-white border rounded-2xl shadow-sm p-6">
        {{ $slot }}
      </div>

      <p class="mt-6 text-center text-xs text-gray-500">
        © {{ date('Y') }} {{ config('app.name', 'VIP2CARS') }}
      </p>
    </div>
  </div>
</body>
</html>