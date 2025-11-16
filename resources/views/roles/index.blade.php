@extends('layoutPrincipal')

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
                    <span class="text-gray-700 font-semibold">Roles</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 rounded-full border-2 border-white flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-1">Gestión de Roles</h1>
                        <p class="text-gray-600 text-sm">Administra los roles y permisos del sistema</p>
                    </div>
                </div>
                
                <!-- Botón agregar rol -->
                <a href="{{ route('roles.create') }}" 
                   class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors text-sm font-medium flex items-center space-x-2 shadow-md">
                    <i class="fas fa-plus"></i>
                    <span>Agregar Rol</span>
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total de Roles</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $roles->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-layer-group text-purple-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Roles Activos</p>
                        <p class="text-2xl font-bold text-green-600">{{ $roles->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-purple-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Último Rol</p>
                        <p class="text-lg font-semibold text-gray-800 truncate">
                            {{ $roles->last() ? $roles->last()->tipo : 'N/A' }}
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Roles -->
        <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Header de la Grid -->
            <div class="bg-purple-400 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Lista de Roles</h2>
                            <p class="text-purple-100 text-xs">Todos los roles del sistema</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <span class="text-white text-sm font-medium">{{ $roles->count() }} roles</span>
                    </div>
                </div>
            </div>

            <!-- Contenido de la Grid -->
            <div class="p-6">
                @if($roles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($roles as $rol)
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                                            <i class="fas fa-user-tag text-purple-500 text-sm"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800 text-lg">{{ $rol->tipo }}</h3>
                                            <p class="text-xs text-gray-500">ID: {{ $rol->id }}</p>
                                        </div>
                                    </div>
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-medium">
                                            Rol
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-2 mt-4 pt-3 border-t border-purple-100">
                                    <!-- Editar -->
                                    <a href="{{ route('roles.edit', $rol->id) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                       title="Editar rol">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar el rol {{ $rol->tipo }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 flex items-center justify-center w-10 h-10"
                                                title="Eliminar rol">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Estado vacío -->
                    <div class="text-center py-12">
                        <div class="flex flex-col items-center space-y-4 text-gray-500">
                            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tag text-purple-400 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-gray-600 mb-2">No hay roles registrados</p>
                                <p class="text-sm text-gray-500 mb-4">Comienza agregando el primer rol al sistema.</p>
                            </div>
                            <a href="{{ route('roles.create') }}" 
                               class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200 font-medium flex items-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Agregar primer rol</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer con información -->
            @if($roles->count() > 0)
                <div class="bg-purple-50 px-6 py-4 border-t border-purple-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-purple-700">
                        <p>
                            Mostrando <span class="font-semibold text-purple-900">{{ $roles->count() }}</span> roles en el sistema
                        </p>
                        <p class="text-xs text-purple-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Los roles definen los permisos de los usuarios
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .transition-colors {
        transition: all 0.2s ease-in-out;
    }
    
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    
    /* Efectos hover suaves */
    .group:hover {
        transform: translateY(-2px);
    }
    
    /* Efecto de brillo en los botones */
    .bg-gradient-to-r:hover {
        filter: brightness(110%);
    }
</style>

<script>
    // Script para mejorar la experiencia de usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar confirmación antes de eliminar
        const deleteForms = document.querySelectorAll('form[onsubmit]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const rolName = this.closest('.group')?.querySelector('h3')?.textContent || 'este rol';
                if (!confirm(`¿Estás completamente seguro de eliminar el rol "${rolName}"?\nEsta acción no se puede deshacer.`)) {
                    e.preventDefault();
                }
            });
        });

        // Efecto de carga suave para las cards
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease-in-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection