<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
use App\Models\ProductoFactura;


class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre', 'marca', 'tipo', 'talla',
        'color', 'detalle', 'precio','stock',
        'precio_venta', 'precio_compra', 'ganancia', 'imagen',
    ];

    public function facturas()
    {
        return $this->belongsToMany(Factura::class, 'producto_factura', 'producto_id', 'factura_id')
                    ->withPivot('cantidad', 'precio', 'descuento', 'subtotal')
                    ->withTimestamps();
    }

}
