<nav class="bg-white border-b">
  <div class="mx-auto max-w-5xl px-4 py-3 flex items-center justify-between">
    <a href="{{ url('/') }}" class="font-bold">{{ config('app.name', 'VIP2CARS') }}</a>

    <div class="flex items-center gap-2">
      @auth
        <a href="{{ route('dashboard') }}" class="text-sm px-3 py-2 rounded-lg hover:bg-gray-100">Dashboard</a>
        <a href="{{ route('admin.clientes.index') }}" class="text-sm px-3 py-2 rounded-lg hover:bg-gray-100">Clientes</a>
        <a href="{{ route('admin.vehiculos.index') }}" class="text-sm px-3 py-2 rounded-lg hover:bg-gray-100">Vehículos</a>
        <a href="{{ route('admin.encuestas.index') }}" class="text-sm px-3 py-2 rounded-lg hover:bg-gray-100">Encuestas</a>
        <a href="{{ route('profile.edit') }}" class="text-sm px-3 py-2 rounded-lg hover:bg-gray-100">Perfil</a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="text-sm px-3 py-2 rounded-lg bg-gray-900 text-white hover:opacity-90">
            Salir
          </button>
        </form>
      @else
        <a href="{{ route('login') }}" class="text-sm px-3 py-2 rounded-lg bg-gray-900 text-white hover:opacity-90">
          Iniciar sesión
        </a>
      @endauth
    </div>
  </div>
</nav>