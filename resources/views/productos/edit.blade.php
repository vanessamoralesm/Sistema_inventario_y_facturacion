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
                    <span class="text-gray-700 font-semibold">Editar Producto</span>
                </li>
            </ol>
        </nav>

        <!-- Alertas -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>Por favor corrige los errores en el formulario.</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('IMG/tienda-de-ropa.gif') }}" 
                             alt="productos" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-white">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-yellow-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Editar Producto</h1>
                    <p class="text-gray-600 text-sm">Actualice la información del producto: {{ $producto->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag text-purple-500 mr-1"></i>
                            Nombre del Producto
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('nombre') border-red-500 @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $producto->nombre) }}" 
                               required>
                        @error('nombre')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Marca -->
                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-industry text-purple-500 mr-1"></i>
                            Marca
                        </label>
                        <input type="text" 
                               id="marca" 
                               name="marca" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('marca') border-red-500 @enderror" 
                               value="{{ old('marca', $producto->marca) }}" 
                               required>
                        @error('marca')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Detalle -->
                <div>
                    <label for="detalle" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left text-purple-500 mr-1"></i>
                        Detalle del Producto
                    </label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('detalle') border-red-500 @enderror" 
                              id="detalle" 
                              name="detalle" 
                              rows="3" 
                              required>{{ old('detalle', $producto->detalle) }}</textarea>
                    @error('detalle')
                        <div class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Sección de Precios y Stock -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-dollar-sign text-purple-500 mr-2"></i>
                        Información de Precios y Stock
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Precio de Compra -->
                        <div>
                            <label for="precio_compra" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio de Compra
                            </label>
                            <input type="number" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('precio_compra') border-red-500 @enderror" 
                                   id="precio_compra" 
                                   name="precio_compra" 
                                   value="{{ old('precio_compra', $producto->precio_compra) }}" 
                                   min="0" 
                                   step="0.01" 
                                   required>
                            @error('precio_compra')
                                <div class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Precio de Venta -->
                        <div>
                            <label for="precio_venta" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio de Venta
                            </label>
                            <input type="number" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('precio_venta') border-red-500 @enderror" 
                                   id="precio_venta" 
                                   name="precio_venta" 
                                   value="{{ old('precio_venta', $producto->precio_venta) }}" 
                                   min="0" 
                                   step="0.01" 
                                   required>
                            @error('precio_venta')
                                <div class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Ganancia (Calculada) -->
                        <div>
                            <label for="ganancia" class="block text-sm font-medium text-gray-700 mb-2">
                                Ganancia
                            </label>
                            <input type="number" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-semibold" 
                                   id="ganancia" 
                                   name="ganancia" 
                                   value="{{ old('ganancia', $producto->ganancia) }}" 
                                   readonly>
                            <p class="text-xs text-gray-500 mt-1" id="porcentaje_ganancia"></p>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="mt-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-boxes text-purple-500 mr-1"></i>
                            Cantidad Disponible
                        </label>
                        <input type="number" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('stock') border-red-500 @enderror" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', $producto->stock) }}" 
                               min="0" 
                               required>
                        @error('stock')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Sección de Categorización -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-layer-group text-purple-500 mr-2"></i>
                        Categorización
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('tipo') border-red-500 @enderror" 
                                    id="tipo" 
                                    name="tipo" 
                                    required>
                                <option value="">Selecciona un tipo</option>
                                <option value="niño" {{ old('tipo', $producto->tipo) == 'niño' ? 'selected' : '' }}>Niño</option>
                                <option value="niña" {{ old('tipo', $producto->tipo) == 'niña' ? 'selected' : '' }}>Niña</option>
                                <option value="hombre" {{ old('tipo', $producto->tipo) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="mujer" {{ old('tipo', $producto->tipo) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                            </select>
                            @error('tipo')
                                <div class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Talla -->
                        <div>
                            <label for="talla" class="block text-sm font-medium text-gray-700 mb-2">
                                Talla
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('talla') border-red-500 @enderror" 
                                    id="talla" 
                                    name="talla" 
                                    required>
                                <!-- Las opciones se llenan con JS -->
                            </select>
                            @error('talla')
                                <div class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                Color
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('color') border-red-500 @enderror" 
                                    name="color" 
                                    id="color" 
                                    required>
                                <!-- Se llenan con JS -->
                            </select>
                            @error('color')
                                <div class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="border-t border-gray-200 pt-6">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image text-purple-500 mr-1"></i>
                        Imagen del Producto
                    </label>
                    <input type="file" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('imagen') border-red-500 @enderror" 
                           id="imagen" 
                           name="imagen">
                    <small class="text-xs text-gray-500 mt-1">Dejar vacío si no desea cambiar la imagen. Formatos: JPEG, PNG, JPG, GIF (Máx. 2MB)</small>
                    
                    @error('imagen')
                        <div class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    @if($producto->imagen)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Imagen actual:</p>
                            <img src="{{ asset($producto->imagen) }}" 
                                 alt="Imagen actual de {{ $producto->nombre }}" 
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                        </div>
                    @endif
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('productos.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center justify-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200 font-medium flex items-center justify-center space-x-2 shadow-md">
                        <i class="fas fa-save"></i>
                        <span>Actualizar Producto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
    
    /* Efecto de brillo en los botones */
    .bg-gradient-to-r:hover {
        filter: brightness(110%);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const colores = ['Blanco', 'Negro', 'Gris', 'Azul', 'Rojo', 'Verde', 'Amarillo', 'Rosado', 'Naranja', 'Marrón', 'Morado', 'Celeste'];
    const selectColor = document.getElementById('color');
    const tallaSelect = document.getElementById('talla');
    const tipoSelect = document.getElementById('tipo');
    const precioCompraInput = document.getElementById('precio_compra');
    const precioVentaInput = document.getElementById('precio_venta');
    const gananciaInput = document.getElementById('ganancia');
    const porcentajeGanancia = document.getElementById('porcentaje_ganancia');

    // Función para calcular ganancia
    function calcularGanancia() {
        const precioCompra = parseFloat(precioCompraInput.value) || 0;
        const precioVenta = parseFloat(precioVentaInput.value) || 0;
        const ganancia = precioVenta - precioCompra;
        
        gananciaInput.value = ganancia.toFixed(2);
        
        // Calcular porcentaje de ganancia
        if (precioCompra > 0) {
            const porcentaje = ((ganancia / precioCompra) * 100).toFixed(2);
            porcentajeGanancia.textContent = `${porcentaje}% de margen de ganancia`;
            
            // Colores según el porcentaje
            if (porcentaje < 0) {
                porcentajeGanancia.className = 'text-xs text-red-500 mt-1';
            } else if (porcentaje < 20) {
                porcentajeGanancia.className = 'text-xs text-yellow-500 mt-1';
            } else {
                porcentajeGanancia.className = 'text-xs text-green-500 mt-1';
            }
        } else {
            porcentajeGanancia.textContent = '';
        }
    }

    // Event listeners para calcular ganancia
    precioCompraInput.addEventListener('input', calcularGanancia);
    precioVentaInput.addEventListener('input', calcularGanancia);

    // Llenar colores y marcar el seleccionado
    colores.forEach(color => {
        const option = document.createElement('option');
        option.value = color;
        option.textContent = color;
        if (color === "{{ old('color', $producto->color) }}") {
            option.selected = true;
        }
        selectColor.appendChild(option);
    });

    const tallasNinos = ['2', '4', '6', '8', '10', '12', '14'];
    const tallasAdultos = ['S', 'M', 'L', 'XL', 'XXL'];

    function llenarTallas(tipo) {
        tallaSelect.innerHTML = '<option value="">Selecciona una talla</option>';
        let tallas = [];

        if (tipo === 'niño' || tipo === 'niña') {
            tallas = tallasNinos;
        } else if (tipo === 'hombre' || tipo === 'mujer') {
            tallas = tallasAdultos;
        }

        tallas.forEach(talla => {
            const option = document.createElement('option');
            option.value = talla;
            option.textContent = talla;
            if (talla === "{{ old('talla', $producto->talla) }}") {
                option.selected = true;
            }
            tallaSelect.appendChild(option);
        });
    }

    // Actualizar tallas al cambiar tipo
    tipoSelect.addEventListener('change', function () {
        llenarTallas(this.value);
    });

    // Inicializar
    llenarTallas(tipoSelect.value);
    calcularGanancia(); // Calcular ganancia inicial
});
</script>
@endsection