@extends('layoutprincipal')
@section('title', 'Estadísticas')
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
                    <span class="text-gray-700 font-semibold">Estadísticas</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Estadísticas de Ventas</h1>
                    <p class="text-gray-600 text-sm">Análisis y reportes de desempeño comercial</p>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Resumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Vendido Hoy -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Vendido Hoy</p>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($ventasHoy, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Ingresos del día actual</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-green-500 text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Facturas Hoy -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Facturas Hoy</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $totalFacturasHoy }}</p>
                        <p class="text-xs text-gray-500 mt-1">Transacciones del día</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-receipt text-purple-500 text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Promedio por Factura -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Promedio por Factura</p>
                        <p class="text-2xl font-bold text-blue-600">
                            @php
                                $promedio = $totalFacturasHoy > 0 ? $ventasHoy / $totalFacturasHoy : 0;
                            @endphp
                            ${{ number_format($promedio, 2) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Ticket promedio</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calculator text-blue-500 text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Día de la Semana -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Día Actual</p>
                        <p class="text-2xl font-bold text-orange-600">{{ now()->translatedFormat('l') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-day text-orange-500 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfica Principal -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-1">Ventas de los Últimos 7 Días</h2>
                    <p class="text-gray-600 text-sm">Tendencia de ingresos diarios</p>
                </div>
                <div class="bg-purple-50 px-3 py-1 rounded-full">
                    <span class="text-purple-700 text-sm font-medium">Semana Actual</span>
                </div>
            </div>
            <div class="h-80">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>

        <!-- Estadísticas Adicionales -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Resumen Semanal -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-pie text-purple-500 mr-2"></i>
                    Resumen Semanal
                </h3>
                <div class="space-y-4">
                    @php
                        $totalSemana = array_sum($data);
                        $promedioSemana = count($data) > 0 ? $totalSemana / count($data) : 0;
                        $maxVenta = count($data) > 0 ? max($data) : 0;
                        $ventasFiltradas = array_filter($data, function($valor) { return $valor > 0; });
                        $minVenta = count($ventasFiltradas) > 0 ? min($ventasFiltradas) : 0;
                    @endphp
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Total Semanal:</span>
                        <span class="font-bold text-green-600">${{ number_format($totalSemana, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Promedio Diario:</span>
                        <span class="font-bold text-blue-600">${{ number_format($promedioSemana, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Mejor Día:</span>
                        <span class="font-bold text-purple-600">${{ number_format($maxVenta, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Días con Ventas:</span>
                        <span class="font-bold text-orange-600">{{ count($ventasFiltradas) }}/7</span>
                    </div>
                </div>
            </div>

            <!-- Métricas de Rendimiento -->
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-trending-up text-purple-500 mr-2"></i>
                    Métricas de Rendimiento
                </h3>
                <div class="space-y-4">
                    <!-- Porcentaje de Crecimiento -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Crecimiento vs Ayer</span>
                            <span class="text-sm font-bold 
                                @if(count($data) >= 2 && $data[5] > 0 && $data[6] > $data[5]) 
                                    text-green-600
                                @elseif(count($data) >= 2 && $data[5] > 0)
                                    text-red-600
                                @else
                                    text-gray-600
                                @endif">
                                @if(count($data) >= 2 && $data[5] > 0)
                                    {{ number_format((($data[6] - $data[5]) / $data[5]) * 100, 1) }}%
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" 
                                 style="width: {{ count($data) >= 2 && $data[5] > 0 ? min(abs((($data[6] - $data[5]) / $data[5]) * 100), 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Meta Diaria -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Progreso Meta Diaria</span>
                            <span class="text-sm font-bold text-blue-600">
                                @php
                                    $metaDiaria = 1000; // Puedes hacer esta meta dinámica
                                    $progreso = $metaDiaria > 0 ? min(($ventasHoy / $metaDiaria) * 100, 100) : 0;
                                @endphp
                                {{ number_format($progreso, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $progreso }}%"></div>
                        </div>
                    </div>

                    <!-- Eficiencia Comercial -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Eficiencia Comercial</span>
                            <span class="text-sm font-bold text-green-600">
                                @if($totalFacturasHoy > 0)
                                    {{ number_format($ventasHoy / $totalFacturasHoy, 1) }}
                                @else
                                    0
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" 
                                 style="width: {{ $totalFacturasHoy > 0 ? min(($ventasHoy / $totalFacturasHoy) * 10, 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mt-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                Información del Sistema
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-sync text-purple-400"></i>
                    <span>Actualizado: {{ now()->format('H:i') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-database text-purple-400"></i>
                    <span>Período: Últimos 7 días</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-chart-line text-purple-400"></i>
                    <span>Métricas en tiempo real</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    const ctx = document.getElementById('ventasChart').getContext('2d');

    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Ventas Diarias (C$)',
                data: @json($data),
                borderWidth: 2,
                backgroundColor: 'rgba(147, 51, 234, 0.7)',
                borderColor: 'rgb(147, 51, 234)',
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection