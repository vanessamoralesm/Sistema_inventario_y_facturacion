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
        $query = Producto::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;

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
                    ->orWhere('id', $searchTerm);
            });
        }

        $productos = $query->latest()->paginate(10);

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
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'ganancia' => 'required|numeric|min:0',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $datos = $request->except('imagen');

        /** GUARDAR IMAGEN EN public/IMG */
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombre = time() . '_' . $file->getClientOriginalName();  
            $file->move(public_path('IMG'), $nombre);
            $datos['imagen'] = $nombre;
        }

        Producto::create($datos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }


    // Mostrar formulario de edición
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }


    // Mostrar detalles del producto
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }


    // Actualizar producto
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
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'ganancia' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $datos = $request->except('imagen');

        /** ACTUALIZAR IMAGEN EN public/IMG */
        if ($request->hasFile('imagen')) {
            // Borrar la imagen anterior si existe
            if ($producto->imagen && file_exists(public_path('IMG/' . $producto->imagen))) {
                unlink(public_path('IMG/' . $producto->imagen));
            }

            $file = $request->file('imagen');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('IMG'), $nombre);
            $datos['imagen'] = $nombre;
        }

        $producto->update($datos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }


    // Eliminar producto
    public function destroy(Producto $producto)
    {
        // Eliminar imagen física
        if ($producto->imagen && file_exists(public_path('IMG/' . $producto->imagen))) {
            unlink(public_path('IMG/' . $producto->imagen));
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
