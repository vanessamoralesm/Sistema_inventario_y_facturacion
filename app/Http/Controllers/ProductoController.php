<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    // Mostrar lista de productos con búsqueda
    public function index(Request $request)
    {
        // Empezamos la consulta
        $query = Producto::query();

        // Verificamos si hay un término de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            // Agrupamos las condiciones de búsqueda
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                ->orWhere('marca', 'LIKE', "%{$searchTerm}%")
                ->orWhere('tipo', 'LIKE', "%{$searchTerm}%")
                ->orWhere('talla', 'LIKE', "%{$searchTerm}%")
                ->orWhere('color', 'LIKE', "%{$searchTerm}%")
                ->orWhere('detalle', 'LIKE', "%{$searchTerm}%")
                ->orWhere('precio', 'LIKE', "%{$searchTerm}%")
                ->orWhere('stock', 'LIKE', "%{$searchTerm}%")
                ->orWhere('precio_venta', 'LIKE', "%{$searchTerm}%")
                ->orWhere('precio_compra', 'LIKE', "%{$searchTerm}%")
                ->orWhere('ganancia', 'LIKE', "%{$searchTerm}%")
                ->orWhere('id', $searchTerm); // Permite buscar por ID exacto
            });
        }

        // Obtenemos los productos ordenados y paginados
        $productos = $query->latest()->paginate(10);

        // Retornamos la vista con los productos y el término de búsqueda
        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('productos.create');
    }

    // Almacenar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('productos')->where(function ($query) use ($request) {
                    return $query->where('marca', $request->marca)
                                 ->where('tipo', $request->tipo)
                                 ->where('talla', $request->talla)
                                 ->where('color', $request->color);
                }),
            ],
            'marca' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'detalle' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'ganancia' => 'required|numeric|min:0',
            'imagen' => 'required|string|max:255',
        ]);

        Producto::create([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'tipo' => $request->tipo,
            'talla' => $request->talla,
            'color' => $request->color,
            'detalle' => $request->detalle,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'ganancia' => $request->ganancia,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Actualizar producto existente
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('productos')->ignore($producto->id)->where(function ($query) use ($request) {
                    return $query->where('marca', $request->marca)
                                 ->where('tipo', $request->tipo)
                                 ->where('talla', $request->talla)
                                 ->where('color', $request->color);
                }),
            ],
            'marca' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'detalle' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'ganancia' => 'required|numeric|min:0',
            'imagen' => 'required|string|max:255',
        ]);


        $producto->update([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'tipo' => $request->tipo,
            'talla' => $request->talla,
            'color' => $request->color,
            'detalle' => $request->detalle,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'ganancia' => $request->ganancia,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
