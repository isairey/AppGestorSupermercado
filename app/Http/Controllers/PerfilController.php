<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    // ── Ver perfil ───────────────────────────────────
    public function index()
    {
        $user = auth()->user();
        return view('cliente.perfil', compact('user'));
    }

    // ── Actualizar datos del perfil ──────────────────
    public function actualizar(Request $request)
    {
        $user  = auth()->user();

        $datos = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'direccion'     => 'nullable|string|max:200',
            'ciudad'        => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'pais'          => 'nullable|string|max:100',
            'password'      => 'nullable|min:6|confirmed',
        ]);

        $user->name          = $datos['name'];
        $user->email         = $datos['email'];
        $user->direccion     = $datos['direccion'] ?? $user->direccion;
        $user->ciudad        = $datos['ciudad'] ?? $user->ciudad;
        $user->codigo_postal = $datos['codigo_postal'] ?? $user->codigo_postal;
        $user->pais          = $datos['pais'] ?? $user->pais;

        if (!empty($datos['password'])) {
            $user->password = Hash::make($datos['password']);
        }

        $user->save();

        return redirect()->route('perfil')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    // ── Historial de pedidos ─────────────────────────
    public function pedidos()
    {
        $pedidos = Venta::with('detalleVentas.producto')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('cliente.pedidos', compact('pedidos'));
    }
}