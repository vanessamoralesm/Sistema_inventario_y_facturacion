@extends('layoutprincipal')

@section('contenido')
<div class="container">
    <form action="{{ route('facturas.store') }}" method="POST">
        @csrf

        {{-- DATOS GENERALES --}}
        <h4 class="mb-4">Datos Generales</h4>
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-4">
                <label>Usuario</label>
                <input type="text" class="form-control" value="{{ auth()->user()->cedula }} - {{ auth()->user()->nombre }}" readonly>
                <input type="hidden" name="cedula_usuario" value="{{ auth()->user()->cedula }}">
            </div>

            <div class="col-md-4">
                <label>Fecha</label>
                <input type="text" name="fecha" class="form-control" value="{{ now()->setTimezone('America/Managua')->format('Y-m-d H:i') }}" readonly>
            </div>

            <div class="col-md-4">
                <label>Cliente</label>
                <div class="input-group" id="clien">
                    <select name="cedula_cliente" class="form-control select2" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->cedula }}">
                                {{ $cliente->cedula }} - {{ $cliente->nombre }} - {{ $cliente->celular }}
                            </option>
                        @endforeach
                    </select>
                    <a href="{{ route('clientes.create') }}" class="btn btn-danger animated-button" style="width: 70px;">+</a>
                </div>
            </div>
        </div>

        <br><br>

        {{-- DETALLES DE LA VENTA --}}
        <h4 class="mb-4">Detalles de la Venta</h4>
        <br>
        <div class="row">
            {{-- Selección de productos --}}
            <div class="col-md-5">
                <div class="form-group mb-3">
                    <label>Producto</label>
                    <select id="producto-select" class="form-control select2">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-stock="{{ $producto->stock }}" data-precio="{{ $producto->precio }}">
                                {{ $producto->id }} - {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label>Stock / Precio</label>
                        <div class="input-group">
                            <input type="number" id="stock" class="form-control" placeholder="Stock" readonly>
                            <input type="number" id="precio" class="form-control" placeholder="Precio" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Cantidad / Descuento %</label>
                        <div class="input-group">
                            <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1" oninput="actualizarSubtotal()">
                            <input type="number" id="descuento" class="form-control" placeholder="Desc %" min="0" max="100" oninput="actualizarSubtotal()">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Método de Pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Subtotal</label>
                    <input type="number" id="subtotal" class="form-control" readonly>
                </div>

                <div class="form-group text-end">
                    <button type="button" class="btn btn-success" onclick="agregarProducto()">Agregar al carrito</button>
                </div>
            </div>

            {{-- Tabla de carrito y totales --}}
            <div class="col-md-7">
                <table class="table table-bordered table-striped" id="detalle-tabla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant</th>
                            <th>Precio</th>
                            <th>Desc%</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <table class="table">
                    <tr>
                        <td class="text-end"><strong>Subtotal:</strong></td>
                        <td id="suma">0.00</td>
                    </tr>
                    <tr>
                        <td class="text-end"><strong>IVA (15%):</strong></td>
                        <td id="iva">0.00</td>
                    </tr>
                    <tr>
                        <td class="text-end"><strong>Total:</strong></td>
                        <td id="total">0.00</td>
                    </tr>
                </table>

                {{-- Pago debajo de la tabla --}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Monto Recibido</label>
                        <input type="number" step="0.01" name="monto_recibido" class="form-control" required oninput="calcularVuelto()">
                    </div>
                    <div class="col-md-6">
                        <label>Vuelto</label>
                        <input type="number" step="0.01" name="vuelto" id="vuelto" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="row mt-4 d-flex justify-content-end">
            <div class="col-md-4 d-flex gap-4 justify-content-end">
                <button type="submit" class="btn btn-primary" id="btn-emitir-factura">EMITIR FACTURA</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </div>
    </form>
</div>

{{-- ESTILOS --}}
<style>
    h4 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #000000;
        text-align: center;
        margin-bottom: 1rem;
    }
    label {
        font-size: 1.2rem;
        font-weight: 600;
        color: #000000;
    }
</style>

{{-- SCRIPTS --}}
<script>
    const IVA = 0.15;
    let productos = [];

    document.getElementById('producto-select').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('stock').value = selected.dataset.stock || '';
        document.getElementById('precio').value = selected.dataset.precio || '';
        document.getElementById('cantidad').value = '';
        document.getElementById('descuento').value = '';
        document.getElementById('subtotal').value = '';
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

    document.querySelector('input[name="monto_recibido"]').addEventListener('input', calcularVuelto);

    function calcularVuelto() {
        // 1. Obtener los elementos que necesitamos
        const montoInput = document.querySelector('input[name="monto_recibido"]');
        const vueltoInput = document.getElementById('vuelto');
        const emitirBtn = document.getElementById('btn-emitir-factura'); 

        // 2. Obtener los valores
        const montoRecibido = parseFloat(montoInput.value) || 0;
        const total = parseFloat(document.getElementById('total').innerText) || 0;

        // 3. Lógica de validación
        const vuelto = montoRecibido - total;

        if (total === 0) {
            // Caso 1: El carrito está vacío
            vueltoInput.value = '0.00';
            emitirBtn.disabled = true;
            emitirBtn.innerText = 'Agregue productos';
            montoInput.classList.remove('is-invalid');

        } else if (montoRecibido >= total) {
            // Caso 2: Válido, el monto es suficiente
            vueltoInput.value = vuelto.toFixed(2);
            emitirBtn.disabled = false;
            emitirBtn.innerText = 'EMITIR FACTURA';
            montoInput.classList.remove('is-invalid'); // Quita el borde rojo (Bootstrap)

        } else {
            // Caso 3: Inválido, el monto es insuficiente
            vueltoInput.value = '0.00';
            emitirBtn.disabled = true;
            emitirBtn.innerText = 'Monto insuficiente';
            montoInput.classList.add('is-invalid'); // Pone un borde rojo (Bootstrap)
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
            alert('Datos inválidos');
            return;
        }

        const subtotalCalculado = cantidad * precio * (1 - descuento / 100);
        if (Math.abs(subtotal - subtotalCalculado) > 0.01) {
            alert('El subtotal no coincide con el cálculo');
            return;
        }

        productos.push({ productoId, cantidad, precio, descuento, subtotal });

        const row = `<tr>
            <td>${productoText}<input type="hidden" name="productos[]" value="${productoId}|${cantidad}|${precio}|${descuento}|${subtotal}"></td>
            <td>${cantidad}</td>
            <td>${precio.toFixed(2)}</td>
            <td>${descuento.toFixed(2)}</td>
            <td>${subtotal.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
        </tr>`;

        document.querySelector('#detalle-tabla tbody').insertAdjacentHTML('beforeend', row);
        actualizarTotales();
        calcularVuelto();
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
            const subtotal = parseFloat(tr.cells[4].innerText) || 0;
            suma += subtotal;
        });

        const iva = suma * IVA;
        const total = suma + iva;

        document.getElementById('suma').innerText = suma.toFixed(2);
        document.getElementById('iva').innerText = iva.toFixed(2);
        document.getElementById('total').innerText = total.toFixed(2);
        calcularVuelto();
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $('.select2') !== 'undefined' && $.fn.select2) {
            $('.select2').select2();
        }
        actualizarTotales();
    });
</script>
@endsection
