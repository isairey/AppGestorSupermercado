<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🛒 Gestor de Supermercado — Laravel

Sistema web desarrollado en **Laravel** para la administración integral de supermercados, permitiendo gestionar productos, inventario, ventas, proveedores y usuarios desde una plataforma centralizada.

---

## 🚀 Descripción

El **Gestor de Supermercado** es una aplicación diseñada para optimizar las operaciones comerciales dentro de un supermercado o tienda, facilitando el control de inventario, registro de ventas y gestión de recursos.

El sistema permite automatizar procesos clave, reducir errores manuales y mejorar la toma de decisiones mediante reportes en tiempo real.

---

## 🎯 Características principales

* 📦 **Gestión de productos**

  * Registro, edición y eliminación
  * Control de precios y categorías

* 🏷️ **Inventario**

  * Control de stock en tiempo real
  * Alertas de productos bajos

* 🧾 **Ventas**

  * Registro de ventas
  * Generación de tickets
  * Historial de transacciones

* 🚚 **Proveedores**

  * Registro y gestión de proveedores
  * Control de compras

* 👤 **Usuarios y roles**

  * Administrador
  * Cajero
  * Empleado
  * Control de permisos

* 📊 **Reportes**

  * Ventas por día, semana o mes
  * Productos más vendidos
  * Control financiero básico

* 🔐 **Autenticación**

  * Login seguro
  * Protección de rutas

---

## 🛠️ Tecnologías utilizadas

* 🧠 **Laravel (PHP)**
* 🎨 Blade, HTML5, CSS3, JavaScript
* 🗄️ MySQL
* ⚙️ Eloquent ORM
* 🔐 Middleware de autenticación

---

## 📂 Estructura del proyecto

```bash id="p9x2lm"
app/
│
├── Models/
├── Http/
│   ├── Controllers/
│   └── Middleware/
│
resources/
├── views/
│   └── layouts/
│
routes/
│   └── web.php
│
database/
│   ├── migrations/
│   └── seeders/
│
public/
└── README.md
```

---

## ⚙️ Instalación

1. Clonar el repositorio:

```bash id="t3r8sa"
git clone https://github.com/isairey/AppGestorSupermercado.git
```

2. Acceder al proyecto:

```bash id="z1k6bd"
cd AppGestorSupermercado
```

3. Instalar dependencias:

```bash id="m4n7op"
composer install
npm install
```

4. Configurar variables de entorno:

```bash id="x8q2wr"
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en `.env`

6. Ejecutar migraciones:

```bash id="j9v3el"
php artisan migrate --seed
```

7. Iniciar servidor:

```bash id="h5u1cs"
php artisan serve
```

8. Acceder desde:

```bash id="b2d7xy"
http://localhost:8000
```

---

## 🧪 Uso del sistema

1. Iniciar sesión en el sistema
2. Registrar productos y categorías
3. Gestionar inventario
4. Realizar ventas
5. Consultar reportes

---

## 📈 Objetivo del proyecto

Brindar una solución eficiente para la administración de supermercados, mejorando la organización interna y optimizando el control de ventas e inventario.

---

## 🔮 Mejoras futuras

* Integración con lectores de código de barras
* Facturación electrónica
* Reportes gráficos avanzados
* Sistema de promociones y descuentos
* API REST para integración externa

---

## 👨‍💻 Autor

**Isai Reyes**
Desarrollador enfocado en sistemas empresariales y soluciones web 🚀

---

## 📜 Licencia

Proyecto de uso libre para fines educativos y comerciales.

