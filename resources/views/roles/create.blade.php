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
                    <a href="{{ route('roles.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors font-medium">
                        Roles
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Agregar Rol</span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Agregar Nuevo Rol</h1>
                    <p class="text-gray-600 text-sm">Complete la información del nuevo rol del sistema</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6">
            <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre del Rol -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tag text-purple-500 mr-1"></i>
                        Nombre del Rol
                    </label>
                    <input
                        type="text"
                        name="tipo"
                        id="tipo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('tipo') border-red-500 @enderror"
                        placeholder="Ej. Administrador, Vendedor, Supervisor..."
                        value="{{ old('tipo') }}"
                        required
                    >
                    @error('tipo')
                        <div class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-lightbulb text-purple-400 mr-1"></i>
                        El nombre del rol debe ser descriptivo y único en el sistema
                    </p>
                </div>

                <!-- Información adicional -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-purple-500 text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-purple-800 mb-1">Información importante</h4>
                            <ul class="text-xs text-purple-600 space-y-1">
                                <li class="flex items-start space-x-2">
                                    <i class="fas fa-check-circle text-purple-400 mt-0.5 text-xs"></i>
                                    <span>Los roles definen los permisos de acceso en el sistema</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <i class="fas fa-check-circle text-purple-400 mt-0.5 text-xs"></i>
                                    <span>Evite nombres genéricos como "Usuario" o "Rol"</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('roles.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium flex items-center justify-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200 font-medium flex items-center justify-center space-x-2 shadow-md">
                        <i class="fas fa-save"></i>
                        <span>Guardar Rol</span>
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
    
    /* Animación de entrada suave */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
</style>

<script>
    // Efecto de carga suave
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.classList.add('animate-fade-in-up');
        }

        // Validación en tiempo real
        const tipoInput = document.getElementById('tipo');
        tipoInput?.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.remove('border-red-500');
            }
        });

        // Prevenir envío duplicado
        let formSubmitted = false;
        form?.addEventListener('submit', function(e) {
            if (formSubmitted) {
                e.preventDefault();
                return;
            }
            
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
            }
            
            formSubmitted = true;
        });
    });
</script>
@endsection