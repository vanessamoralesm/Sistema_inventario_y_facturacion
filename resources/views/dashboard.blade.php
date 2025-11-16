@extends('layoutPrincipal')

@section('contenido')
<!-- Hero Carousel Compacto -->
<div class="mb-6">
    <div class="relative h-40 md:h-64 rounded-xl overflow-hidden shadow-lg">
        <div class="carrusel-slide flex animate-slide h-full">
            @foreach([
                'IMG/3_tienda_blanco_madera_interiorismo-1024x592.jpg',
                'IMG/casual.jpg', 
                'IMG/beauty.jpg',
                'IMG/GFashion.jpg',
                'IMG/logo_home.jpg',
                'IMG/tiendaa.jpg'
            ] as $image)
            <div class="w-full h-40 md:h-64 flex-shrink-0">
                <img src="{{ asset($image) }}" alt="Imagen {{ $loop->iteration }}" class="w-full h-full object-cover">
            </div>
            @endforeach
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        <div class="absolute bottom-3 left-3 md:bottom-6 md:left-6 text-white">
            <h1 class="text-lg md:text-2xl font-bold">Boutique GarMorel</h1>
            <p class="text-white/80 text-xs md:text-sm">Moda elegante para cada ocasión</p>
        </div>
    </div>
</div>

@auth
<!-- Welcome Section Compacta -->
<div class="max-w-7xl mx-auto">
    <!-- User Welcome Card Compacta -->
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-4 border border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 md:gap-4">
            <div class="flex items-center gap-3 md:gap-4">
                <div class="relative">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-primary rounded-xl shadow-md flex items-center justify-center text-white text-sm md:text-base font-bold">
                        {{ strtoupper(substr(Auth::user()->nombre, 0, 2)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 md:w-4 md:h-4 bg-green-400 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-base md:text-xl font-bold text-gray-800 truncate">
                        ¡Bienvenid@, {{ Auth::user()->nombre }}!
                    </h2>
                    <p class="text-gray-600 text-xs md:text-sm truncate">Es un placer tenerte de vuelta</p>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        <span class="px-2 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                            <i class="bi bi-shield-check mr-1"></i>{{ Auth::user()->rol->tipo }}
                        </span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                            <i class="bi bi-calendar-check mr-1"></i>{{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="sm:w-auto w-full">
                @csrf
                <button type="submit" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-3 py-2 md:px-4 md:py-2 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2 w-full sm:w-auto justify-center text-xs md:text-sm">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Admin Actions Compactas -->
    @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 mb-4 md:mb-6">
        <!-- Backup Card Compacta -->
        <a href="{{ route('respaldar') }}" class="group block">
            <div class="bg-primary rounded-xl p-3 md:p-4 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between mb-2 md:mb-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="bi bi-hdd-stack-fill text-sm md:text-base"></i>
                    </div>
                    <i class="bi bi-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <h3 class="text-sm md:text-base font-bold mb-1">Respaldar BD</h3>
                <p class="text-white/80 text-xs">Copia de seguridad del sistema</p>
            </div>
        </a>

        <!-- Restore Card Compacta -->
        <a href="{{ route('vista.restaurar') }}" class="group block">
            <div class="bg-primary rounded-xl p-3 md:p-4 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center justify-between mb-2 md:mb-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-clockwise text-sm md:text-base"></i>
                    </div>
                    <i class="bi bi-arrow-right text-xs md:text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <h3 class="text-sm md:text-base font-bold mb-1">Restaurar Sistema</h3>
                <p class="text-white/80 text-xs">Recuperar desde backup</p>
            </div>
        </a>
    </div>
    @endif

    <!-- Quick Stats Compactas -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
        <!-- Ventas Card -->
        <div class="bg-white rounded-lg md:rounded-xl p-3 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-graph-up-arrow text-primary text-sm"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-gray-600 text-xs font-medium truncate">Ventas Hoy</p>
                    <p class="text-base md:text-lg font-bold text-gray-800 truncate">$2,847</p>
                </div>
            </div>
            <div class="mt-1">
                <span class="text-green-600 text-xs font-medium">
                    <i class="bi bi-arrow-up-short"></i>12.5%
                </span>
            </div>
        </div>

        <!-- Órdenes Card -->
        <div class="bg-white rounded-lg md:rounded-xl p-3 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-cart-check text-primary text-sm"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-gray-600 text-xs font-medium truncate">Facturas</p>
                    <p class="text-base md:text-lg font-bold text-gray-800 truncate">156</p>
                </div>
            </div>
            <div class="mt-1">
                <span class="text-green-600 text-xs font-medium">
                    <i class="bi bi-arrow-up-short"></i>8.3%
                </span>
            </div>
        </div>

        <!-- Clientes Card -->
        <div class="bg-white rounded-lg md:rounded-xl p-3 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-people text-primary text-sm"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-gray-600 text-xs font-medium truncate">Clientes</p>
                    <p class="text-base md:text-lg font-bold text-gray-800 truncate">892</p>
                </div>
            </div>
            <div class="mt-1">
                <span class="text-green-600 text-xs font-medium">
                    <i class="bi bi-arrow-up-short"></i>5.2%
                </span>
            </div>
        </div>

        <!-- Productos Card -->
        <div class="bg-white rounded-lg md:rounded-xl p-3 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-box-seam text-primary text-sm"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-gray-600 text-xs font-medium truncate">Productos</p>
                    <p class="text-base md:text-lg font-bold text-gray-800 truncate">342</p>
                </div>
            </div>
            <div class="mt-1">
                <span class="text-green-600 text-xs font-medium">
                    <i class="bi bi-arrow-up-short"></i>3.1%
                </span>
            </div>
        </div>
    </div>

    <!-- Sección de Acciones Rápidas -->
    <div class="mb-6 md:mb-8">
        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-3 md:mb-4 flex items-center gap-2">
            <i class="bi bi-lightning-fill text-primary"></i>
            Acciones Rápidas
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3">
            <a href="{{ route('facturas.index') }}" class="bg-white rounded-lg p-3 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 group text-center">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/90 transition-colors">
                    <i class="bi bi-plus-lg text-white text-sm"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Emitir Factura</span>
            </a>

            <a href="{{ route('clientes.index') }}" class="bg-white rounded-lg p-3 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 group text-center">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/90 transition-colors">
                    <i class="bi bi-person-plus text-white text-sm"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Nuevo Cliente</span>
            </a>

            <a href="{{ route('productos.index') }}" class="bg-white rounded-lg p-3 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 group text-center">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/90 transition-colors">
                    <i class="bi bi-box-arrow-in-down text-white text-sm"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Agregar Producto</span>
            </a>

            <a href="{{ route('facturas.index') }}" class="bg-white rounded-lg p-3 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 group text-center">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-primary/90 transition-colors">
                    <i class="bi bi-search text-white text-sm"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Buscar Factura</span>
            </a>
        </div>
    </div>

    <!-- Estado del Sistema -->
    <div>
        <h3 class="text-sm md:text-base font-bold text-gray-800 mb-3 md:mb-4 flex items-center gap-2">
            <i class="bi bi-heart-pulse text-primary"></i>
            Estado del Sistema
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
            <div class="bg-white rounded-lg md:rounded-xl p-3 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-700">Último Backup</span>
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                </div>
                <div class="text-xs text-gray-600">Hoy 02:30 AM • 12.3 MB</div>
            </div>
        </div>
    </div>
</div>
@endauth

<!-- Success Modal Compacto -->
@if(session('success'))
<div id="successModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-xs w-full animate-scale">
        <div class="bg-primary text-white p-4 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="bi bi-check-circle-fill text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold">¡Éxito!</h3>
                    <p class="text-white/80 text-xs">Operación completada</p>
                </div>
            </div>
        </div>
        <div class="p-4">
            <p class="text-gray-700 text-sm mb-4 text-center">{{ session('success') }}</p>
            <div class="flex gap-2 justify-center">
                @if(session('filename'))
                <a href="{{ route('descargar.archivo', session('filename')) }}" class="bg-primary hover:bg-primary/90 text-white px-3 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-1 shadow text-xs">
                    <i class="bi bi-download"></i>
                    Descargar
                </a>
                @endif
                <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg font-medium transition-colors duration-200 shadow text-xs">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.animation = 'fadeOut 0.3s ease-in';
        setTimeout(() => modal.remove(), 300);
    }
    
    setTimeout(closeModal, 5000);
</script>
@endif

<style>
.animate-slide {
    animation: slide 25s infinite;
}

@keyframes slide {
    0%, 16% { transform: translateX(0); }
    20%, 36% { transform: translateX(-100%); }
    40%, 56% { transform: translateX(-200%); }
    60%, 76% { transform: translateX(-300%); }
    80%, 96% { transform: translateX(-400%); }
    100% { transform: translateX(-500%); }
}

.animate-scale {
    animation: scaleIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.9);
    }
}

@media (max-width: 768px) {
    .animate-slide {
        animation: slide 20s infinite;
    }
}
</style>
@endsection