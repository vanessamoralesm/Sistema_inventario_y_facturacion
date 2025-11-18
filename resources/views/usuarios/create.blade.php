@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm px-4 py-3 border border-blue-100">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center font-medium">
                        <i class="fas fa-home mr-2 text-blue-500"></i>
                        Inicio
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <a href="{{ route('usuarios.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors font-medium">
                        Usuarios
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Agregar Usuario</span>
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
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('IMG/clasificacion.gif') }}" 
                             alt="icono usuarios" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-white">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Agregar Nuevo Usuario</h1>
                    <p class="text-gray-600 text-sm">Complete la información del nuevo usuario del sistema</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user text-blue-500 mr-1"></i>
                            Nombre Completo
                        </label>
                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nombre') border-red-500 @enderror"
                            placeholder="Ingrese nombre y apellidos"
                            value="{{ old('nombre') }}"
                            required
                        >
                        @error('nombre')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Cédula -->
                    <div>
                        <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card text-blue-500 mr-1"></i>
                            Cédula
                        </label>
                        <input
                            type="text"
                            name="cedula"
                            id="cedula"
                            maxlength="20"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('cedula') border-red-500 @enderror"
                            placeholder="Ingrese número de cédula"
                            value="{{ old('cedula') }}"
                            required
                        >
                        @error('cedula')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-blue-500 mr-1"></i>
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="usuario@ejemplo.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-500 mr-1"></i>
                            Contraseña
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                                placeholder="Ingrese contraseña"
                                required
                            >
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-500 mr-1"></i>
                            Confirmar Contraseña
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Confirme la contraseña"
                                required
                            >
                            <button type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rol -->
                <div>
                    <label for="rol_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tag text-blue-500 mr-1"></i>
                        Rol del Usuario
                    </label>
                    <select
                        name="rol_id"
                        id="rol_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('rol_id') border-red-500 @enderror"
                        required
                    >
                        <option value="" hidden>Seleccione un rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                {{ $rol->tipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <div class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('usuarios.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center justify-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-colors duration-200 font-medium flex items-center justify-center space-x-2 shadow-md">
                        <i class="fas fa-save"></i>
                        <span>Guardar Usuario</span>
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
    // Función para mostrar/ocultar contraseña
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye');
        
        if (field.type === 'password') {
            field.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    // Validación en tiempo real para la cédula 
    document.getElementById('cedula')?.addEventListener('input', function(e) {
        
        let value = this.value.replace(/[^0-9a-zA-Z]/g, '').toUpperCase();

        if (value.length === 14 && /[^A-Z]/.test(value.charAt(13))) {
            value = value.substring(0, 13);
        }
        value = value.substring(0, 14);
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 3);
        }
        if (value.length > 3) {
            formattedValue += '-' + value.substring(3, 9);
        }
        if (value.length > 9) {
            formattedValue += '-' + value.substring(9, 13);
        }
        if (value.length > 13) {
            formattedValue += value.substring(13, 14);
        }
        this.value = formattedValue;
    });

    // Efecto de carga suave
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.style.opacity = '0';
            setTimeout(() => {
                form.style.transition = 'opacity 0.3s ease-in-out';
                form.style.opacity = '1';
            }, 100);
        }

        // Validación de contraseñas coincidentes
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        function validatePasswords() {
            if (password.value && confirmPassword.value && password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#ef4444';
            } else {
                confirmPassword.style.borderColor = '#d1d5db';
            }
        }

        password?.addEventListener('input', validatePasswords);
        confirmPassword?.addEventListener('input', validatePasswords);
    });
</script>
@endsection