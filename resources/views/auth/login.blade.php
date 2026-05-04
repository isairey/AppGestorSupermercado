<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — Tienda de Abarrotes</title>
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
            align-items: stretch;
        }

        /* Panel izquierdo decorativo */
        .panel-left {
            width: 45%;
            background: var(--azul);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(232,93,4,.15);
        }
        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .panel-left .logo {
            width: 72px; height: 72px;
            background: var(--naranja);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: #fff;
            margin-bottom: 24px;
            position: relative; z-index: 1;
        }
        .panel-left h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            text-align: center;
            position: relative; z-index: 1;
            margin-bottom: 10px;
        }
        .panel-left p {
            color: rgba(255,255,255,.6);
            font-size: 14px;
            text-align: center;
            position: relative; z-index: 1;
            line-height: 1.7;
            max-width: 280px;
        }
        .feature-list {
            margin-top: 36px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            position: relative; z-index: 1;
            width: 100%;
            max-width: 300px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.8);
            font-size: 13px;
            font-weight: 600;
        }
        .feature-item .fi-icon {
            width: 32px; height: 32px;
            background: rgba(255,255,255,.12);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--naranja);
            font-size: 13px;
            flex-shrink: 0;
        }

        /* Panel derecho — formulario */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
        }
        .form-card {
            width: 100%;
            max-width: 420px;
        }
        .form-card h2 {
            font-size: 24px;
            font-weight: 800;
            color: var(--azul);
            margin-bottom: 6px;
        }
        .form-card .subtitle {
            font-size: 14px;
            color: var(--texto-sub);
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--texto);
            margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--texto-sub);
            font-size: 14px;
        }
        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--gris-borde);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            color: var(--texto);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-wrap input:focus {
            border-color: var(--azul-mid);
            box-shadow: 0 0 0 3px rgba(44,82,130,.1);
        }
        .input-wrap input.is-invalid { border-color: #ef4444; }

        .error-msg {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

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
            margin-top: 8px;
        }
        .btn-submit:hover { background: var(--naranja-dk); }
        .btn-submit:active { transform: scale(.98); }

        .form-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: var(--texto-sub);
        }
        .form-footer a {
            color: var(--naranja);
            font-weight: 700;
            text-decoration: none;
        }
        .form-footer a:hover { text-decoration: underline; }

        .demo-box {
            background: #f0f7ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 12px;
            color: #1e40af;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        .demo-box strong { font-weight: 700; }

        @media (max-width: 768px) {
            .panel-left { display: none; }
        }
    </style>
</head>
<body>

<div class="panel-left">
    <div class="logo"><i class="fas fa-store"></i></div>
    <h1>Tienda de Abarrotes</h1>
    <p>El Buen Precio — Tu tienda de confianza con todo lo que necesitas</p>
    <div class="feature-list">
        <div class="feature-item">
            <div class="fi-icon"><i class="fas fa-boxes"></i></div>
            Más de 200 productos disponibles
        </div>
        <div class="feature-item">
            <div class="fi-icon"><i class="fas fa-truck"></i></div>
            Gestión de pedidos en tiempo real
        </div>
        <div class="feature-item">
            <div class="fi-icon"><i class="fas fa-shield-alt"></i></div>
            Sistema seguro y confiable
        </div>
    </div>
</div>

<div class="panel-right">
    <div class="form-card">
        <h2>Bienvenido de nuevo</h2>
        <p class="subtitle">Ingresa tus credenciales para continuar</p>

        {{-- Usuarios de demostración --}}
        <div class="demo-box">
            <strong>Usuarios de prueba:</strong><br>
            Admin: <strong>admin@example.com</strong> / admin123<br>
            Cliente: <strong>cliente@example.com</strong> / cliente123
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="correo@ejemplo.com"
                        value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        autocomplete="email"
                    >
                </div>
                @error('email')
                    <div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        autocomplete="current-password"
                    >
                </div>
                @error('password')
                    <div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Iniciar sesión
            </button>
        </form>

        <div class="form-footer">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
        </div>
    </div>
</div>

</body>
</html>
