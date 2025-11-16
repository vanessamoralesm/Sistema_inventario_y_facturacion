@extends('layoutprincipal')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50 py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol  class="flex items-center space-x-2 text-sm px-4 py-3 border border-purple-100">
                <li>
                    <a href="{{ route('clientes.index') }}" 
                       class="text-purple-600 hover:text-purple-800 transition-colors flex items-center font-medium">
                        <i class="fas fa-users mr-2 text-purple-500"></i>
                        Clientes
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Agregar Cliente</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('IMG/target.gif') }}" 
                             alt="Agregar Cliente" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-white">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </div>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Agregar Nuevo Cliente</h1>
                    <p class="text-gray-600 text-sm">
                        Completa la información requerida para registrar un nuevo cliente.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">

            <!-- Form Content Reducido -->
            <form action="{{ route('clientes.store') }}" method="POST" class="p-6">
                @csrf

                <!-- Nombre y Cédula -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-user text-purple-500 mr-2 text-sm"></i>
                            Nombre Completo *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   value="{{ old('nombre') }}"
                                   class="w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                                   placeholder="Ej: María González López"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                        </div>
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Cédula -->
                    <div>
                        <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-id-card text-purple-500 mr-2 text-sm"></i>
                            Cédula *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="cedula" 
                                   id="cedula" 
                                   value="{{ old('cedula') }}"
                                   class="w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                                   maxlength="20"
                                   placeholder="Ej: 1234567890"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-id-card text-sm"></i>
                            </div>
                        </div>
                        @error('cedula')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-envelope text-purple-500 mr-2 text-sm"></i>
                        Correo Electrónico *
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="correo" 
                               id="email" 
                               value="{{ old('correo') }}"
                               class="w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                               placeholder="Ej: cliente@ejemplo.com"
                               required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                    </div>
                    @error('correo')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Dirección y Teléfono -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Dirección -->
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-home text-purple-500 mr-2 text-sm"></i>
                            Dirección *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="direccion" 
                                   id="direccion" 
                                   value="{{ old('direccion') }}"
                                   class="w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                                   placeholder="Ej: Calle Principal #123"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-home text-sm"></i>
                            </div>
                        </div>
                        @error('direccion')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-phone text-purple-500 mr-2 text-sm"></i>
                            Teléfono *
                        </label>
                        <div class="relative">
                            <input type="tel" 
                                   name="telefono" 
                                   id="telefono" 
                                   value="{{ old('telefono') }}"
                                   class="w-full px-3 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50"
                                   placeholder="Ej: 555-123-4567"
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                        </div>
                        @error('telefono')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons Reducidos -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-purple-100">
                    <a href="{{ route('clientes.index') }}" 
                       class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors text-sm font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-5 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors text-sm font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection