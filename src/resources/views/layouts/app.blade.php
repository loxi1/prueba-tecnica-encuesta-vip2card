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
  @include('layouts.navigation')

  <main class="mx-auto max-w-5xl p-4">
    @isset($header)
      <div class="mb-4">{{ $header }}</div>
    @endisset

    {{ $slot }}
  </main>
</body>
</html>