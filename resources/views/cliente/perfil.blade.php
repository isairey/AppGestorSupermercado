@extends('layouts.app')

@section('title', 'Mi Perfil')

@push('styles')
<style>
    .page-header {
        background: #fff;
        border-bottom: 1px solid var(--gris-borde);
        padding: 20px 0;
    }
    .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: var(--azul);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-header h1 i { color: var(--naranja); }
    .page-header p { font-size: 13px; color: var(--texto-sub); margin-top: 2px; }

    .layout-perfil {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* ── Card base ───────────────────────────── */
    .card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .card-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gris-borde);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-head h2 { font-size: 15px; font-weight: 700; color: var(--azul); }
    .card-head i { color: var(--naranja); font-size: 14px; }
    .card-body { padding: 20px; }

    /* ── Avatar / info lateral ───────────────── */
    .avatar-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 28px 20px;
        text-align: center;
    }
    .avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: var(--azul);
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 32px;
        font-weight: 800;
    }
    .avatar-name { font-size: 16px; font-weight: 800; color: var(--texto); }
    .avatar-email { font-size: 13px; color: var(--texto-sub); }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 20px;
        border-top: 1px solid var(--gris-borde);
        font-size: 13px;
    }
    .info-row i { color: var(--naranja); width: 16px; margin-top: 1px; flex-shrink: 0; }
    .info-row .label { color: var(--texto-sub); font-weight: 600; }
    .info-row .value { color: var(--texto); font-weight: 700; margin-top: 2px; }

    .quick-links { padding: 12px; display: flex; flex-direction: column; gap: 4px; }
    .quick-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 8px;
        color: var(--texto-sub); font-size: 13px; font-weight: 600;
        text-decoration: none; transition: background .15s, color .15s;
    }
    .quick-link:hover { background: var(--azul-light); color: var(--azul); }
    .quick-link i { width: 16px; text-align: center; }

    /* ── Formulario ──────────────────────────── */
    .section-title {
        font-size: 11px; font-weight: 700; color: var(--texto-sub);
        text-transform: uppercase; letter-spacing: .08em;
        margin: 0 0 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .section-title::after {
        content: ''; flex: 1; height: 1px; background: var(--gris-borde);
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-row.full { grid-template-columns: 1fr; }
    .form-group { margin-bottom: 14px; }
    .form-group label {
        display: block; font-size: 13px; font-weight: 700;
        color: var(--texto); margin-bottom: 5px;
    }
    .input-wrap { position: relative; }
    .input-wrap i.icon {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: var(--texto-sub); font-size: 13px;
    }
    .input-wrap input {
        width: 100%; padding: 10px 12px 10px 36px;
        border: 1.5px solid var(--gris-borde); border-radius: 8px;
        font-size: 13px; font-family: 'Nunito', sans-serif;
        color: var(--texto); background: #fff; outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .input-wrap input:focus {
        border-color: var(--azul-mid);
        box-shadow: 0 0 0 3px rgba(44,82,130,.1);
    }
    .input-wrap input.is-invalid { border-color: #ef4444; }
    .error-msg {
        font-size: 11px; color: #ef4444; margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .hint { font-size: 11px; color: var(--texto-sub); margin-top: 4px; }

    .form-actions {
        display: flex; gap: 10px; justify-content: flex-end;
        padding-top: 16px; border-top: 1px solid var(--gris-borde); margin-top: 8px;
    }
    .btn-save {
        padding: 10px 24px; background: var(--naranja); color: #fff;
        border: none; border-radius: 8px; font-size: 14px; font-weight: 700;
        font-family: 'Nunito', sans-serif; cursor: pointer;
        transition: background .2s; display: flex; align-items: center; gap: 8px;
    }
    .btn-save:hover { background: var(--naranja-dk); }

    @media (max-width: 860px) {
        .layout-perfil { grid-template-columns: 1fr; }
    }
    @media (max-width: 520px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="container" style="padding-top:0;padding-bottom:0">
        <h1><i class="fas fa-user-circle"></i> Mi Cuenta</h1>
        <p>Bienvenido, {{ auth()->user()->name }}</p>
    </div>
</div>

<div class="container">
    <div class="layout-perfil">

        {{-- ── Columna lateral ── --}}
        <div>
            {{-- Avatar e info --}}
            <div class="card">
                <div class="avatar-wrap">
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <div>
                        <div class="avatar-name">{{ $user->name }}</div>
                        <div class="avatar-email">{{ $user->email }}</div>
                    </div>
                </div>
                @if($user->direccion)
                    <div class="info-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <div class="label">Dirección</div>
                            <div class="value">{{ $user->direccion }}</div>
                        </div>
                    </div>
                @endif
                @if($user->ciudad)
                    <div class="info-row">
                        <i class="fas fa-city"></i>
                        <div>
                            <div class="label">Ciudad</div>
                            <div class="value">{{ $user->ciudad }}{{ $user->codigo_postal ? ', ' . $user->codigo_postal : '' }}</div>
                        </div>
                    </div>
                @endif
                @if($user->pais)
                    <div class="info-row">
                        <i class="fas fa-globe"></i>
                        <div>
                            <div class="label">País</div>
                            <div class="value">{{ $user->pais }}</div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Acceso rápido --}}
            <div class="card">
                <div class="card-head"><i class="fas fa-bolt"></i><h2>Acceso rápido</h2></div>
                <div class="quick-links">
                    <a href="{{ route('pedidos') }}" class="quick-link">
                        <i class="fas fa-box"></i> Mis Pedidos
                    </a>
                    <a href="{{ route('carrito') }}" class="quick-link">
                        <i class="fas fa-shopping-cart"></i> Mi Carrito
                    </a>
                    <a href="{{ route('catalogo') }}" class="quick-link">
                        <i class="fas fa-store"></i> Nueva Compra
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Columna formulario ── --}}
        <div>
            <div class="card">
                <div class="card-head"><i class="fas fa-pen"></i><h2>Editar Perfil</h2></div>
                <div class="card-body">

                    <form method="POST" action="{{ route('perfil.actualizar') }}">
                        @csrf

                        {{-- Información personal --}}
                        <p class="section-title">Información Personal</p>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre completo</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-user"></i>
                                    <input type="text" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                                </div>
                                @error('name')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-envelope"></i>
                                    <input type="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                                </div>
                                @error('email')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <p class="section-title" style="margin-top:20px">Cambiar Contraseña</p>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nueva contraseña</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-lock"></i>
                                    <input type="password" name="password" placeholder="Dejar vacío para no cambiar">
                                </div>
                                <div class="hint">Mínimo 6 caracteres</div>
                                @error('password')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Confirmar contraseña</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-lock"></i>
                                    <input type="password" name="password_confirmation" placeholder="Repetir contraseña">
                                </div>
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <p class="section-title" style="margin-top:20px">Dirección de Envío</p>
                        <div class="form-row full">
                            <div class="form-group">
                                <label>Calle y número</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-road"></i>
                                    <input type="text" name="direccion"
                                        value="{{ old('direccion', $user->direccion) }}"
                                        placeholder="Ej. Calle Principal #123">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-city"></i>
                                    <input type="text" name="ciudad"
                                        value="{{ old('ciudad', $user->ciudad) }}"
                                        placeholder="Ej. Aguascalientes">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Código Postal</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-map-pin"></i>
                                    <input type="text" name="codigo_postal"
                                        value="{{ old('codigo_postal', $user->codigo_postal) }}"
                                        placeholder="Ej. 20000">
                                </div>
                            </div>
                        </div>
                        <div class="form-row full">
                            <div class="form-group">
                                <label>País</label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-globe"></i>
                                    <input type="text" name="pais"
                                        value="{{ old('pais', $user->pais) }}"
                                        placeholder="Ej. México">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-floppy-disk"></i> Guardar cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
