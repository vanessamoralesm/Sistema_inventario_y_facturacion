@extends('layoutprincipal')

@section('contenido')
<div class="min-h-screen bg-purple-50 py-6">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm bg-white rounded-lg shadow-sm px-4 py-3">
                <li>
                    <a href="{{ route('clientes.index') }}" class="text-purple-600 hover:text-purple-800 transition-colors flex items-center font-medium">
                        <i class="fas fa-users mr-2"></i>
                        Clientes
                    </a>
                </li>
                <li class="flex items-center text-gray-400">
                    <i class="fas fa-chevron-right text-xs mx-2"></i>
                    <span class="text-gray-700 font-semibold">Editar Cliente</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Editar Cliente</h1>
                    <p class="text-gray-600 text-sm">Actualiza la información de {{ $cliente->nombre }}</p>
                    <div class="flex items-center space-x-3 mt-2">
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-medium">
                            <i class="fas fa-id-card mr-1"></i>{{ $cliente->cedula }}
                        </span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                            <i class="fas fa-phone mr-1"></i>{{ $cliente->telefono }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-6 py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-cog text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Modificar Información</h2>
                        <p class="text-blue-100 text-xs">Actualiza los datos del cliente</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Content -->
            <form action="{{ route('clientes.update', $cliente->cedula) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Nombre y Cédula -->
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-user text-blue-500 mr-2"></i>
                            Nombre Completo *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   value="{{ $cliente->nombre }}"
                                   class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                   placeholder="Nombre y apellidos"
                                   required>
                            <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Cédula (Readonly) -->
                    <div>
                        <label for="cedula" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-id-card text-blue-500 mr-2"></i>
                            Cédula
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="cedula" 
                                   id="cedula" 
                                   value="{{ $cliente->cedula }}"
                                   class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                   readonly>
                            <i class="fas fa-id-card absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            La cédula no puede ser modificada
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>
                        Correo Electrónico *
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="correo" 
                               id="email" 
                               value="{{ $cliente->correo }}"
                               class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                               placeholder="correo@ejemplo.com"
                               required>
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    @error('correo')
                        <p class="text-red-500 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Dirección y Teléfono -->
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <!-- Dirección -->
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-home text-blue-500 mr-2"></i>
                            Dirección *
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="direccion" 
                                   id="direccion" 
                                   value="{{ $cliente->direccion }}"
                                   class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                   placeholder="Dirección completa"
                                   required>
                            <i class="fas fa-home absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('direccion')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-phone text-blue-500 mr-2"></i>
                            Teléfono *
                        </label>
                        <div class="relative">
                            <input type="tel" 
                                   name="telefono" 
                                   id="telefono" 
                                   value="{{ $cliente->telefono }}"
                                   class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                   placeholder="Número de teléfono"
                                   required>
                            <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        @error('telefono')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('clientes.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-lg transition-colors text-sm font-medium flex items-center shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection