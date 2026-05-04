<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tienda de Abarrotes' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --azul:       #1e3a5f;
            --azul-mid:   #2c5282;
            --azul-light: #ebf4ff;
            --naranja:    #e85d04;
            --naranja-dk: #c44d00;
            --gris-bg:    #f4f6f9;
            --gris-borde: #dde3ec;
            --texto:      #1a202c;
            --texto-sub:  #64748b;
            --blanco:     #ffffff;
            --radio:      10px;
            --sombra:     0 2px 12px rgba(30,58,95,.10);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--gris-bg);
            color: var(--texto);
            min-height: 100vh;
        }

        /* ── NAVBAR ─────────────────────────────────── */
        .navbar {
            background: var(--azul);
            padding: 0 24px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,.18);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand .logo-icon {
            width: 34px; height: 34px;
            background: var(--naranja);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
        }
        .navbar-brand .brand-text {
            color: #fff;
            font-weight: 800;
            font-size: 17px;
            line-height: 1.1;
        }
        .navbar-brand .brand-sub {
            color: rgba(255,255,255,.55);
            font-size: 11px;
            font-weight: 400;
        }

        .navbar-search {
            flex: 1;
            max-width: 400px;
            margin: 0 24px;
        }
        .navbar-search form {
            display: flex;
            background: rgba(255,255,255,.12);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.2);
        }
        .navbar-search input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 8px 14px;
            color: #fff;
            font-size: 13px;
            font-family: 'Nunito', sans-serif;
            outline: none;
        }
        .navbar-search input::placeholder { color: rgba(255,255,255,.5); }
        .navbar-search button {
            background: none;
            border: none;
            padding: 0 14px;
            color: rgba(255,255,255,.7);
            cursor: pointer;
            font-size: 14px;
        }
        .navbar-search button:hover { color: #fff; }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 8px;
            color: rgba(255,255,255,.85);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background .15s;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
        }
        .nav-btn:hover { background: rgba(255,255,255,.12); color: #fff; }
        .nav-btn.active { background: rgba(255,255,255,.15); color: #fff; }
        .nav-btn .badge {
            background: var(--naranja);
            color: #fff;
            border-radius: 50%;
            width: 18px; height: 18px;
            font-size: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-btn-primary {
            background: var(--naranja);
            color: #fff !important;
        }
        .nav-btn-primary:hover { background: var(--naranja-dk) !important; }

        /* ── SIDEBAR ADMIN ──────────────────────────── */
        .layout-admin {
            display: flex;
            min-height: calc(100vh - 62px);
        }
        .sidebar {
            width: 220px;
            background: var(--azul);
            padding: 20px 12px;
            flex-shrink: 0;
        }
        .sidebar-section {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,.4);
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 0 10px;
            margin: 16px 0 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,.7);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background .15s, color .15s;
        }
        .sidebar-link:hover { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar-link.active { background: var(--naranja); color: #fff; }
        .sidebar-link i { width: 16px; text-align: center; font-size: 13px; }

        .main-content {
            flex: 1;
            padding: 28px 32px;
            overflow-x: auto;
        }

        /* ── CONTENEDOR CLIENTE ─────────────────────── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px 20px;
        }

        /* ── ALERTAS ────────────────────────────────── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radio);
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }

        /* ── FOOTER ─────────────────────────────────── */
        footer {
            background: var(--azul);
            color: rgba(255,255,255,.5);
            text-align: center;
            padding: 16px;
            font-size: 12px;
            margin-top: auto;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR solo si el usuario está autenticado --}}
@auth
<nav class="navbar">
    {{-- Marca --}}
    <a href="{{ auth()->user()->rol === 'admin' ? route('admin.dashboard') : route('catalogo') }}" class="navbar-brand">
        <div class="logo-icon"><i class="fas fa-store"></i></div>
        <div>
            <div class="brand-text">Abarrotes</div>
            <div class="brand-sub">El Buen Precio</div>
        </div>
    </a>

    {{-- Buscador (solo para clientes) --}}
    @if(auth()->user()->rol !== 'admin')
    <div class="navbar-search">
        <form action="{{ route('catalogo') }}" method="GET">
            <input type="text" name="buscar" placeholder="Buscar productos..." value="{{ request('buscar') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    @endif

    {{-- Acciones --}}
    <div class="navbar-actions">
        @if(auth()->user()->rol === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-btn {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.productos.index') }}" class="nav-btn {{ request()->routeIs('admin.productos*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i> Productos
            </a>
            <a href="{{ route('admin.reportes') }}" class="nav-btn {{ request()->routeIs('admin.reportes') ? 'active' : '' }}">
                <i class="fas fa-file-chart-line"></i> Reportes
            </a>
        @else
            <a href="{{ route('catalogo') }}" class="nav-btn {{ request()->routeIs('catalogo') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Inicio
            </a>
            <a href="{{ route('perfil') }}" class="nav-btn {{ request()->routeIs('perfil') ? 'active' : '' }}">
                <i class="fas fa-user"></i> {{ auth()->user()->name }}
            </a>
            <a href="{{ route('carrito') }}" class="nav-btn {{ request()->routeIs('carrito') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Carrito
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-btn nav-btn-primary">
                <i class="fas fa-sign-out-alt"></i> Salir
            </button>
        </form>
    </div>
</nav>
@endauth

{{-- Alertas globales --}}
@if(session('success'))
    <div style="max-width:1200px;margin:16px auto;padding:0 20px">
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div style="max-width:1200px;margin:16px auto;padding:0 20px">
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    </div>
@endif

{{-- Contenido principal --}}
@yield('content')

<footer>
    &copy; {{ date('Y') }} Tienda de Abarrotes El Buen Precio &mdash; Sistema de Gestión
</footer>

@stack('scripts')
</body>
</html>
