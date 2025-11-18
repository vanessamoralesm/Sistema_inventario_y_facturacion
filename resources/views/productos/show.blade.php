@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <a href="{{ route('productos.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors font-medium">
                        Productos
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Detalles del Producto</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('IMG/' . $producto->imagen) }}" 
                                alt="{{ $producto->nombre }}" 
                                class="w-10 h-10 object-cover rounded">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-info-circle text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Detalles del Producto</h1>
                        <p class="text-gray-600 text-sm">Información completa de {{ $producto->nombre }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('productos.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center space-x-2 text-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver</span>
                    </a>
                    @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                    <a href="{{ route('productos.edit', $producto->id) }}" 
                       class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200 font-medium flex items-center space-x-2 text-sm shadow-md">
                        <i class="fas fa-edit"></i>
                        <span>Editar</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda - Imagen y Estado -->
            <div class="lg:col-span-1">
                <!-- Imagen del Producto -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
                    <div class="flex flex-col items-center">
                        <div class="w-48 h-48 bg-gray-100 rounded-lg overflow-hidden shadow-sm mb-4">
                            <img src="{{ asset('IMG/' . $producto->imagen) }}" 
                                alt="{{ $producto->nombre }}">
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $producto->nombre }}</h2>
                            <p class="text-sm text-gray-500 mb-4">ID: {{ $producto->id }}</p>
                            
                            <!-- Estados -->
                            <div class="flex flex-wrap justify-center gap-2">
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Activo
                                </span>
                                @if($producto->stock <= 5)
                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>¡Poco Stock!
                                </span>
                                @endif
                                @if($producto->stock > 20)
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-medium">
                                    <i class="fas fa-boxes mr-1"></i>Stock Alto
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Rápida -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                        Resumen
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Stock Actual:</span>
                            <span class="text-lg font-bold {{ $producto->stock <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $producto->stock }} unidades
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Ganancia por Unidad:</span>
                            <span class="text-lg font-bold text-purple-600">${{ number_format($producto->ganancia, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Margen de Ganancia:</span>
                            <span class="text-lg font-bold text-green-600">
                                @if($producto->precio_compra > 0)
                                    {{ number_format(($producto->ganancia / $producto->precio_compra) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Información Detallada -->
            <div class="lg:col-span-2">
                <!-- Información General -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                        Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Marca</label>
                            <p class="text-gray-800 font-medium">{{ $producto->marca }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tipo</label>
                            <p class="text-gray-800 font-medium capitalize">{{ $producto->tipo }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Talla</label>
                            <p class="text-gray-800 font-medium">{{ $producto->talla }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Color</label>
                            <p class="text-gray-800 font-medium">{{ $producto->color }}</p>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-align-left text-purple-500 mr-2"></i>
                        Descripción
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $producto->detalle }}</p>
                </div>

                <!-- Información de Precios -->
                <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-dollar-sign text-purple-500 mr-2"></i>
                        Información de Precios
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Precio de Compra -->
                        <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-shopping-cart text-blue-500"></i>
                            </div>
                            <p class="text-sm text-blue-600 font-medium mb-1">Precio de Compra</p>
                            <p class="text-xl font-bold text-blue-700">${{ number_format($producto->precio_compra, 2) }}</p>
                        </div>

                        <!-- Precio de Venta -->
                        <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-tag text-purple-500"></i>
                            </div>
                            <p class="text-sm text-purple-600 font-medium mb-1">Precio de Venta</p>
                            <p class="text-xl font-bold text-purple-700">${{ number_format($producto->precio_venta, 2) }}</p>
                        </div>

                        <!-- Ganancia -->
                        <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-chart-line text-green-500"></i>
                            </div>
                            <p class="text-sm text-green-600 font-medium mb-1">Ganancia</p>
                            <p class="text-xl font-bold text-green-700">${{ number_format($producto->ganancia, 2) }}</p>
                        </div>
                    </div>

                    <!-- Análisis de Rentabilidad -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="text-md font-semibold text-gray-800 mb-3">Análisis de Rentabilidad</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Ganancia Total Potencial:</span>
                                <span class="font-bold text-green-600 ml-2">
                                    ${{ number_format($producto->ganancia * $producto->stock, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Inversión en Stock:</span>
                                <span class="font-bold text-blue-600 ml-2">
                                    ${{ number_format($producto->precio_compra * $producto->stock, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-history text-purple-500 mr-2"></i>
                Información Adicional
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-md font-medium text-gray-700 mb-3">Fechas del Producto</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Creado:</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $producto->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Última actualización:</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $producto->updated_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-md font-medium text-gray-700 mb-3">Estadísticas</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Días desde creación:</span>
                            <span class="text-sm font-medium text-gray-800">
                                {{ $producto->created_at->diffInDays(now()) }} días
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Estado del inventario:</span>
                            <span class="text-sm font-medium {{ $producto->stock <= 5 ? 'text-red-600' : ($producto->stock <= 20 ? 'text-yellow-600' : 'text-green-600') }}">
                                @if($producto->stock <= 5)
                                    Crítico
                                @elseif($producto->stock <= 20)
                                    Normal
                                @else
                                    Óptimo
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection