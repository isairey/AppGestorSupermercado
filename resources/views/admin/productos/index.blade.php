@extends('layouts.app')

@section('title', 'Gestión de Productos')

@push('styles')
<style>
    .layout-admin { display: flex; min-height: calc(100vh - 62px); }
    .sidebar {
        width: 220px; background: var(--azul); padding: 20px 12px;
        flex-shrink: 0; position: sticky; top: 62px;
        height: calc(100vh - 62px); overflow-y: auto;
    }
    .sidebar-brand {
        padding: 8px 10px 16px; border-bottom: 1px solid rgba(255,255,255,.1); margin-bottom: 12px;
    }
    .sidebar-brand span { font-size: 11px; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .08em; }
    .sidebar-link {
        display: flex; align-items: center; gap: 10px; padding: 9px 12px;
        border-radius: 8px; color: rgba(255,255,255,.7); text-decoration: none;
        font-size: 13px; font-weight: 600; transition: background .15s, color .15s; margin-bottom: 2px;
    }
    .sidebar-link:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sidebar-link.active { background: var(--naranja); color: #fff; }
    .sidebar-link i { width: 16px; text-align: center; font-size: 13px; }

    .main { flex: 1; padding: 28px 32px; overflow-x: auto; }

    /* ── Header ──────────────────────────────── */
    .top-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
    }
    .top-bar h1 { font-size: 22px; font-weight: 800; color: var(--azul); }
    .top-bar p  { font-size: 13px; color: var(--texto-sub); }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--naranja); color: #fff; padding: 10px 20px;
        border-radius: 10px; font-size: 14px; font-weight: 700;
        text-decoration: none; border: none; cursor: pointer;
        font-family: 'Nunito', sans-serif; transition: background .2s;
    }
    .btn-primary:hover { background: var(--naranja-dk); }

    /* ── Filtros ─────────────────────────────── */
    .filters {
        background: #fff; border-radius: 12px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        padding: 16px 20px; margin-bottom: 20px;
        display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
    }
    .filters form { display: flex; gap: 12px; flex-wrap: wrap; width: 100%; align-items: center; }
    .filter-input {
        flex: 1; min-width: 180px; display: flex; align-items: center;
        gap: 8px; background: var(--gris-bg); border-radius: 8px; padding: 0 12px;
        border: 1.5px solid var(--gris-borde);
    }
    .filter-input i { color: var(--texto-sub); font-size: 13px; }
    .filter-input input, .filter-input select {
        background: none; border: none; padding: 9px 0;
        font-size: 13px; font-family: 'Nunito', sans-serif;
        color: var(--texto); outline: none; width: 100%;
    }
    .btn-filter {
        padding: 10px 18px; background: var(--azul); color: #fff; border: none;
        border-radius: 8px; font-size: 13px; font-weight: 700;
        font-family: 'Nunito', sans-serif; cursor: pointer; transition: background .2s;
        display: flex; align-items: center; gap: 6px;
    }
    .btn-filter:hover { background: var(--azul-mid); }
    .btn-reset {
        padding: 10px 14px; background: none; color: var(--texto-sub); border: 1.5px solid var(--gris-borde);
        border-radius: 8px; font-size: 13px; font-weight: 700;
        font-family: 'Nunito', sans-serif; cursor: pointer; text-decoration: none;
        display: flex; align-items: center; gap: 6px;
    }
    .btn-reset:hover { background: var(--gris-bg); }

    /* ── Tabla ───────────────────────────────── */
    .card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(30,58,95,.07); overflow: hidden; }
    .card-head {
        padding: 16px 20px; border-bottom: 1px solid var(--gris-borde);
        display: flex; align-items: center; justify-content: space-between;
    }
    .card-head h2 { font-size: 15px; font-weight: 700; color: var(--azul); }
    .count-badge {
        background: var(--azul-light); color: var(--azul);
        font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
    }

    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 10px 16px; background: #f8fafc; font-size: 11px;
        font-weight: 700; color: var(--texto-sub); text-transform: uppercase;
        letter-spacing: .06em; text-align: left; border-bottom: 1px solid var(--gris-borde);
        white-space: nowrap;
    }
    td { padding: 12px 16px; font-size: 13px; color: var(--texto); border-bottom: 1px solid var(--gris-borde); }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafbfc; }

    .prod-img {
        width: 44px; height: 44px; border-radius: 8px; object-fit: cover;
        background: #f0f4f8; display: flex; align-items: center;
        justify-content: center; color: #cbd5e0; font-size: 18px; overflow: hidden;
    }
    .prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .prod-name { font-weight: 700; }

    .badge { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .badge-cat { background: #ede9fe; color: #6d28d9; }
    .badge-ok  { background: #d1fae5; color: #065f46; }
    .badge-low { background: #fef3c7; color: #92400e; }
    .badge-out { background: #fee2e2; color: #991b1b; }

    .actions { display: flex; gap: 6px; }
    .btn-edit {
        width: 32px; height: 32px; background: #eff6ff; border: none;
        border-radius: 7px; color: #2563eb; cursor: pointer; font-size: 13px;
        display: flex; align-items: center; justify-content: center; text-decoration: none;
        transition: background .15s;
    }
    .btn-edit:hover { background: #dbeafe; }
    .btn-del {
        width: 32px; height: 32px; background: #fff0f0; border: none;
        border-radius: 7px; color: #ef4444; cursor: pointer; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .btn-del:hover { background: #fee2e2; }

    .empty-row td { text-align: center; padding: 40px; color: var(--texto-sub); }
</style>
@endpush

@section('content')
<div class="layout-admin">

    <aside class="sidebar">
        <div class="sidebar-brand"><span>Panel Admin</span></div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('admin.productos.index') }}" class="sidebar-link active">
            <i class="fas fa-boxes"></i> Gestión de Productos
        </a>
        <a href="{{ route('admin.reportes') }}" class="sidebar-link">
            <i class="fas fa-file-alt"></i> Reportes
        </a>
    </aside>

    <main class="main">
        <div class="top-bar">
            <div>
                <h1>Gestión de Productos</h1>
                <p>Administra el inventario de tu tienda</p>
            </div>
            <a href="{{ route('admin.productos.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Agregar Producto
            </a>
        </div>

        {{-- Filtros --}}
        <div class="filters">
            <form method="GET" action="{{ route('admin.productos.index') }}">
                <div class="filter-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="buscar" placeholder="Buscar por nombre o categoría..."
                        value="{{ request('buscar') }}">
                </div>
                <div class="filter-input" style="flex:0;min-width:180px">
                    <i class="fas fa-tag"></i>
                    <select name="categoria_id">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('admin.productos.index') }}" class="btn-reset"><i class="fas fa-xmark"></i> Limpiar</a>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="card">
            <div class="card-head">
                <h2>Lista de Productos</h2>
                <span class="count-badge">{{ $productos->count() }} producto(s)</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre del Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $p)
                        <tr>
                            <td>
                                <div class="prod-img">
                                    @if($p->imagen)
                                        <img src="{{ asset('storage/' . $p->imagen) }}" alt="{{ $p->nombre }}">
                                    @else
                                        <i class="fas fa-box"></i>
                                    @endif
                                </div>
                            </td>
                            <td><span class="prod-name">{{ $p->nombre }}</span></td>
                            <td><span class="badge badge-cat">{{ $p->categoria->nombre ?? '—' }}</span></td>
                            <td><strong>${{ number_format($p->precio, 2) }}</strong></td>
                            <td>{{ $p->stock }} unidades</td>
                            <td>
                                @if($p->stock == 0)
                                    <span class="badge badge-out">Sin stock</span>
                                @elseif($p->stock <= 10)
                                    <span class="badge badge-low">Stock bajo</span>
                                @else
                                    <span class="badge badge-ok">Disponible</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.productos.edit', $p->id) }}" class="btn-edit" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.productos.destroy', $p->id) }}"
                                        onsubmit="return confirm('¿Eliminar el producto {{ addslashes($p->nombre) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="7">
                                <i class="fas fa-box-open" style="font-size:32px;color:#cbd5e0;display:block;margin-bottom:8px"></i>
                                No se encontraron productos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection

