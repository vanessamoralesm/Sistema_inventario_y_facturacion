@extends('layoutprincipal')

@section('contenido')
<br>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" style="color: #5c5b5b;">Productos</a></li>
        <li class="breadcrumb-item active" aria-current="page" style="color: #3d3a3a;">Editar Producto</li>
    </ol>
</nav>

<div style="display: flex; align-items: center; gap: 12px;">
    <img src="{{ asset('IMG/tienda-de-ropa.gif') }}" alt="productos" width="150" height="150" style="border-radius: 50%; object-fit: cover;">
    <h5 class="text-big" style="margin: 0;"><strong>Editar Producto</strong></h5>
</div>

<br>

<div class="container" style="max-width: 700px;">
    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Nombre -->
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre del producto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <!-- Marca -->
            <div class="col-md-6 mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca', $producto->marca) }}" required>
            </div>


            <div class="col-md-6 mb-3">
                <label for="imagen" class="form-label">Foto (Opcional):</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                <small class="form-text text-muted">Dejar vacío si no desea cambiar la imagen.</small>

                @if($producto->imagen)
                    <div class="mt-2">
                        <label>Imagen actual:</label><br>
                        <img src="{{ asset('IMG/' . $producto->imagen) }}" alt="Imagen actual" style="width: 100px; height: auto; border-radius: 8px;">
                    </div>
                @endif
            </div>

        </div>

        <!-- Detalle -->
        <div class="mb-3">
            <label for="detalle" class="form-label">Detalle del producto:</label>
            <textarea class="form-control" id="detalle" name="detalle" rows="2" required>{{ old('detalle', $producto->detalle) }}</textarea>
        </div>

        <!-- Precio y Cantidad -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" min="0" step="0.01" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Cantidad disponible:</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" min="0" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="precio_compra" class="form-label">Precio de compra:</label>
                <input type="number" class="form-control" id="precio_compra" name="precio_compra" value="{{ old('precio_compra', $producto->precio_compra) }}" min="0" step="0.01" required>
            </div>
        </div>

        <!-- Tipo -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Selecciona un tipo</option>
                <option value="niño" {{ old('tipo', $producto->tipo) == 'niño' ? 'selected' : '' }}>Niño</option>
                <option value="niña" {{ old('tipo', $producto->tipo) == 'niña' ? 'selected' : '' }}>Niña</option>
                <option value="hombre" {{ old('tipo', $producto->tipo) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                <option value="mujer" {{ old('tipo', $producto->tipo) == 'mujer' ? 'selected' : '' }}>Mujer</option>
            </select>
        </div>


        <!-- Talla -->
        <div class="mb-3">
            <label for="talla" class="form-label">Talla:</label>
            <select class="form-select" id="talla" name="talla" required>
                <!-- Las opciones se llenan con JS -->
            </select>
        </div>

        <!-- Color -->
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <select class="form-select" name="color" id="color" required>
                <!-- Se llenan con JS -->
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('productos.index') }}" class="btn btn-danger animated-button">Cancelar</a>
            <button type="submit" class="btn btn-danger animated-button">Actualizar Producto</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const colores = ['Blanco', 'Negro', 'Gris', 'Azul', 'Rojo', 'Verde', 'Amarillo', 'Rosado', 'Naranja', 'Marrón', 'Morado', 'Celeste'];
    const selectColor = document.getElementById('color');
    const tallaSelect = document.getElementById('talla');
    const tipoSelect = document.getElementById('tipo');

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

    // Inicializar tallas y color al cargar la página
    llenarTallas(tipoSelect.value);
});
</script>
@endsection
