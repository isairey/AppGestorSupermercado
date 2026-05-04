@extends('layouts.app')

@section('title', 'Dashboard — Admin')

@push('styles')
<style>
    .layout-admin { display: flex; min-height: calc(100vh - 62px); }

    /* ── Sidebar ─────────────────────────────── */
    .sidebar {
        width: 220px; background: var(--azul); padding: 20px 12px;
        flex-shrink: 0; position: sticky; top: 62px;
        height: calc(100vh - 62px); overflow-y: auto;
    }
    .sidebar-brand {
        padding: 8px 10px 16px; border-bottom: 1px solid rgba(255,255,255,.1);
        margin-bottom: 12px;
    }
    .sidebar-brand span {
        font-size: 11px; font-weight: 700; color: rgba(255,255,255,.4);
        text-transform: uppercase; letter-spacing: .08em;
    }
    .sidebar-link {
        display: flex; align-items: center; gap: 10px; padding: 9px 12px;
        border-radius: 8px; color: rgba(255,255,255,.7); text-decoration: none;
        font-size: 13px; font-weight: 600; transition: background .15s, color .15s;
        margin-bottom: 2px;
    }
    .sidebar-link:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sidebar-link.active { background: var(--naranja); color: #fff; }
    .sidebar-link i { width: 16px; text-align: center; font-size: 13px; }

    /* ── Contenido ───────────────────────────── */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; }

    .page-title { font-size: 22px; font-weight: 800; color: var(--azul); margin-bottom: 4px; }
    .page-sub   { font-size: 13px; color: var(--texto-sub); margin-bottom: 24px; }

    /* ── KPI cards ───────────────────────────── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    .kpi-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        padding: 20px; display: flex; align-items: center; gap: 16px;
    }
    .kpi-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; flex-shrink: 0;
    }
    .kpi-icon.azul    { background: #ebf4ff; color: var(--azul); }
    .kpi-icon.naranja { background: #fff1e6; color: var(--naranja); }
    .kpi-icon.verde   { background: #d1fae5; color: #059669; }
    .kpi-icon.rojo    { background: #fee2e2; color: #dc2626; }

    .kpi-info .value {
        font-size: 26px; font-weight: 800; color: var(--azul); line-height: 1;
    }
    .kpi-info .label {
        font-size: 12px; font-weight: 600; color: var(--texto-sub); margin-top: 4px;
    }

    /* ── Accesos rápidos ─────────────────────── */
    .quick-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
        margin-bottom: 28px;
    }
    .quick-card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        padding: 20px; text-decoration: none;
        display: flex; align-items: center; gap: 16px;
        transition: transform .2s, box-shadow .2s;
        border: 2px solid transparent;
    }
    .quick-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30,58,95,.12);
        border-color: var(--naranja);
    }
    .quick-card .qc-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: var(--azul); color: #fff; font-size: 20px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .quick-card .qc-title { font-size: 14px; font-weight: 700; color: var(--azul); }
    .quick-card .qc-sub   { font-size: 12px; color: var(--texto-sub); margin-top: 2px; }

    /* ── Tabla productos recientes ───────────── */
    .card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07); overflow: hidden;
    }
    .card-head {
        padding: 16px 20px; border-bottom: 1px solid var(--gris-borde);
        display: flex; align-items: center; justify-content: space-between;
    }
    .card-head h2 { font-size: 15px; font-weight: 700; color: var(--azul); }

    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 10px 16px; background: #f8fafc; font-size: 11px;
        font-weight: 700; color: var(--texto-sub); text-transform: uppercase;
        letter-spacing: .06em; text-align: left; border-bottom: 1px solid var(--gris-borde);
    }
    td {
        padding: 13px 16px; font-size: 13px; color: var(--texto);
        border-bottom: 1px solid var(--gris-borde);
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafbfc; }

    .badge {
        font-size: 11px; font-weight: 700; padding: 3px 10px;
        border-radius: 20px;
    }
    .badge-ok  { background: #d1fae5; color: #065f46; }
    .badge-low { background: #fef3c7; color: #92400e; }
    .badge-out { background: #fee2e2; color: #991b1b; }

    .btn-link {
        font-size: 13px; font-weight: 700; color: var(--naranja);
        text-decoration: none;
    }
    .btn-link:hover { text-decoration: underline; }

    .status-bar {
        padding: 14px 20px; background: #f0fdf4;
        border-top: 1px solid #bbf7d0; font-size: 13px;
        color: #15803d; display: flex; align-items: center; gap: 8px;
    }
</style>
@endpush

@section('content')
<div class="layout-admin">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand"><span>Panel Admin</span></div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('admin.productos.index') }}" class="sidebar-link">
            <i class="fas fa-boxes"></i> Gestión de Productos
        </a>
        <a href="{{ route('admin.reportes') }}" class="sidebar-link">
            <i class="fas fa-file-alt"></i> Reportes
        </a>
    </aside>

    {{-- Contenido --}}
    <main class="main">
        <div class="page-title">Dashboard</div>
        <div class="page-sub">Bienvenido al panel de administración</div>

        {{-- KPIs --}}
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon azul"><i class="fas fa-boxes"></i></div>
                <div class="kpi-info">
                    <div class="value">{{ $totalProductos }}</div>
                    <div class="label">Total de productos</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon rojo"><i class="fas fa-triangle-exclamation"></i></div>
                <div class="kpi-info">
                    <div class="value">{{ $bajoInventario }}</div>
                    <div class="label">Bajo inventario</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon verde"><i class="fas fa-users"></i></div>
                <div class="kpi-info">
                    <div class="value">{{ $totalClientes }}</div>
                    <div class="label">Clientes registrados</div>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon naranja"><i class="fas fa-dollar-sign"></i></div>
                <div class="kpi-info">
                    <div class="value">${{ number_format($ventasHoy, 0) }}</div>
                    <div class="label">Ventas del día</div>
                </div>
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="quick-grid">
            <a href="{{ route('admin.productos.index') }}" class="quick-card">
                <div class="qc-icon"><i class="fas fa-boxes"></i></div>
                <div>
                    <div class="qc-title">Gestión de Productos</div>
                    <div class="qc-sub">Administrar inventario, añadir y editar productos</div>
                </div>
            </a>
            <a href="{{ route('admin.reportes') }}" class="quick-card">
                <div class="qc-icon"><i class="fas fa-chart-bar"></i></div>
                <div>
                    <div class="qc-title">Ver Reportes</div>
                    <div class="qc-sub">Consultar ventas, inventario y estadísticas</div>
                </div>
            </a>
        </div>

        {{-- Tabla productos recientes --}}
        <div class="card">
            <div class="card-head">
                <h2>Productos recientes</h2>
                <a href="{{ route('admin.productos.index') }}" class="btn-link">Ver todos →</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productosRecientes as $p)
                        <tr>
                            <td><strong>{{ $p->nombre }}</strong></td>
                            <td>{{ $p->categoria->nombre ?? '—' }}</td>
                            <td>${{ number_format($p->precio, 2) }}</td>
                            <td>{{ $p->stock }}</td>
                            <td>
                                @if($p->stock == 0)
                                    <span class="badge badge-out">Sin stock</span>
                                @elseif($p->stock <= 10)
                                    <span class="badge badge-low">Stock bajo</span>
                                @else
                                    <span class="badge badge-ok">Disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;color:var(--texto-sub)">Sin productos registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="status-bar">
                <i class="fas fa-circle-check"></i>
                El sistema está funcionando correctamente. Última actualización: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </main>
</div>
@endsection
