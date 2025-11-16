<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        // Ventas del día
        $ventasHoy = Factura::whereDate('fecha', $hoy)->sum('total');

        // Facturas emitidas hoy
        $facturasHoy = Factura::whereDate('fecha', $hoy)->count();

        // Totales generales
        $totalClientes = Cliente::count();
        $totalProductos = Producto::count();

        return view('dashboard', compact(
            'ventasHoy',
            'facturasHoy',
            'totalClientes',
            'totalProductos'
        ));
    }
}
