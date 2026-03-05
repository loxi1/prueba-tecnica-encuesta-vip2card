<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.clientes.index') }}" class="rounded-2xl border bg-white p-5 hover:bg-gray-50">
      <div class="font-semibold">Clientes</div>
      <div class="text-sm text-gray-600 mt-1">CRUD + búsqueda/paginación.</div>
    </a>

    <a href="{{ route('admin.vehiculos.index') }}" class="rounded-2xl border bg-white p-5 hover:bg-gray-50">
      <div class="font-semibold">Vehículos</div>
      <div class="text-sm text-gray-600 mt-1">CRUD + validaciones.</div>
    </a>

    <a href="{{ route('admin.encuestas.index') }}" class="rounded-2xl border bg-white p-5 hover:bg-gray-50">
      <div class="font-semibold">Encuestas</div>
      <div class="text-sm text-gray-600 mt-1">Admin + métricas + flujo anónimo.</div>
    </a>
  </div>
</x-app-layout>