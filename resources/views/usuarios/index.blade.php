@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm px-4 py-3 border border-blue-100">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center font-medium">
                        <i class="fas fa-home mr-2 text-blue-500"></i>
                        Inicio
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Usuarios</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('IMG/clasificacion.gif') }}" 
                                 alt="Usuarios" 
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-user-shield text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Gestión de Usuarios</h1>
                        <p class="text-gray-600 text-sm">Administra y gestiona los usuarios del sistema</p>
                    </div>
                </div>
                
                <!-- Botón agregar usuario -->
                <a href="{{ route('usuarios.create') }}" 
                   class="px-5 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-colors text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Añadir Usuario</span>
                </a>
            </div>
        </div>

        <!-- Buscador Reducido -->
        <div class="bg-white rounded-lg shadow-sm border border-blue-100 p-4 mb-4">
            <form action="{{ route('usuarios.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" 
                        name="buscar" 
                        value="{{ request('buscar') }}"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Buscar por cédula, nombre o correo">
                </div>
                <button type="submit" 
                        class="bg-blue-400 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </form>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 overflow-hidden">
            <!-- Tabla Header -->
            <div class="bg-blue-400 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Lista de Usuarios</h2>
                            <p class="text-blue-100 text-xs">Total: {{ $usuarios->total() }} usuarios</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">{{ $usuarios->count() }} resultados</span>
                    </div>
                </div>
            </div>

            <!-- Tabla Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-blue-900 text-sm font-semibold">
                            <th class="px-6 py-4 text-left">Cédula</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Correo</th>
                            <th class="px-6 py-4 text-left">Rol</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($usuarios as $usuario)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $usuario->cedula }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-blue-400 text-xs"></i>
                                    <span>{{ $usuario->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-blue-400 text-xs"></i>
                                    <span class="truncate max-w-[200px]">{{ $usuario->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($usuario->rol->tipo == 'Administrador') 
                                        bg-red-100 text-red-800
                                    @elseif($usuario->rol->tipo == 'Vendedor')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif">
                                    <i class="fas 
                                        @if($usuario->rol->tipo == 'Administrador') 
                                            fa-crown 
                                        @elseif($usuario->rol->tipo == 'Vendedor')
                                            fa-user-tie 
                                        @else
                                            fa-user 
                                        @endif mr-1 text-xs">
                                    </i>
                                    {{ $usuario->rol->tipo ?? 'Sin rol' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <!-- Editar -->
                                    <a href="{{ route('usuarios.edit', $usuario->cedula) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                       title="Editar usuario">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('usuarios.destroy', $usuario->cedula) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                                title="Eliminar usuario">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-3 text-gray-500">
                                    <i class="fas fa-user-slash text-4xl text-gray-300"></i>
                                    <p class="text-lg font-medium">No se encontraron usuarios</p>
                                    <p class="text-sm">No hay usuarios registrados que coincidan con tu búsqueda.</p>
                                    <a href="{{ route('usuarios.create') }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-user-plus mr-2"></i>Agregar primer usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($usuarios->hasPages())
                <div class="bg-blue-50 px-6 py-4 border-t border-blue-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                        <p class="text-sm text-blue-700">
                            <span class="font-semibold text-blue-900">{{ $usuarios->firstItem() }}-{{ $usuarios->lastItem() }}</span>
                            de 
                            <span class="font-semibold text-blue-900">{{ $usuarios->total() }}</span>
                            resultados
                        </p>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Botón Anterior -->
                            @if($usuarios->onFirstPage())
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm flex items-center">
                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                            </span>
                            @else
                            <a href="{{ $usuarios->previousPageUrl() }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm flex items-center">
                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                            </a>
                            @endif

                            <!-- Números de página -->
                            <div class="flex space-x-1">
                                @php
                                    $current = $usuarios->currentPage();
                                    $last = $usuarios->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                @endphp

                                @if($start > 1)
                                    <a href="{{ $usuarios->url(1) }}" class="w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm transition-colors">
                                        1
                                    </a>
                                    @if($start > 2)
                                        <span class="w-8 h-8 text-gray-400 flex items-center justify-center text-sm">...</span>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    @if($page == $usuarios->currentPage())
                                    <span class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm font-semibold">
                                        {{ $page }}
                                    </span>
                                    @else
                                    <a href="{{ $usuarios->url($page) }}" class="w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm transition-colors">
                                        {{ $page }}
                                    </a>
                                    @endif
                                @endfor

                                @if($end < $last)
                                    @if($end < $last - 1)
                                        <span class="w-8 h-8 text-gray-400 flex items-center justify-center text-sm">...</span>
                                    @endif
                                    <a href="{{ $usuarios->url($last) }}" class="w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg flex items-center justify-center text-sm transition-colors">
                                        {{ $last }}
                                    </a>
                                @endif
                            </div>

                            <!-- Botón Siguiente -->
                            @if($usuarios->hasMorePages())
                            <a href="{{ $usuarios->nextPageUrl() }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm flex items-center">
                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                            @else
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm flex items-center">
                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Animación suave para los hover */
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
</style>

<script>
    // Script para mejorar la experiencia de usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar confirmación antes de eliminar (doble seguridad)
        const deleteForms = document.querySelectorAll('form[onsubmit]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('⚠️ ¿Estás completamente seguro de eliminar este usuario?\nEsta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });

        // Efecto de carga suave
        const table = document.querySelector('table');
        if (table) {
            table.style.opacity = '0';
            setTimeout(() => {
                table.style.transition = 'opacity 0.3s ease-in-out';
                table.style.opacity = '1';
            }, 100);
        }
    });
</script>
@endsection