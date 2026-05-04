@extends('layouts.app')

@section('title', isset($producto) ? 'Editar Producto' : 'Agregar Producto')

@push('styles')
<style>
    .layout-admin { display: flex; min-height: calc(100vh - 62px); }
    .sidebar {
        width: 220px; background: var(--azul); padding: 20px 12px;
        flex-shrink: 0; position: sticky; top: 62px;
        height: calc(100vh - 62px); overflow-y: auto;
    }
    .sidebar-brand { padding: 8px 10px 16px; border-bottom: 1px solid rgba(255,255,255,.1); margin-bottom: 12px; }
    .sidebar-brand span { font-size: 11px; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .08em; }
    .sidebar-link {
        display: flex; align-items: center; gap: 10px; padding: 9px 12px;
        border-radius: 8px; color: rgba(255,255,255,.7); text-decoration: none;
        font-size: 13px; font-weight: 600; transition: background .15s, color .15s; margin-bottom: 2px;
    }
    .sidebar-link:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sidebar-link.active { background: var(--naranja); color: #fff; }
    .sidebar-link i { width: 16px; text-align: center; font-size: 13px; }

    .main { flex: 1; padding: 28px 32px; }

    /* ── Breadcrumb ──────────────────────────── */
    .breadcrumb {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--texto-sub); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--naranja); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb i { font-size: 10px; }

    .page-title { font-size: 22px; font-weight: 800; color: var(--azul); margin-bottom: 4px; }
    .page-sub   { font-size: 13px; color: var(--texto-sub); margin-bottom: 24px; }

    /* ── Layout formulario ───────────────────── */
    .form-layout {
        display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;
    }

    .card { background: #fff; border-radius: 14px; box-shadow: 0 2px 8px rgba(30,58,95,.07); overflow: hidden; }
    .card-head { padding: 16px 20px; border-bottom: 1px solid var(--gris-borde); display: flex; align-items: center; gap: 10px; }
    .card-head h2 { font-size: 15px; font-weight: 700; color: var(--azul); }
    .card-head i { color: var(--naranja); }
    .card-body { padding: 20px; }

    /* ── Campos ──────────────────────────────── */
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 700; color: var(--texto); margin-bottom: 5px; }
    .form-group label .req { color: var(--naranja); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .input-wrap { position: relative; }
    .input-wrap i.icon {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: var(--texto-sub); font-size: 13px;
    }
    .input-wrap input,
    .input-wrap select,
    .input-wrap textarea {
        width: 100%; padding: 10px 12px 10px 36px;
        border: 1.5px solid var(--gris-borde); border-radius: 8px;
        font-size: 13px; font-family: 'Nunito', sans-serif;
        color: var(--texto); background: #fff; outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .input-wrap textarea { padding-top: 10px; resize: vertical; min-height: 90px; }
    .input-wrap input:focus,
    .input-wrap select:focus,
    .input-wrap textarea:focus {
        border-color: var(--azul-mid); box-shadow: 0 0 0 3px rgba(44,82,130,.1);
    }
    .input-wrap input.is-invalid,
    .input-wrap select.is-invalid { border-color: #ef4444; }
    .error-msg { font-size: 11px; color: #ef4444; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

    /* ── Upload imagen ───────────────────────── */
    .upload-zone {
        border: 2px dashed var(--gris-borde); border-radius: 10px;
        padding: 28px 16px; text-align: center; cursor: pointer;
        transition: border-color .2s, background .2s;
    }
    .upload-zone:hover { border-color: var(--naranja); background: #fff8f5; }
    .upload-zone i { font-size: 28px; color: #cbd5e0; margin-bottom: 10px; }
    .upload-zone p { font-size: 13px; color: var(--texto-sub); }
    .upload-zone small { font-size: 11px; color: #a0aec0; }
    .upload-zone input { display: none; }

    #preview-wrap { margin-top: 12px; display: none; }
    #preview-wrap img {
        width: 100%; max-height: 180px; object-fit: cover;
        border-radius: 8px; border: 1px solid var(--gris-borde);
    }
    #preview-wrap.show { display: block; }

    /* ── Nota ────────────────────────────────── */
    .info-box {
        background: #f0f7ff; border: 1px solid #bfdbfe; border-radius: 8px;
        padding: 12px 14px; font-size: 12px; color: #1e40af;
        display: flex; gap: 8px; align-items: flex-start;
    }
    .info-box i { margin-top: 1px; flex-shrink: 0; }

    /* ── Acciones ────────────────────────────── */
    .form-actions {
        display: flex; gap: 10px; justify-content: flex-end;
        padding-top: 16px; border-top: 1px solid var(--gris-borde);
    }
    .btn-save {
        padding: 10px 24px; background: var(--naranja); color: #fff; border: none;
        border-radius: 8px; font-size: 14px; font-weight: 700;
        font-family: 'Nunito', sans-serif; cursor: pointer; transition: background .2s;
        display: flex; align-items: center; gap: 8px;
    }
    .btn-save:hover { background: var(--naranja-dk); }
    .btn-cancel {
        padding: 10px 20px; background: none; color: var(--texto-sub);
        border: 1.5px solid var(--gris-borde); border-radius: 8px;
        font-size: 14px; font-weight: 700; font-family: 'Nunito', sans-serif;
        cursor: pointer; text-decoration: none; transition: background .2s;
        display: flex; align-items: center; gap: 8px;
    }
    .btn-cancel:hover { background: var(--gris-bg); }

    @media (max-width: 900px) {
        .form-layout { grid-template-columns: 1fr; }
        .form-row    { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="layout-admin">

    <aside class="sidebar">
        <div class="sidebar-brand"><span>Panel Admin</span></div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="{{ route('admin.productos.index') }}" class="sidebar-link active"><i class="fas fa-boxes"></i> Gestión de Productos</a>
        <a href="{{ route('admin.reportes') }}" class="sidebar-link"><i class="fas fa-file-alt"></i> Reportes</a>
    </aside>

    <main class="main">
        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('admin.productos.index') }}">Productos</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ isset($producto) ? 'Editar Producto' : 'Agregar Producto' }}</span>
        </div>

        <div class="page-title">{{ isset($producto) ? 'Editar Producto' : 'Agregar Producto' }}</div>
        <div class="page-sub">{{ isset($producto) ? 'Modifica los campos necesarios para actualizar el producto.' : 'Completa la información del producto.' }}</div>

        @php
            $action = isset($producto)
                ? route('admin.productos.update', $producto->id)
                : route('admin.productos.store');
        @endphp

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if(isset($producto)) @method('PUT') @endif

            <div class="form-layout">

                {{-- Columna principal --}}
                <div class="card">
                    <div class="card-head">
                        <i class="fas fa-box"></i>
                        <h2>Información del Producto</h2>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>Nombre del producto <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="icon fas fa-tag"></i>
                                <input type="text" name="nombre"
                                    value="{{ old('nombre', $producto->nombre ?? '') }}"
                                    placeholder="Ej. Arroz Blanco 1kg"
                                    class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}">
                            </div>
                            @error('nombre')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Categoría <span class="req">*</span></label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-folder"></i>
                                    <select name="categoria_id" class="{{ $errors->has('categoria_id') ? 'is-invalid' : '' }}">
                                        <option value="">Seleccionar...</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('categoria_id', $producto->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('categoria_id')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Stock <span class="req">*</span></label>
                                <div class="input-wrap">
                                    <i class="icon fas fa-cubes"></i>
                                    <input type="number" name="stock" min="0"
                                        value="{{ old('stock', $producto->stock ?? '') }}"
                                        placeholder="0"
                                        class="{{ $errors->has('stock') ? 'is-invalid' : '' }}">
                                </div>
                                @error('stock')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Precio <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="icon fas fa-dollar-sign"></i>
                                <input type="number" name="precio" min="0" step="0.01"
                                    value="{{ old('precio', $producto->precio ?? '') }}"
                                    placeholder="0.00"
                                    class="{{ $errors->has('precio') ? 'is-invalid' : '' }}">
                            </div>
                            @error('precio')<div class="error-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Descripción</label>
                            <div class="input-wrap">
                                <i class="icon fas fa-align-left" style="top:14px;transform:none"></i>
                                <textarea name="descripcion" placeholder="Descripción breve del producto...">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="info-box">
                            <i class="fas fa-circle-info"></i>
                            <span>Los campos marcados con <strong>*</strong> son obligatorios. La imagen del producto es opcional pero recomendada.</span>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.productos.index') }}" class="btn-cancel">
                                <i class="fas fa-xmark"></i> Cancelar
                            </a>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-floppy-disk"></i>
                                {{ isset($producto) ? 'Guardar cambios' : 'Guardar producto' }}
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Columna imagen --}}
                <div class="card">
                    <div class="card-head">
                        <i class="fas fa-image"></i>
                        <h2>Imagen del Producto</h2>
                    </div>
                    <div class="card-body">

                        {{-- Preview imagen actual --}}
                        @if(isset($producto) && $producto->imagen)
                            <div style="margin-bottom:12px">
                                <p style="font-size:12px;color:var(--texto-sub);margin-bottom:6px">Imagen actual:</p>
                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                    alt="{{ $producto->nombre }}"
                                    style="width:100%;max-height:160px;object-fit:cover;border-radius:8px;border:1px solid var(--gris-borde)">
                            </div>
                        @endif

                        <label class="upload-zone" for="imagen-input">
                            <i class="fas fa-cloud-arrow-up"></i>
                            <p>Haz clic para subir una imagen</p>
                            <small>PNG, JPG hasta 2MB</small>
                            <input type="file" name="imagen" id="imagen-input" accept="image/*" onchange="previewImagen(this)">
                        </label>

                        <div id="preview-wrap">
                            <p style="font-size:12px;color:var(--texto-sub);margin-bottom:6px;margin-top:12px">Nueva imagen:</p>
                            <img id="preview-img" src="" alt="Preview">
                        </div>

                        @error('imagen')<div class="error-msg" style="margin-top:8px"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>

            </div>
        </form>
    </main>
</div>
@endsection

@push('scripts')
<script>
function previewImagen(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-wrap').classList.add('show');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
