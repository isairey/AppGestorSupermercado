@extends('layouts.app')

@section('title', 'Mis Pedidos')

@push('styles')
<style>
    .page-header {
        background: #fff;
        border-bottom: 1px solid var(--gris-borde);
        padding: 20px 0;
    }
    .page-header h1 {
        font-size: 22px; font-weight: 800; color: var(--azul);
        display: flex; align-items: center; gap: 10px;
    }
    .page-header h1 i { color: var(--naranja); }

    .card {
        background: #fff; border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        overflow: hidden; margin-bottom: 16px;
    }
    .card-head {
        padding: 16px 20px; border-bottom: 1px solid var(--gris-borde);
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; transition: background .15s;
    }
    .card-head:hover { background: #fafbfc; }

    .order-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .order-num { font-size: 15px; font-weight: 800; color: var(--azul); }
    .order-date { font-size: 13px; color: var(--texto-sub); }

    .badge {
        font-size: 11px; font-weight: 700; padding: 4px 12px;
        border-radius: 20px; white-space: nowrap;
    }
    .badge-entregado { background: #d1fae5; color: #065f46; }
    .badge-camino    { background: #dbeafe; color: #1e40af; }
    .badge-procesando{ background: #fef3c7; color: #92400e; }
    .badge-cancelado { background: #fee2e2; color: #991b1b; }

    .order-total { font-size: 17px; font-weight: 800; color: var(--azul); }
    .order-caret { color: var(--texto-sub); font-size: 13px; transition: transform .2s; }
    .card-head.open .order-caret { transform: rotate(180deg); }

    /* Detalle del pedido */
    .order-body { padding: 0; display: none; }
    .order-body.open { display: block; }

    .order-item {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--gris-borde);
    }
    .order-item:last-child { border-bottom: none; }

    .oi-img {
        width: 48px; height: 48px; border-radius: 8px;
        background: #f0f4f8; display: flex; align-items: center;
        justify-content: center; color: #cbd5e0; font-size: 20px;
        flex-shrink: 0; overflow: hidden;
    }
    .oi-img img { width: 100%; height: 100%; object-fit: cover; }
    .oi-name { flex: 1; font-size: 14px; font-weight: 700; color: var(--texto); }
    .oi-qty  { font-size: 13px; color: var(--texto-sub); white-space: nowrap; }
    .oi-sub  { font-size: 14px; font-weight: 700; color: var(--azul); white-space: nowrap; }

    /* Estado vacío */
    .empty-state {
        padding: 64px 20px; text-align: center; color: var(--texto-sub);
    }
    .empty-state i { font-size: 56px; color: #cbd5e0; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 700; color: var(--texto); margin-bottom: 8px; }
    .btn-ir {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--naranja); color: #fff; padding: 11px 24px;
        border-radius: 10px; font-weight: 700; font-size: 14px;
        text-decoration: none; transition: background .2s; margin-top: 16px;
    }
    .btn-ir:hover { background: var(--naranja-dk); }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="container" style="padding-top:0;padding-bottom:0">
        <h1><i class="fas fa-box"></i> Mis Pedidos</h1>
    </div>
</div>

<div class="container">

    @if($pedidos->isEmpty())
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Aún no tienes pedidos</h3>
                <p>Realiza tu primera compra desde el catálogo.</p>
                <a href="{{ route('catalogo') }}" class="btn-ir">
                    <i class="fas fa-store"></i> Ir al catálogo
                </a>
            </div>
        </div>
    @else
        @foreach($pedidos as $pedido)
        @php
            $estado = 'Procesando';
            $badgeClass = 'badge-procesando';
            $dias = $pedido->created_at->diffInDays(now());
            if ($dias >= 7) { $estado = 'Entregado'; $badgeClass = 'badge-entregado'; }
            elseif ($dias >= 2) { $estado = 'En camino'; $badgeClass = 'badge-camino'; }
        @endphp

        <div class="card">
            <div class="card-head" onclick="togglePedido(this)">
                <div class="order-meta">
                    <span class="order-num">#ORD-{{ str_pad($pedido->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="order-date">
                        <i class="fas fa-calendar-alt" style="margin-right:4px"></i>
                        {{ $pedido->created_at->format('d/m/Y') }}
                    </span>
                    <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:16px">
                    <span class="order-total">${{ number_format($pedido->total, 2) }}</span>
                    <i class="fas fa-chevron-down order-caret"></i>
                </div>
            </div>

            <div class="order-body">
                @foreach($pedido->detalleVentas as $detalle)
                    <div class="order-item">
                        <div class="oi-img">
                            @if($detalle->producto && $detalle->producto->imagen)
                                <img src="{{ asset('storage/' . $detalle->producto->imagen) }}" alt="">
                            @else
                                <i class="fas fa-box"></i>
                            @endif
                        </div>
                        <span class="oi-name">{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</span>
                        <span class="oi-qty">× {{ $detalle->cantidad }}</span>
                        <span class="oi-sub">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

</div>
@endsection

@push('scripts')
<script>
function togglePedido(header) {
    header.classList.toggle('open');
    header.nextElementSibling.classList.toggle('open');
}
</script>
@endpush
