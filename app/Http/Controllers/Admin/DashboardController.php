<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarjetas del dashboard
        $totalProductos    = Producto::count();
        $bajoInventario    = Producto::where('stock', '<=', 10)->count();
        $totalClientes     = User::where('rol', 'cliente')->count();
        $totalPedidos      = Venta::count();
        $ventasHoy         = Venta::whereDate('created_at', today())->sum('total');

        // Productos recientes
        $productosRecientes = Producto::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProductos',
            'bajoInventario',
            'totalClientes',
            'totalPedidos',
            'ventasHoy',
            'productosRecientes'
        ));
    }
}
