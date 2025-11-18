@extends('layoutprincipal')

@section('title', 'Comprobante de Factura')
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
                    <a href="{{ route('facturas.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors font-medium">
                        Facturas
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Factura #{{ $factura->id }}</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-invoice text-white text-xl"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-eye text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Comprobante de Factura</h1>
                        <p class="text-gray-600 text-sm">Detalle completo de la transacción #{{ $factura->id }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('facturas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver</span>
                    </a>
                    <a href="{{ route('facturas.pdf', $factura->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Encabezado de Factura -->
            <div class="bg-purple-500 px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-white">
                        <h2 class="text-xl font-bold">FACTURA #{{ $factura->id }}</h2>
                        <p class="text-purple-100 text-sm">
                            {{ \Carbon\Carbon::parse($factura->fecha)->setTimezone('America/Managua')->format('d/m/Y H:i') ?? 'No disponible' }}
                        </p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                            <i class="fas fa-credit-card mr-2"></i>
                            {{ $factura->metodo_pago }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Información de Cliente y Vendedor -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Información del Cliente -->
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-user text-purple-500 mr-2"></i>
                            Información del Cliente
                        </h3>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($factura->cliente->nombre ?? 'N/A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $factura->cliente->nombre ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Cliente</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                                <div class="flex items-center space-x-2 text-sm">
                                    <i class="fas fa-id-card text-purple-400 text-xs"></i>
                                    <span class="text-gray-600">Cédula:</span>
                                    <span class="font-medium">{{ $factura->cliente->cedula ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm">
                                    <i class="fas fa-phone text-purple-400 text-xs"></i>
                                    <span class="text-gray-600">Celular:</span>
                                    <span class="font-medium">{{ $factura->cliente->celular ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Vendedor -->
                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                            Información del Vendedor
                        </h3>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($factura->usuario->nombre ?? 'N/A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $factura->usuario->nombre ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Vendedor</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center space-x-2 text-sm">
                                    <i class="fas fa-id-card text-purple-400 text-xs"></i>
                                    <span class="text-gray-600">Cédula:</span>
                                    <span class="font-medium">{{ $factura->usuario->cedula ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Productos -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-receipt text-purple-500 mr-2"></i>
                        Detalle de Productos
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-purple-500">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Producto</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Cantidad</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Precio Unitario</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Descuento</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($factura->productos as $producto)
                                <tr class="hover:bg-purple-50 transition-colors duration-200">
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        <div class="font-medium">{{ $producto->nombre }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $producto->pivot->cantidad }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                        C$ {{ number_format($producto->pivot->precio, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                        @if($producto->pivot->descuento > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $producto->pivot->descuento }}%
                                        </span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-purple-600 text-center">
                                        C$ {{ number_format($producto->pivot->subtotal, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Resumen de Pagos -->
                <div class="bg-purple-50 rounded-lg p-6 border border-purple-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calculator text-purple-500 mr-2"></i>
                        Resumen de Pagos
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                            <p class="text-lg font-semibold text-gray-900">C$ {{ number_format($subtotal, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">IVA (15%)</p>
                            <p class="text-lg font-semibold text-purple-600">C$ {{ number_format($factura->iva, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-lg font-bold text-purple-600">C$ {{ number_format($factura->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-purple-200">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">Monto Recibido</p>
                            <p class="text-lg font-semibold text-gray-900">C$ {{ number_format($factura->monto_recibido, 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-1">Vuelto</p>
                            <p class="text-lg font-bold text-purple-600">C$ {{ number_format($factura->vuelto, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie de Factura -->
            <div class="bg-purple-50 px-6 py-4 border-t border-purple-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-center sm:text-left">
                    <div class="text-sm text-gray-600">
                        <p>Factura generada el {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($factura->fecha)->format('H:i') }}</p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Completada
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mt-6">
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('facturas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver al Listado</span>
                </a>
                <a href="{{ route('facturas.pdf', $factura->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-file-pdf"></i>
                    <span>Descargar PDF</span>
                </a>
                @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta factura?')" 
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-purple-500 hover:bg-purple-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                        <i class="fas fa-trash"></i>
                        <span>Eliminar Factura</span>
                    </button>
                </form>
                @endif
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
    
    /* Efectos hover suaves */
    .hover\:bg-purple-50:hover {
        background-color: rgba(245, 243, 255, 0.8);
    }
</style>

<script>
    // Script para mejorar la experiencia de usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar confirmación antes de eliminar
        const deleteForms = document.querySelectorAll('form[onsubmit]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('⚠️ ¿Estás completamente seguro de eliminar esta factura?\nEsta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });

        // Efecto de carga suave
        const content = document.querySelector('.bg-white.rounded-xl');
        if (content) {
            content.style.opacity = '0';
            setTimeout(() => {
                content.style.transition = 'opacity 0.3s ease-in-out';
                content.style.opacity = '1';
            }, 100);
        }
    });
</script>
@endsection