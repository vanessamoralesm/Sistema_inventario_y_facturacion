<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);   // antes 255
            $table->string('marca', 100);
            $table->string('tipo', 50);      // ej. Niño, Niña, Hombre, Mujer
            $table->string('talla', 10);     // ej. S, M, L, 4, 6, etc.
            $table->string('color', 50);     // ej. Rojo, Azul, Negro, etc.

            $table->decimal('precio', 10, 2);
            $table->text('detalle');
            $table->integer('stock');

            $table->decimal('precio_venta', 10, 2);
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('ganancia', 10, 2);
            $table->string('imagen');

            $table->timestamps();
            $table->unique(['nombre', 'marca', 'tipo', 'talla', 'color']);
        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
