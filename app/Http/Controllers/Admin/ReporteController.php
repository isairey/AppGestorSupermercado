<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('user', 'detalleVentas.producto');

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        $ventas          = $query->orderByDesc('created_at')->get();
        $totalVentas     = $ventas->sum('total');
        $totalProductos  = $ventas->flatMap->detalleVentas->sum('cantidad');
        $crecimiento     = '+12.5%'; // Placeholder, se puede calcular dinámicamente

        // Ventas agrupadas por mes (para la gráfica)
        $ventasPorMes = Venta::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, SUM(total) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Productos con bajo stock
        $productosAgotados = Producto::where('stock', '<=', 10)
            ->orderBy('stock')
            ->get();

        return view('admin.reportes', compact(
            'ventas',
            'totalVentas',
            'totalProductos',
            'crecimiento',
            'ventasPorMes',
            'productosAgotados'
        ));
    }
}
