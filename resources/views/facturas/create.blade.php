@extends('layoutprincipal')

@section('title', 'Crear Factura')
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
                    <a href="{{ route('facturas.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors font-medium">
                        Facturas
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Nueva Factura</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-invoice text-white text-xl"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Crear Nueva Factura</h1>
                        <p class="text-gray-600 text-sm">Complete la información para emitir una nueva factura</p>
                    </div>
                </div>
                <div class="flex justify-start sm:justify-end">
                    <a href="{{ route('facturas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 min-w-[120px] text-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('facturas.store') }}" method="POST" id="facturaForm">
            @csrf
            
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Columna Izquierda - Datos Generales -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Datos Generales -->
                    <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                            Datos Generales
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Usuario -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user text-purple-500 mr-1"></i>
                                    Usuario
                                </label>
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                        {{ substr(auth()->user()->nombre, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-sm font-medium text-gray-900 truncate block">{{ auth()->user()->nombre }}</span>
                                        <div class="text-xs text-gray-500 truncate">{{ auth()->user()->cedula }}</div>
                                    </div>
                                </div>
                                <input type="hidden" name="cedula_usuario" value="{{ auth()->user()->cedula }}">
                            </div>

                            <!-- Fecha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar text-purple-500 mr-1"></i>
                                    Fecha y Hora
                                </label>
                                <input type="text" name="fecha" 
                                       class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                                       value="{{ now()->setTimezone('America/Managua')->format('Y-m-d H:i') }}" 
                                       readonly>
                            </div>

                            <!-- Cliente - DISEÑO CORREGIDO -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-users text-purple-500 mr-1"></i>
                                    Cliente *
                                </label>
                                <div class="flex space-x-2 items-stretch">
                                    <select name="cedula_cliente" 
                                            id="cedula_cliente"
                                            class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm min-w-0"
                                            required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->cedula }}">
                                                {{ $cliente->cedula }} - {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" 
                                            onclick="abrirModalCliente()"
                                            class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-3 rounded-lg transition-colors duration-300 flex items-center justify-center whitespace-nowrap min-w-[42px]"
                                            title="Agregar Nuevo Cliente">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Método de Pago -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-credit-card text-purple-500 mr-1"></i>
                                    Método de Pago
                                </label>
                                <select name="metodo_pago" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                                        required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-money-bill-wave text-purple-500 mr-2"></i>
                            Información de Pago
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Monto Recibido -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-hand-holding-usd text-green-500 mr-1"></i>
                                    Monto Recibido
                                </label>
                                <input type="number" step="0.01" name="monto_recibido" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 text-sm"
                                       required 
                                       oninput="calcularVuelto()"
                                       placeholder="0.00">
                            </div>

                            <!-- Vuelto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-exchange-alt text-blue-500 mr-1"></i>
                                    Vuelto
                                </label>
                                <input type="number" step="0.01" name="vuelto" id="vuelto" 
                                       class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none transition-all duration-300 text-sm"
                                       readonly
                                       placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Productos y Carrito -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Selección de Productos -->
                    <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-shopping-cart text-purple-500 mr-2"></i>
                            Agregar Productos
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                            <!-- Producto -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Producto</label>
                                <select id="producto-select" 
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm">
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-stock="{{ $producto->stock }}" 
                                                data-precio="{{ $producto->precio }}"
                                                data-nombre="{{ $producto->nombre }}">
                                            {{ $producto->id }} - {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stock y Precio -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                                    <input type="number" id="stock" 
                                           class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none transition-all duration-300 text-sm"
                                           readonly
                                           placeholder="Stock">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio</label>
                                    <input type="number" id="precio" 
                                           class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none transition-all duration-300 text-sm"
                                           readonly
                                           placeholder="Precio">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                            <!-- Cantidad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                                <input type="number" id="cantidad" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm"
                                       min="1" 
                                       oninput="actualizarSubtotal()"
                                       placeholder="Cantidad">
                            </div>

                            <!-- Descuento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Descuento %</label>
                                <input type="number" id="descuento" 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 text-sm"
                                       min="0" 
                                       max="100" 
                                       oninput="actualizarSubtotal()"
                                       placeholder="0">
                            </div>

                            <!-- Subtotal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subtotal</label>
                                <input type="number" id="subtotal" 
                                       class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none transition-all duration-300 text-sm"
                                       readonly
                                       placeholder="0.00">
                            </div>
                        </div>

                        <button type="button" 
                                onclick="agregarProducto()"
                                class="w-full bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600 text-white py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 text-sm">
                            <i class="fas fa-cart-plus"></i>
                            <span>Agregar al Carrito</span>
                        </button>
                    </div>

                    <!-- Carrito de Compras -->
                    <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-receipt text-purple-500 mr-2"></i>
                            Detalles de la Venta
                        </h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[600px]" id="detalle-tabla">
                                <thead class="bg-gradient-to-r from-purple-500 to-indigo-500">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Producto</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Cant</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Precio</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Desc%</th>
                                        <th class="px-3 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Subtotal</th>
                                        <th class="px-3 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Las filas se agregarán dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Totales -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-base font-semibold">
                                <div class="text-center md:text-right">
                                    <span class="text-gray-600 text-sm">Subtotal:</span>
                                    <div class="text-green-600" id="suma">C$ 0.00</div>
                                </div>
                                <div class="text-center">
                                    <span class="text-gray-600 text-sm">IVA (15%):</span>
                                    <div class="text-blue-600" id="iva">C$ 0.00</div>
                                </div>
                                <div class="text-center md:text-left">
                                    <span class="text-gray-600 text-sm">Total:</span>
                                    <div class="text-purple-600" id="total">C$ 0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
                        <div class="flex flex-col sm:flex-row justify-end gap-3">
                            <button type="submit" 
                                    id="btn-emitir-factura"
                                    class="bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 min-w-[160px] disabled:opacity-50 disabled:cursor-not-allowed text-sm"
                                    disabled>
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>EMITIR FACTURA</span>
                            </button>
                            <a href="{{ route('facturas.index') }}" 
                               class="bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center space-x-2 min-w-[160px] text-sm">
                                <i class="fas fa-times"></i>
                                <span>CANCELAR</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Agregar Cliente -->
<div id="modalCliente" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <!-- Header del Modal -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-6 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Agregar Nuevo Cliente</h3>
                        <p class="text-purple-100 text-sm">Complete los datos del cliente</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="cerrarModalCliente()"
                        class="text-white hover:text-purple-200 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Formulario del Modal -->
        <form id="formClienteModal" class="p-6">
            @csrf
            <div class="space-y-4">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-purple-500 mr-2"></i>
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="modal_nombre"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                           placeholder="Ej: María González López"
                           required>
                </div>

                <!-- Cédula -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card text-purple-500 mr-2"></i>
                        Cédula *
                    </label>
                    <input type="text" 
                           name="cedula" 
                           id="modal_cedula"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                           maxlength="20"
                           placeholder="Ej: 1234567890"
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-purple-500 mr-2"></i>
                        Correo Electrónico *
                    </label>
                    <input type="email" 
                           name="correo" 
                           id="modal_correo"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                           placeholder="Ej: cliente@ejemplo.com"
                           required>
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-home text-purple-500 mr-2"></i>
                        Dirección *
                    </label>
                    <input type="text" 
                           name="direccion" 
                           id="modal_direccion"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                           placeholder="Ej: Calle Principal #123"
                           required>
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone text-purple-500 mr-2"></i>
                        Teléfono *
                    </label>
                    <input type="tel" 
                           name="telefono" 
                           id="modal_telefono"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm"
                           placeholder="Ej: 555-123-4567"
                           required>
                </div>
            </div>

            <!-- Botones del Modal -->
            <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" 
                        onclick="cerrarModalCliente()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors text-sm font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button type="button" 
                        onclick="guardarCliente()"
                        class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors text-sm font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    const IVA = 0.15;
    let productos = [];

    // Funciones para el modal de cliente
    function abrirModalCliente() {
        document.getElementById('modalCliente').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalCliente() {
        document.getElementById('modalCliente').classList.add('hidden');
        document.body.style.overflow = 'auto';
        // Limpiar formulario
        document.getElementById('formClienteModal').reset();
    }

    async function guardarCliente() {
        const formData = new FormData(document.getElementById('formClienteModal'));
        
        try {
            const response = await fetch('{{ route("clientes.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Cliente creado exitosamente
                cerrarModalCliente();
                
                // Agregar el nuevo cliente al select
                const select = document.getElementById('cedula_cliente');
                const newOption = new Option(
                    `${data.cliente.cedula} - ${data.cliente.nombre}`,
                    data.cliente.cedula,
                    true,
                    true
                );
                select.add(newOption);
                
                // Mostrar mensaje de éxito
                mostrarMensaje('Cliente agregado exitosamente', 'success');
            } else {
                // Mostrar errores de validación
                if (data.errors) {
                    let errorMessage = 'Errores en el formulario:\n';
                    for (const field in data.errors) {
                        errorMessage += `• ${data.errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                } else {
                    alert(data.message || 'Error al crear el cliente');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión. Intente nuevamente.');
        }
    }

    function mostrarMensaje(mensaje, tipo) {
        // Crear elemento de mensaje
        const mensajeDiv = document.createElement('div');
        mensajeDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        mensajeDiv.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i>
                <span>${mensaje}</span>
            </div>
        `;
        
        document.body.appendChild(mensajeDiv);
        
        // Remover mensaje después de 3 segundos
        setTimeout(() => {
            mensajeDiv.remove();
        }, 3000);
    }

    // Inicializar eventos cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Evento para actualizar stock y precio cuando se selecciona un producto
        document.getElementById('producto-select').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('stock').value = selected.dataset.stock || '';
            document.getElementById('precio').value = selected.dataset.precio || '';
            document.getElementById('cantidad').value = '';
            document.getElementById('descuento').value = '';
            document.getElementById('subtotal').value = '';
        });

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModalCliente();
            }
        });

        // Inicializar cálculos
        actualizarTotales();
    });

    function actualizarSubtotal() {
        const precio = parseFloat(document.getElementById('precio').value) || 0;
        const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        
        if (cantidad > 0 && precio > 0) {
            const totalPorProducto = cantidad * precio;
            const descuentoValor = totalPorProducto * (descuento / 100);
            const subtotal = totalPorProducto - descuentoValor;
            document.getElementById('subtotal').value = subtotal.toFixed(2);
        } else {
            document.getElementById('subtotal').value = '0.00';
        }
    }

    function calcularVuelto() {
        const montoInput = document.querySelector('input[name="monto_recibido"]');
        const vueltoInput = document.getElementById('vuelto');
        const emitirBtn = document.getElementById('btn-emitir-factura'); 

        const montoRecibido = parseFloat(montoInput.value) || 0;
        const total = parseFloat(document.getElementById('total').innerText.replace('C$ ', '')) || 0;

        const vuelto = montoRecibido - total;

        if (total === 0) {
            vueltoInput.value = '0.00';
            emitirBtn.disabled = true;
            emitirBtn.innerHTML = '<i class="fas fa-file-invoice-dollar"></i><span>Agregue productos</span>';
            montoInput.classList.remove('is-invalid');
        } else if (montoRecibido >= total) {
            vueltoInput.value = vuelto.toFixed(2);
            emitirBtn.disabled = false;
            emitirBtn.innerHTML = '<i class="fas fa-file-invoice-dollar"></i><span>EMITIR FACTURA</span>';
            montoInput.classList.remove('is-invalid');
        } else {
            vueltoInput.value = '0.00';
            emitirBtn.disabled = true;
            emitirBtn.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Monto insuficiente</span>';
            montoInput.classList.add('is-invalid');
        }
    }

    function agregarProducto() {
        const select = document.getElementById('producto-select');
        const productoId = select.value;
        
        if (!productoId) {
            alert('Seleccione un producto');
            return;
        }

        const productoText = select.options[select.selectedIndex].text;
        const stock = parseFloat(document.getElementById('stock').value);
        const precio = parseFloat(document.getElementById('precio').value);
        const cantidad = parseFloat(document.getElementById('cantidad').value);
        const descuento = parseFloat(document.getElementById('descuento').value) || 0;
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;

        if (!cantidad || cantidad <= 0 || cantidad > stock || descuento < 0 || descuento > 100) {
            alert('Datos inválidos. Verifique la cantidad y el descuento.');
            return;
        }

        const subtotalCalculado = cantidad * precio * (1 - descuento / 100);
        if (Math.abs(subtotal - subtotalCalculado) > 0.01) {
            alert('El subtotal no coincide con el cálculo');
            return;
        }

        productos.push({ productoId, cantidad, precio, descuento, subtotal });

        const row = `<tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="px-3 py-2 text-sm text-gray-900 min-w-[200px]">
                <div class="truncate">${productoText}</div>
                <input type="hidden" name="productos[]" value="${productoId}|${cantidad}|${precio}|${descuento}|${subtotal}">
            </td>
            <td class="px-3 py-2 text-sm text-gray-900 text-center">${cantidad}</td>
            <td class="px-3 py-2 text-sm text-gray-900">C$ ${precio.toFixed(2)}</td>
            <td class="px-3 py-2 text-sm text-gray-900 text-center">${descuento.toFixed(2)}%</td>
            <td class="px-3 py-2 text-sm font-semibold text-green-600">C$ ${subtotal.toFixed(2)}</td>
            <td class="px-3 py-2 text-center">
                <button type="button" 
                        onclick="eliminarFila(this)" 
                        class="bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white p-2 rounded transition-colors duration-300 flex items-center justify-center w-8 h-8"
                        title="Eliminar producto">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </td>
        </tr>`;

        document.querySelector('#detalle-tabla tbody').insertAdjacentHTML('beforeend', row);
        actualizarTotales();
        calcularVuelto();
        
        // Limpiar campos
        select.value = '';
        document.getElementById('stock').value = '';
        document.getElementById('precio').value = '';
        document.getElementById('cantidad').value = '';
        document.getElementById('descuento').value = '';
        document.getElementById('subtotal').value = '';
    }

    function eliminarFila(btn) {
        btn.closest('tr').remove();
        actualizarTotales();
        calcularVuelto();
    }

    function actualizarTotales() {
        let suma = 0;
        const rows = document.querySelectorAll('#detalle-tabla tbody tr');
        rows.forEach(tr => {
            const subtotalText = tr.cells[4].innerText.replace('C$ ', '');
            const subtotal = parseFloat(subtotalText) || 0;
            suma += subtotal;
        });

        const iva = suma * IVA;
        const total = suma + iva;

        document.getElementById('suma').innerText = `C$ ${suma.toFixed(2)}`;
        document.getElementById('iva').innerText = `C$ ${iva.toFixed(2)}`;
        document.getElementById('total').innerText = `C$ ${total.toFixed(2)}`;
        calcularVuelto();
    }
</script>

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
    
    input:focus, select:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(147, 51, 234, 0.1);
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
    
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Mejorar el responsive */
    @media (max-width: 1280px) {
        .grid-cols-1.xl\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection