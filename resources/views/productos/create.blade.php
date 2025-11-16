@extends('layoutprincipal')

@section('contenido')
<br>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" style="color: #5c5b5b;">Producos</a></li>
        <li class="breadcrumb-item active" aria-current="page" style="color: #3d3a3a;">Agregar Productos</li>
    </ol>
</nav>

<div style="display: flex; align-items: center; gap: 12px;">
    <img src="{{ asset('IMG/tienda-de-ropa.gif') }}" alt="productos" width="150" height="150" style="border-radius: 50%; object-fit: cover;">
    <h5 class="text-big" style="margin: 0;"><strong>Agregar Producto</strong></h5>
</div>

<br>

<div class="container" style="max-width: 700px;">
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Nombre -->
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre del producto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" name="marca" class="form-control" id="marca" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="imagen" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
        </div>



        <!-- Detalle -->
        <div class="mb-3">
            <label for="detalle" class="form-label">Detalle del producto:</label>
            <textarea class="form-control" id="detalle" name="detalle" rows="2" required></textarea>
        </div>

        <!-- Precio y Cantidad -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Cantidad disponible:</label>
                <input type="number" class="form-control" id="stock" name="stock" min="0" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="precio_compra" class="form-label">Precio de compra:</label>
                <input type="number" class="form-control" id="precio_compra" name="precio_compra" min="0" step="0.01" required>
            </div>
        </div>

        <!-- Tipo de público -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Selecciona un tipo</option>
                <option value="niño">Niño</option>
                <option value="niña">Niña</option>
                <option value="hombre">Hombre</option>
                <option value="mujer">Mujer</option>
            </select>
        </div>

        <!-- Talla -->
        <div class="mb-3">
            <label for="talla" class="form-label">Talla:</label>
            <select class="form-select" id="talla" name="talla" required>
                <option value="">Selecciona una talla</option>
            </select>
        </div>

        <!-- Color -->
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <select class="form-select" name="color" id="color" required>
                <option value="">Selecciona un color</option>
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('productos.index') }}" class="btn btn-danger animated-button">Cancelar</a>
            <button type="submit" class="btn btn-danger animated-button">Guardar Producto</button>
        </div>
    </form>
</div>


<!-- Agrega el script al final del archivo -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colores = ['Blanco', 'Negro', 'Gris', 'Azul', 'Rojo', 'Verde', 'Amarillo', 'Rosado', 'Naranja', 'Marrón', 'Morado', 'Celeste'];
        const selectColor = document.getElementById('color');
        colores.forEach(color => {
            const option = document.createElement('option');
            option.value = color;
            option.textContent = color;
            selectColor.appendChild(option);
        });

        const tallasNinos = ['2', '4', '6', '8', '10', '12', '14'];
        const tallasAdultos = ['S', 'M', 'L', 'XL', 'XXL'];

        const tipoSelect = document.getElementById('tipo');
        const tallaSelect = document.getElementById('talla');

        tipoSelect.addEventListener('change', function () {
            const tipo = this.value;
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
                tallaSelect.appendChild(option);
            });
        });
    });
</script>

@endsection
