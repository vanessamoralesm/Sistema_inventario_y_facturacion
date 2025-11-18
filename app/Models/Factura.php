<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\ProductoFactura;


class Factura extends Model
{
    protected $fillable = [
        'cedula_usuario', 'fecha', 'cedula_cliente', 'metodo_pago',
        'monto_recibido', 'subtotal','iva', 'total', 'vuelto'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cedula_cliente', 'cedula');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cedula_usuario', 'cedula');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_factura', 'factura_id', 'producto_id')
                    ->withPivot('cantidad', 'descuento', 'subtotal')
                    ->withTimestamps();
    }
}