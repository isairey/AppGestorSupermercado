<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Si no está autenticado o no es admin, redirige al catálogo
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
            return redirect()->route('catalogo')
                ->with('error', 'No tienes permisos para acceder al panel de administrador.');
        }

        return $next($request);
    }
}