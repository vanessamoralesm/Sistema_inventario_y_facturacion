<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;


class UsuarioController extends Controller
{
    // Mostrar todos los usuarios
    public function index(Request $request)
    {
        $query = Usuario::query();

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('nombre', 'LIKE', "%{$busqueda}%")
                  ->orWhere('cedula', 'LIKE', "%{$busqueda}%");
        }

        $usuarios = $query->paginate(4);

        return view('usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario para crear nuevo usuario
        public function create()
        {
            $roles = Rol::all();
            return view('usuarios.create', compact('roles'));
        }

        // Guardar nuevo usuario
        public function store(Request $request)
        {
            $request->validate([
                'cedula'   => 'required|string|unique:usuarios,cedula',
                'nombre'   => 'required|string|max:100',
                'email'    => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:6|confirmed',
                'rol_id'   => 'required|exists:roles,id',
            ]);

            // Aquí es donde encriptamos el password antes de guardarlo:
            Usuario::create([
                'cedula'   => $request->cedula,
                'nombre'   => $request->nombre,
                'email'    => $request->email,
                'password' => Hash::make($request->password),  // <-- aquí
                'rol_id'   => $request->rol_id,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
        }


    // Mostrar formulario para editar
    public function edit($cedula)
    {
        $usuario = Usuario::findOrFail($cedula);
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, $cedula)
    {
        $usuario = Usuario::findOrFail($cedula);

        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|unique:usuarios,email,' . $usuario->cedula . ',cedula',
            'rol_id'   => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed', // 'confirmed' requiere password_confirmation
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->email  = $request->email;
        $usuario->rol_id = $request->rol_id;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy($cedula)
    {
        $usuario = Usuario::findOrFail($cedula);

        // Verificar si el usuario que intenta borrar es el mismo que está logueado
        $current = Auth::user();
        if ($current && $current->cedula == $usuario->cedula) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propio usuario mientras estás logueado.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

}
