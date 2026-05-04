<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta — Tienda de Abarrotes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --azul:     #1e3a5f;
            --azul-mid: #2c5282;
            --naranja:  #e85d04;
            --naranja-dk: #c44d00;
            --gris-bg:  #f4f6f9;
            --gris-borde: #dde3ec;
            --texto:    #1a202c;
            --texto-sub: #64748b;
        }
        body {
            font-family: 'Nunito', sans-serif;
            background: var(--gris-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .register-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(30,58,95,.12);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
        }

        .card-header {
            background: var(--azul);
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .card-header .logo {
            width: 48px; height: 48px;
            background: var(--naranja);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 20px;
        }
        .card-header h1 {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
        }
        .card-header p {
            color: rgba(255,255,255,.6);
            font-size: 13px;
        }

        .card-body {
            padding: 32px;
        }

        /* Secciones del formulario */
        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--azul);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ebf4ff;
        }
        .section-title i { color: var(--naranja); }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .form-row.full { grid-template-columns: 1fr; }

        .form-group {
            margin-bottom: 14px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--texto);
            margin-bottom: 5px;
        }
        .form-group label .req { color: var(--naranja); }

        .input-wrap { position: relative; }
        .input-wrap i.icon {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--texto-sub);
            font-size: 13px;
        }
        .input-wrap input,
        .input-wrap select {
            width: 100%;
            padding: 10px 12px 10px 36px;
            border: 1.5px solid var(--gris-borde);
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Nunito', sans-serif;
            color: var(--texto);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrap input:focus,
        .input-wrap select:focus {
            border-color: var(--azul-mid);
            box-shadow: 0 0 0 3px rgba(44,82,130,.1);
        }
        .input-wrap input.is-invalid { border-color: #ef4444; }

        .error-msg {
            font-size: 11px;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .section-sep { margin: 20px 0; }

        .optional-badge {
            background: #f0f9ff;
            color: #0369a1;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .note-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #92400e;
            margin-bottom: 20px;
        }
        .note-box strong { font-weight: 700; }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--naranja);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }
        .btn-submit:hover { background: var(--naranja-dk); }
        .btn-submit:active { transform: scale(.98); }

        .form-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: var(--texto-sub);
        }
        .form-footer a {
            color: var(--naranja);
            font-weight: 700;
            text-decoration: none;
        }
        .form-footer a:hover { text-decoration: underline; }

        @media (max-width: 520px) {
            .form-row { grid-template-columns: 1fr; }
            .card-body { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="card-header">
        <div class="logo"><i class="fas fa-user-plus"></i></div>
        <div>
            <h1>Crear Cuenta</h1>
            <p>Complete el formulario para registrarse</p>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- ── Información personal ── --}}
            <div class="section-title">
                <i class="fas fa-user"></i> Información Personal
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Nombre completo <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="icon fas fa-user"></i>
                        <input type="text" name="name" placeholder="Ej. Juan Pérez"
                            value="{{ old('name') }}"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                    </div>
                    @error('name')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Correo electrónico <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="icon fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="correo@ejemplo.com"
                            value="{{ old('email') }}"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    </div>
                    @error('email')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                </div>
            </div>

            {{-- ── Seguridad ── --}}
            <div class="section-sep">
                <div class="section-title">
                    <i class="fas fa-lock"></i> Seguridad
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Contraseña <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="icon fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mínimo 6 caracteres"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    </div>
                    @error('password')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Confirmar contraseña <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="icon fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Repita su contraseña">
                    </div>
                </div>
            </div>

            {{-- ── Dirección ── --}}
            <div class="section-sep">
                <div class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Dirección de Envío
                    <span class="optional-badge">Opcional</span>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Calle y número</label>
                    <div class="input-wrap">
                        <i class="icon fas fa-road"></i>
                        <input type="text" name="direccion" placeholder="Ej. Calle Principal #123"
                            value="{{ old('direccion') }}">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ciudad</label>
                    <div class="input-wrap">
                        <i class="icon fas fa-city"></i>
                        <input type="text" name="ciudad" placeholder="Ej. Aguascalientes"
                            value="{{ old('ciudad') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Código Postal</label>
                    <div class="input-wrap">
                        <i class="icon fas fa-map-pin"></i>
                        <input type="text" name="codigo_postal" placeholder="Ej. 20000"
                            value="{{ old('codigo_postal') }}">
                    </div>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>País</label>
                    <div class="input-wrap">
                        <i class="icon fas fa-globe"></i>
                        <input type="text" name="pais" placeholder="Ej. México"
                            value="{{ old('pais', 'México') }}">
                    </div>
                </div>
            </div>

            <div class="note-box">
                <strong>Nota:</strong> Los campos marcados con <strong>*</strong> son obligatorios.
                Tu información se almacena de forma segura.
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Crear cuenta
            </button>
        </form>

        <div class="form-footer">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>
    </div>
</div>

</body>
</html>
