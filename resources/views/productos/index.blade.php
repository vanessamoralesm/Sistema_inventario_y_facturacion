@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-6">
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
                    <span class="text-gray-700 font-semibold">Productos</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('IMG/tienda-de-ropa.gif') }}" 
                                 alt="Productos" 
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-box text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Gestión de Productos</h1>
                        <p class="text-gray-600 text-sm">Administra el inventario de productos</p>
                    </div>
                </div>
                
                <!-- Botón agregar producto (oculto si es vendedor) -->
                @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                <a href="{{ route('productos.create') }}" 
                   class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors text-sm font-medium flex items-center space-x-2 shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Añadir Producto</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Productos</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $productos->total() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-boxes text-purple-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Stock Total</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $productos->sum('stock') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-warehouse text-blue-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Bajo Stock</p>
                        <p class="text-2xl font-bold text-red-600">
                            @php
                                $stock_minimo = 5;
                                $bajo_stock = $productos->where('stock', '<=', $stock_minimo)->count();
                            @endphp
                            {{ $bajo_stock }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Activos</p>
                        <p class="text-2xl font-bold text-green-600">{{ $productos->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-4">
            <form action="{{ route('productos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Buscar por ID, nombre, marca, tipo...">
                </div>
                <button type="submit" 
                        class="bg-purple-400 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
                @if (request()->filled('search'))
                    <a href="{{ route('productos.index') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center justify-center space-x-2 text-sm">
                        <i class="fas fa-times"></i>
                        <span>Limpiar</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Grid de Productos -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Header de la Grid -->
            <div class="bg-purple-400 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Lista de Productos</h2>
                            <p class="text-purple-100 text-xs">Total: {{ $productos->total() }} productos</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">{{ $productos->count() }} resultados</span>
                    </div>
                </div>
            </div>

            <!-- Contenido de la Grid -->
            <div class="p-6">
                @if($productos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($productos as $producto)
                        @php $stock_minimo = 5; @endphp
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 group {{ $producto->stock <= $stock_minimo ? 'border-l-4 border-l-red-500' : '' }}">
                            <!-- Header de la Card con Menú de Tres Puntos -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow overflow-hidden">
                                        <img src="{{ asset('IMG/' . $producto->imagen) }}" 
                                            alt="{{ $producto->nombre }}" 
                                            class="w-10 h-10 object-cover rounded">
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-sm leading-tight">{{ $producto->nombre }}</h3>
                                        <p class="text-xs text-gray-500">ID: {{ $producto->id }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <!-- Badges -->
                                    <div class="flex flex-col items-end space-y-1">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">
                                            Activo
                                        </span>
                                        @if($producto->stock <= $stock_minimo)
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                                            ¡Poco Stock!
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Menú de Tres Puntos -->
                                    @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                                    <div class="relative" x-data="{ open: false }">
                                        <!-- Botón de Tres Puntos -->
                                        <button 
                                            @click="open = !open"
                                            class="p-1 text-gray-400 hover:text-purple-600 transition-colors duration-200 rounded-lg hover:bg-purple-50"
                                            title="Opciones del producto">
                                            <i class="fas fa-ellipsis-v text-sm"></i>
                                        </button>

                                        <!-- Menú Desplegable -->
                                        <div 
                                            x-show="open"
                                            @click.away="open = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border border-purple-200 z-10 py-1">
                                            
                                            <!-- Ver Detalles -->
                                            <a
                                                href="{{ route('productos.show', $producto->id) }}"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors flex items-center space-x-2">
                                                <i class="fas fa-eye text-purple-400 text-xs"></i>
                                                <span>Ver detalles</span>
                                            </a>

                                            <!-- Editar -->
                                            <a 
                                                href="{{ route('productos.edit', $producto->id) }}"
                                                @click="open = false"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition-colors flex items-center space-x-2">
                                                <i class="fas fa-edit text-purple-400 text-xs"></i>
                                                <span>Editar</span>
                                            </a>

                                            <!-- Eliminar -->
                                            <button 
                                                type="button"
                                                @click="open = false; confirmarEliminacion({{ $producto->id }}, '{{ $producto->nombre }}')"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center space-x-2">
                                                <i class="fas fa-trash text-red-400 text-xs"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Información del Producto -->
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Marca:</span>
                                    <span class="font-medium text-gray-800">{{ $producto->marca }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Categoría:</span>
                                    <span class="font-medium text-gray-800">{{ $producto->tipo }}</span>
                                </div>
                                @if($producto->talla)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Talla:</span>
                                    <span class="font-medium text-gray-800">{{ $producto->talla }}</span>
                                </div>
                                @endif
                                @if($producto->color)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Color:</span>
                                    <span class="font-medium text-gray-800">{{ $producto->color }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Precios y Stock -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-white rounded-lg p-2 text-center">
                                    <p class="text-xs text-gray-500">Precio Venta</p>
                                    <p class="text-sm font-bold text-purple-600">${{ number_format($producto->precio_venta, 2) }}</p>
                                </div>
                                <div class="bg-white rounded-lg p-2 text-center">
                                    <p class="text-xs text-gray-500">Stock</p>
                                    <p class="text-sm font-bold {{ $producto->stock <= $stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $producto->stock }}
                                    </p>
                                </div>
                            </div>

                            <!-- Detalle (si existe) -->
                            @if($producto->detalle)
                            <div class="mb-4">
                                <p class="text-xs text-gray-600 line-clamp-2">{{ $producto->detalle }}</p>
                            </div>
                            @endif

                            <!-- Formulario de Eliminación (oculto) -->
                            @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                            <form id="form-eliminar-{{ $producto->id }}" 
                                  action="{{ route('productos.destroy', $producto->id) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Estado vacío -->
                    <div class="text-center py-12">
                        <div class="flex flex-col items-center space-y-4 text-gray-500">
                            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-box-open text-purple-400 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-gray-600 mb-2">No hay productos registrados</p>
                                <p class="text-sm text-gray-500 mb-4">No se encontraron productos que coincidan con tu búsqueda.</p>
                            </div>
                            @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                            <a href="{{ route('productos.create') }}" 
                               class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200 font-medium flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Agregar primer producto</span>
                            </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Paginación -->
            @if($productos->hasPages())
                <div class="bg-purple-50 px-6 py-4 border-t border-purple-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                        <p class="text-sm text-purple-700">
                            <span class="font-semibold text-purple-900">{{ $productos->firstItem() }}-{{ $productos->lastItem() }}</span>
                            de 
                            <span class="font-semibold text-purple-900">{{ $productos->total() }}</span>
                            resultados
                        </p>
                        
                        <div class="flex items-center space-x-2">
                            {{ $productos->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
    
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    
    /* Efectos hover suaves */
    .group:hover {
        transform: translateY(-2px);
    }
    
    /* Efecto de brillo en los botones */
    .bg-gradient-to-r:hover {
        filter: brightness(110%);
    }
    
    /* Limitar líneas de texto */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Función para confirmar eliminación
    function confirmarEliminacion(productoId, productoNombre) {
        if (confirm(`¿Estás completamente seguro de eliminar el producto "${productoNombre}"?\nEsta acción no se puede deshacer.`)) {
            document.getElementById(`form-eliminar-${productoId}`).submit();
        }
    }

    // Script para mejorar la experiencia de usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de carga suave para las cards
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease-in-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection