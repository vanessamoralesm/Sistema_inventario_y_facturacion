<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Producto::insert([
            [
                'nombre' => 'Pantalón',
                'detalle' => 'Algodón',
                'stock' => 10,
                'talla' => '6', // Niño
                'tipo' => 'niño',
                'color' => 'Azul',
                'marca' => 'Polo',
                'precio_venta' => 700.00,
                'precio_compra' => 420.00,
                'ganancia' => 280.00,
                'imagen' => 'IMG/pantalon.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Camisa',
                'detalle' => 'Algodón',
                'stock' => 20,
                'talla' => 'XL', // Adulto
                'tipo' => 'mujer',
                'color' => 'Rojo',
                'marca' => 'Nike',
                'precio_venta' => 300.00,
                'precio_compra' => 180.00,
                'ganancia' => 120.00,
                'imagen' => 'IMG/camisa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Vestido niña',
                'detalle' => 'Seda',
                'stock' => 15,
                'talla' => '8', // Niño
                'tipo' => 'niña',
                'color' => 'Rosado',
                'marca' => 'Zara',
                'precio_venta' => 450.00,
                'precio_compra' => 270.00,
                'ganancia' => 180.00,
                'imagen' => 'IMG/vestido_nina.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Chaqueta',
                'detalle' => 'Cuero sintético',
                'stock' => 5,
                'talla' => 'M', // Adulto
                'tipo' => 'hombre',
                'color' => 'Negro',
                'marca' => 'Adidas',
                'precio_venta' => 1200.00,
                'precio_compra' => 720.00,
                'ganancia' => 480.00,
                'imagen' => 'IMG/chaqueta.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Blusa',
                'detalle' => 'Poliéster',
                'stock' => 30,
                'talla' => 'S', // Adulto
                'tipo' => 'mujer',
                'color' => 'Blanco',
                'marca' => 'Forever 21',
                'precio_venta' => 250.00,
                'precio_compra' => 150.00,
                'ganancia' => 100.00,
                'imagen' => 'IMG/blusa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Jeans',
                'detalle' => 'Mezclilla',
                'stock' => 12,
                'talla' => '32', // adulto
                'tipo' => 'hombre',
                'color' => 'Marrón',
                'marca' => 'Levis',
                'precio_venta' => 800.00,
                'precio_compra' => 480.00,
                'ganancia' => 320.00,
                'imagen' => 'IMG/jeans.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Falda',
                'detalle' => 'Algodón',
                'stock' => 18,
                'talla' => 'L', // Adulto
                'tipo' => 'mujer',
                'color' => 'Amarillo',
                'marca' => 'Mango',
                'precio_venta' => 350.00,
                'precio_compra' => 210.00,
                'ganancia' => 140.00,
                'imagen' => 'IMG/falda.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Suéter niño',
                'detalle' => 'Lana',
                'stock' => 8,
                'talla' => '10', // Niño
                'tipo' => 'niño',
                'color' => 'Gris',
                'marca' => 'Old Navy',
                'precio_venta' => 400.00,
                'precio_compra' => 240.00,
                'ganancia' => 160.00,
                'imagen' => 'IMG/sweater_nino.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pijama mujer',
                'detalle' => 'Algodón suave',
                'stock' => 22,
                'talla' => 'XXL', // Adulto
                'tipo' => 'mujer',
                'color' => 'Celeste',
                'marca' => 'Victorias Secret',
                'precio_venta' => 500.00,
                'precio_compra' => 300.00,
                'ganancia' => 200.00,
                'imagen' => 'IMG/pijama_mujer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
