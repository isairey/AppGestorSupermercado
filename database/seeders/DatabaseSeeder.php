<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Usuarios ─────────────────────────────────
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'rol'      => 'admin',
        ]);

        User::create([
            'name'          => 'Juan Cliente',
            'email'         => 'cliente@example.com',
            'password'      => Hash::make('cliente123'),
            'rol'           => 'cliente',
            'direccion'     => 'Calle Principal #123',
            'ciudad'        => 'Aguascalientes',
            'codigo_postal' => '20000',
            'pais'          => 'México',
        ]);

        // ── Categorías ───────────────────────────────
        $categorias = [
            ['nombre' => 'Lácteos',         'descripcion' => 'Leche, queso, yogurt y derivados'],
            ['nombre' => 'Panadería',        'descripcion' => 'Pan, tortillas y productos de harina'],
            ['nombre' => 'Granos',           'descripcion' => 'Arroz, frijol, lenteja y cereales'],
            ['nombre' => 'Aceites',          'descripcion' => 'Aceites y grasas vegetales'],
            ['nombre' => 'Condimentos',      'descripcion' => 'Sal, especias y aderezos'],
            ['nombre' => 'Enlatados',        'descripcion' => 'Conservas y productos enlatados'],
            ['nombre' => 'Bebidas',          'descripcion' => 'Agua, refrescos y jugos'],
            ['nombre' => 'Limpieza',         'descripcion' => 'Productos de limpieza del hogar'],
            ['nombre' => 'Higiene Personal', 'descripcion' => 'Jabón, shampoo y cuidado personal'],
            ['nombre' => 'Snacks',           'descripcion' => 'Botanas, galletas y golosinas'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }

        // ── Productos ────────────────────────────────
        $productos = [
            ['nombre' => 'Leche Entera 1 Litro',      'descripcion' => 'Leche fresca entera pasteurizada.', 'precio' => 24.50, 'stock' => 80,  'categoria_id' => 1],
            ['nombre' => 'Yogurt Natural 1L',          'descripcion' => 'Yogurt natural cremoso.',           'precio' => 38.00, 'stock' => 40,  'categoria_id' => 1],
            ['nombre' => 'Huevos Blancos (12 piezas)', 'descripcion' => 'Huevos frescos de granja.',         'precio' => 52.00, 'stock' => 60,  'categoria_id' => 1],
            ['nombre' => 'Pan Blanco Integral',        'descripcion' => 'Pan de caja integral 680g.',        'precio' => 32.00, 'stock' => 35,  'categoria_id' => 2],
            ['nombre' => 'Tortillas de Maíz 1kg',      'descripcion' => 'Tortillas artesanales frescas.',    'precio' => 18.00, 'stock' => 50,  'categoria_id' => 2],
            ['nombre' => 'Arroz Blanco 1 Kg',          'descripcion' => 'Arroz de grano largo.',             'precio' => 28.00, 'stock' => 120, 'categoria_id' => 3],
            ['nombre' => 'Frijol Negro 1kg',           'descripcion' => 'Frijol negro seleccionado.',        'precio' => 30.00, 'stock' => 90,  'categoria_id' => 3],
            ['nombre' => 'Aceite Vegetal 1L',          'descripcion' => 'Aceite vegetal puro.',              'precio' => 45.00, 'stock' => 55,  'categoria_id' => 4],
            ['nombre' => 'Sal de Mesa 1kg',            'descripcion' => 'Sal yodada refinada.',              'precio' => 15.50, 'stock' => 8,   'categoria_id' => 5],
            ['nombre' => 'Azúcar Refinada 1kg',        'descripcion' => 'Azúcar blanca refinada de caña.',  'precio' => 27.00, 'stock' => 200, 'categoria_id' => 5],
            ['nombre' => 'Salsa de Tomate 400g',       'descripcion' => 'Salsa de tomate natural.',          'precio' => 22.00, 'stock' => 45,  'categoria_id' => 6],
            ['nombre' => 'Atún en Agua 140g',          'descripcion' => 'Atún en agua bajo en grasa.',       'precio' => 19.00, 'stock' => 80,  'categoria_id' => 6],
            ['nombre' => 'Agua Purificada 1.5L',       'descripcion' => 'Agua purificada en botella.',       'precio' => 14.00, 'stock' => 100, 'categoria_id' => 7],
            ['nombre' => 'Jugo de Naranja 1L',         'descripcion' => 'Jugo 100% natural sin azúcar.',    'precio' => 29.00, 'stock' => 30,  'categoria_id' => 7],
            ['nombre' => 'Detergente Líquido 3L',      'descripcion' => 'Detergente concentrado para ropa.','precio' => 95.00, 'stock' => 20,  'categoria_id' => 8],
            ['nombre' => 'Papel Higiénico 12 Rollos',  'descripcion' => 'Papel higiénico doble hoja.',       'precio' => 85.00, 'stock' => 5,   'categoria_id' => 8],
            ['nombre' => 'Shampoo 400ml',              'descripcion' => 'Shampoo para todo tipo de cabello.','precio' => 55.00, 'stock' => 35,  'categoria_id' => 9],
            ['nombre' => 'Galletas Integrales 200g',   'descripcion' => 'Galletas integrales de avena.',     'precio' => 24.00, 'stock' => 60,  'categoria_id' => 10],
        ];

        foreach ($productos as $prod) {
            Producto::create($prod);
        }
    }
}
