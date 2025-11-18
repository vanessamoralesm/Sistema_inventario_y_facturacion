@extends('layoutprincipal')

@section('title', 'Facturas')
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
                    <span class="text-gray-700 font-semibold">Facturas</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('IMG/factura.gif') }}" 
                                 alt="Facturas" 
                                 class="w-14 h-14 rounded-full object-cover border-2 border-white">
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-file-invoice text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Gestión de Facturas</h1>
                        <p class="text-gray-600 text-sm">Administra y consulta todos los comprobantes</p>
                    </div>
                </div>
                
                <!-- Botón nueva factura -->
                <a href="{{ route('facturas.create') }}" 
                   class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors text-sm font-medium flex items-center space-x-2">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Nueva Factura</span>
                </a>
            </div>
        </div>

        <!-- Buscador Reducido -->
        <div class="bg-white rounded-lg shadow-sm border border-purple-100 p-4 mb-4">
            <form action="{{ route('facturas.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" 
                        name="buscar" 
                        value="{{ request('buscar') }}"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Buscar por ID de factura">
                </div>
                <button type="submit" 
                        class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium flex items-center justify-center space-x-2 text-sm">
                    <i class="fas fa-search"></i>
                    <span>Buscar</span>
                </button>
            </form>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Tabla Header -->
            <div class="bg-purple-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Lista de Facturas</h2>
                            <p class="text-purple-100 text-xs">Total: {{ $facturas->total() }} facturas</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">{{ $facturas->count() }} resultados</span>
                    </div>
                </div>
            </div>

            <!-- Tabla Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-purple-900 text-sm font-semibold">
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Fecha</th>
                            <th class="px-6 py-4 text-left">Cliente</th>
                            <th class="px-6 py-4 text-left">Vendedor</th>
                            <th class="px-6 py-4 text-left">Total</th>
                            <th class="px-6 py-4 text-left">Método de Pago</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($facturas as $factura)
                        <tr class="hover:bg-purple-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    #{{ $factura->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex flex-col space-y-1">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-calendar text-purple-400 text-xs"></i>
                                        <span>{{ $factura->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1 text-xs text-gray-500">
                                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                                        <span>{{ $factura->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-purple-400 text-xs"></i>
                                    <span>{{ $factura->cliente->nombre ?? 'N/A' }}</span>
                                </div>
                                @if($factura->cliente->rtn ?? false)
                                <div class="text-xs text-gray-500 mt-1">RTN: {{ $factura->cliente->rtn }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($factura->usuario->nombre ?? 'N/A', 0, 1) }}
                                    </div>
                                    <span class="truncate max-w-[120px]">{{ $factura->usuario->nombre ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                C$ {{ number_format($factura->total, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @php
                                    $metodoColors = [
                                        'efectivo' => 'bg-green-100 text-green-800',
                                        'tarjeta' => 'bg-blue-100 text-blue-800',
                                        'transferencia' => 'bg-purple-100 text-purple-800',
                                    ];
                                    $color = $metodoColors[strtolower($factura->metodo_pago)] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    <i class="fas 
                                        @if(strtolower($factura->metodo_pago) == 'efectivo') fa-money-bill-wave 
                                        @elseif(strtolower($factura->metodo_pago) == 'tarjeta') fa-credit-card 
                                        @elseif(strtolower($factura->metodo_pago) == 'transferencia') fa-university 
                                        @else fa-wallet @endif
                                        mr-1 text-xs">
                                    </i>
                                    {{ ucfirst($factura->metodo_pago) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <!-- Ver -->
                                    <a href="{{ route('facturas.show', $factura->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                       title="Ver factura">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>

                                    <!-- PDF -->
                                    <a href="{{ route('facturas.pdf', $factura->id) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                       title="Descargar PDF">
                                        <i class="fas fa-file-pdf text-sm"></i>
                                    </a>

                                    <!-- Eliminar (solo para admin) -->
                                    @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                                    <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta factura?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                                title="Eliminar factura">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center space-y-3 text-gray-500">
                                    <i class="fas fa-file-invoice text-4xl text-gray-300"></i>
                                    <p class="text-lg font-medium">No se encontraron facturas</p>
                                    <p class="text-sm">No hay facturas registradas que coincidan con tu búsqueda.</p>
                                    <a href="{{ route('facturas.create') }}" 
                                       class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>Crear primera factura
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($facturas->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $facturas->appends(request()->query())->links() }}
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

    /* Estilos para la paginación de Laravel */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        font-size: 0.875rem;
    }

    .pagination .page-link:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }

    .pagination .page-item.active .page-link {
        background-color: #8b5cf6;
        border-color: #8b5cf6;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        cursor: not-allowed;
        background-color: #f9fafb;
    }
</style>

<script>
    // Script para mejorar la experiencia de usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar confirmación antes de eliminar (doble seguridad)
        const deleteForms = document.querySelectorAll('form[onsubmit]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('⚠️ ¿Estás completamente seguro de eliminar esta factura?\nEsta acción no se puede deshacer.')) {
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