<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Mostrar formulario de login ──────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        return view('auth.login');
    }

    // ── Procesar login ───────────────────────────────
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciales, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirigirSegunRol();
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Correo o contraseña incorrectos.']);
    }

    // ── Mostrar formulario de registro ───────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── Procesar registro ────────────────────────────
    public function register(Request $request)
    {
        $datos = $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'direccion'             => 'nullable|string|max:200',
            'ciudad'                => 'nullable|string|max:100',
            'codigo_postal'         => 'nullable|string|max:10',
            'pais'                  => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name'          => $datos['name'],
            'email'         => $datos['email'],
            'password'      => Hash::make($datos['password']),
            'rol'           => 'cliente',
            'direccion'     => $datos['direccion'] ?? null,
            'ciudad'        => $datos['ciudad'] ?? null,
            'codigo_postal' => $datos['codigo_postal'] ?? null,
            'pais'          => $datos['pais'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('catalogo')
            ->with('success', '¡Bienvenido, ' . $user->name . '!');
    }

    // ── Logout ───────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ── Helper: redirigir según rol ──────────────────
    private function redirigirSegunRol()
    {
        return Auth::user()->rol === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('catalogo');
    }
}
