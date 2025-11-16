<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\ProductoFactura;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with(['cliente', 'usuario', 'productos'])->orderBy('created_at', 'desc');

        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;

            $query->where('id', $busqueda);
        }

        $facturas = $query->paginate(10); // <-- aquí usamos paginate

        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('facturas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'cedula_usuario' => 'required|exists:usuarios,cedula',
            'fecha' => 'required|date_format:Y-m-d H:i',
            'cedula_cliente' => 'required|exists:clientes,cedula',
            'metodo_pago' => 'required|string',
            'monto_recibido' => 'required|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*' => 'string|required'
        ], [
            'fecha.date_format' => 'El formato de la fecha debe ser YYYY-MM-DD HH:mm.',
            'productos.*.required' => 'Debes agregar al menos un producto.',
            'productos.*.string' => 'El formato de los productos es inválido.'
        ]);

        DB::beginTransaction();

        try {
            $iva = 0.15;

            $factura = new Factura();
            $factura->cedula_usuario = $request->cedula_usuario;
            $factura->fecha = \Carbon\Carbon::parse($request->fecha)->setTimezone('America/Managua');
            $factura->cedula_cliente = $request->cedula_cliente;
            $factura->metodo_pago = $request->metodo_pago;
            $factura->monto_recibido = $request->monto_recibido;

            $suma = 0;
            $detalles = [];

            foreach ($request->productos as $prodString) {
                $parts = explode('|', $prodString);
                if (count($parts) !== 5) {
                    throw new \Exception("Formato inválido en productos: $prodString");
                }

                list($productoId, $cantidad, $precio, $descuento, $subtotal) = $parts;

                $cantidad = (float)$cantidad;
                $precio = (float)$precio;
                $descuento = (float)$descuento ?: 0;
                $subtotalCalculado = $cantidad * $precio * (1 - $descuento / 100);
                $subtotal = round($subtotalCalculado, 2);

                if (abs($subtotal - $subtotalCalculado) > 0.01) {
                    throw new \Exception("Subtotal calculado no coincide con el proporcionado para producto ID: $productoId");
                }

                $producto = Producto::findOrFail($productoId);
                if ($producto->stock < $cantidad) {
                    throw new \Exception("No hay stock suficiente para el producto: {$producto->nombre}");
                }

                $suma += $subtotal;

                $detalles[] = [
                    'producto_id' => $productoId,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'descuento' => $descuento,
                    'subtotal' => $subtotal
                ];
            }

            $ivaCalculado = $suma * $iva;
            $total = $suma + $ivaCalculado;

            if ($request->monto_recibido < $total) {
                throw new \Exception("El monto recibido ($request->monto_recibido) es menor que el total a pagar ($total).");
            }

            $factura->subtotal = $suma;
            $factura->iva = $ivaCalculado;
            $factura->total = $total;

            $vuelto = $request->monto_recibido - $total;
            $factura->vuelto = $vuelto >= 0 ? $vuelto : 0;

            $factura->save();

            foreach ($detalles as $detalle) {
                $detalleFactura = new ProductoFactura();
                $detalleFactura->factura_id = $factura->id;
                $detalleFactura->producto_id = $detalle['producto_id'];
                $detalleFactura->cantidad = $detalle['cantidad'];
                $detalleFactura->precio = $detalle['precio'];
                $detalleFactura->descuento = $detalle['descuento'];
                $detalleFactura->subtotal = $detalle['subtotal'];
                $detalleFactura->save();

                $producto = Producto::find($detalle['producto_id']);
                $producto->stock -= $detalle['cantidad'];
                $producto->save();
            }

            DB::commit();

            return redirect()->route('facturas.show', $factura->id)
                ->with('success', 'Factura emitida correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al emitir factura: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return back()->withErrors(['error' => 'Error al emitir factura: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $factura = Factura::with(['cliente', 'usuario', 'productos'])->findOrFail($id);
        $subtotal = $factura->productos->sum('pivot.subtotal');
        return view('facturas.show', compact('factura', 'subtotal'));
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada correctamente.');
    }

    public function exportarPDF($id)
    {
        $factura = Factura::with(['cliente', 'usuario', 'productos'])->findOrFail($id);
        $subtotal = $factura->productos->sum('pivot.subtotal');
        $pdf = Pdf::loadView('facturas.pdf', compact('factura', 'subtotal'));
        return $pdf->stream("factura_{$factura->id}.pdf");
    }

}
