@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm px-4 py-3 border border-purple-100">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center font-medium">
                        <i class="fas fa-home mr-2 text-purple-500"></i>
                        Inicio
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Clientes</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('IMG/target.gif') }}" 
                                 alt="Clientes" 
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-users text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Gestión de Clientes</h1>
                        <p class="text-gray-600 text-sm">Administra y consulta la información de tus clientes</p>
                    </div>
                </div>
                
                <!-- Botón agregar cliente -->
                <a href="{{ route('clientes.create') }}" 
                   class="px-5 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors text-sm font-medium">
                        <i class="fas fa-save mr-2"></i>
                    <span>Añadir Cliente</span>
                </a>
            </div>
        </div>

        <!-- Buscador Reducido -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-4">
            <form action="{{ route('clientes.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" 
                        name="buscar" 
                        value="{{ request('buscar') }}"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Buscar por cédula, nombre o teléfono">
                </div>
                <button type="submit" 
                        class="bg-purple-400 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </form>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Tabla Header -->
            <div class="bg-purple-400 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Lista de Clientes</h2>
                            <p class="text-purple-100 text-xs">Total: {{ $clientes->total() }} clientes</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">{{ $clientes->count() }} resultados</span>
                    </div>
                </div>
            </div>

            <!-- Tabla Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-purple-900 text-sm font-semibold">
                            <th class="px-6 py-4 text-left">Cédula</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Correo</th>
                            <th class="px-6 py-4 text-left">Dirección</th>
                            <th class="px-6 py-4 text-left">Teléfono</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($clientes as $cliente)
                        <tr class="hover:bg-purple-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $cliente->cedula }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $cliente->nombre }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-purple-400 text-xs"></i>
                                    <span class="truncate max-w-[200px]">{{ $cliente->correo }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-purple-400 text-xs"></i>
                                    <span class="truncate max-w-[200px]">{{ $cliente->direccion }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-purple-400 text-xs"></i>
                                    <span>{{ $cliente->telefono }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <!-- Editar -->
                                    <a href="{{ route('clientes.edit', $cliente->cedula) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center"
                                       title="Editar cliente">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('clientes.destroy', $cliente->cedula) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center"
                                                title="Eliminar cliente">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-3 text-gray-500">
                                    <i class="fas fa-users text-4xl text-gray-300"></i>
                                    <p class="text-lg font-medium">No se encontraron clientes</p>
                                    <p class="text-sm">No hay clientes registrados que coincidan con tu búsqueda.</p>
                                    <a href="{{ route('clientes.create') }}" 
                                       class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-plus mr-2"></i>Agregar primer cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($clientes->hasPages())
                <div class="bg-purple-50 px-6 py-4 border-t border-purple-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                        <p class="text-sm text-purple-700">
                            <span class="font-semibold text-purple-900">{{ $clientes->firstItem() }}-{{ $clientes->lastItem() }}</span>
                            de 
                            <span class="font-semibold text-purple-900">{{ $clientes->total() }}</span>
                            resultados
                        </p>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Botón Anterior -->
                            @if($clientes->onFirstPage())
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm">
                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                            </span>
                            @else
                            <a href="{{ $clientes->previousPageUrl() }}" class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors text-sm">
                                <i class="fas fa-chevron-left mr-1"></i> Anterior
                            </a>
                            @endif

                            <!-- Números de página -->
                            <div class="flex space-x-1">
                                @foreach(range(1, $clientes->lastPage()) as $page)
                                    @if($page == $clientes->currentPage())
                                    <span class="w-8 h-8 bg-purple-500 text-white rounded-lg flex items-center justify-center text-sm font-semibold">
                                        {{ $page }}
                                    </span>
                                    @else
                                    <a href="{{ $clientes->url($page) }}" class="w-8 h-8 text-purple-600 hover:bg-purple-100 rounded-lg flex items-center justify-center text-sm transition-colors">
                                        {{ $page }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Botón Siguiente -->
                            @if($clientes->hasMorePages())
                            <a href="{{ $clientes->nextPageUrl() }}" class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors text-sm">
                                Siguiente <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                            @else
                            <span class="px-3 py-1 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm">
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
</style>
@endsection