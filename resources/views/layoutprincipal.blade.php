  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>GarMorel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Francois+One&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('style2.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">


  </head>
  <body class="cuerpo">
    <div class="logo">
      <img src="{{ asset('IMG/logo01.png') }}" alt="logo moda">

      <aside class="sidebar">
        <nav class="menu">
          <ul class="menu-content">
            <li><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i><span>Inicio</span></a></li>
            <li><a href="{{ route('facturas.index') }}"><i class="bi bi-receipt"></i><span>Factura</span></a></li>
            <li><a href="{{ route('clientes.index') }}"><i class="bi bi-people"></i><span>Clientes</span></a></li>
            <li><a href="{{ route('productos.index') }}"><i class="bi bi-box-seam"></i><span>Productos</span></a></li>

            {{-- Solo mostrar Usuarios y Roles si NO es Vendedor --}}
            @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
              <li><a href="{{ route('usuarios.index') }}"><i class="bi bi-person"></i><span>Usuarios</span></a></li>
              <li><a href="{{ route('roles.index') }}"><i class="bi bi-shield-lock"></i><span>Roles</span></a></li>
            @endif

          </ul>
        </nav>
      </aside>
    </div>

    <main class="main">
      <div class="header">
        <h1 class="text-usuarios">GarMorel</h1>

        @auth
        <div class="user-avatar">
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            {{ strtoupper(substr(Auth::user()->nombre, 0, 2)) }}
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">{{ Auth::user()->nombre }}</a></li>
            <li><a class="dropdown-item" href="#">{{ Auth::user()->email }}</a></li>
            <li><a class="dropdown-item" href="#">{{ Auth::user()->rol->tipo ?? 'Sin rol' }}</a></li>
            <li><hr class="dropdown-divider"></li>

            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                  <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
              </form>
            </li>

          </ul>
        </div>
        @endauth
      </div>

      <div class="container-info">
        @yield('contenido')
      </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>
