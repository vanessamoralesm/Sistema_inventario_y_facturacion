<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Factura;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Fecha de hoy
        $hoy = Carbon::today();

        // Total vendido hoy
        $ventasHoy = Factura::whereDate('created_at', $hoy)
            ->sum('total');

        // Número de facturas hoy
        $totalFacturasHoy = Factura::whereDate('created_at', $hoy)
            ->count();

        // Ventas de los últimos 7 días
        $labels = [];
        $data = [];

        for ($i = 6 ;$i >= 0; $i--) {
            $dia = Carbon::now('America/Managua')->subDays($i);
            $labels[] = $dia->format('d/m');

            $data[] = Factura::whereDate('created_at', $dia)
                ->sum('total');
        }

        return view('estadisticas.index', compact(
            'ventasHoy',
            'totalFacturasHoy',
            'labels',
            'data'
        ));
    }
}
