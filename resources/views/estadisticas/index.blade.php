@extends('layoutprincipal')
@section('title', 'Estadísticas')
@section('contenido')
<div class="container mt-4">

    <h3 class="mb-4"> Estadísticas de Ventas</h3>

    <!-- Tarjetas de resumen -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total vendido hoy</h5>
                <h3 class="text-success">${{ number_format($ventasHoy, 2) }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Número de facturas hoy</h5>
                <h3>{{ $totalFacturasHoy }}</h3>
            </div>
        </div>

    </div>

    <!-- Gráfica -->
    <div class="card shadow-sm p-4">
        <h5>Ventas de los últimos 7 días</h5>
        <canvas id="ventasChart"></canvas>
    </div>

</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('ventasChart').getContext('2d');

    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Ventas de la semana (C$)',
                data: @json($data),
                borderWidth: 2,
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: '#9966ff',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
