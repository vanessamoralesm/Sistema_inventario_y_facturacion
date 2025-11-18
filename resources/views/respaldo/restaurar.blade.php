@extends('layoutPrincipal')

@section('contenido')
<div class="min-h-screen bg-purple-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-purple-100">
      <!-- Header -->
      <div class="bg-purple-600 px-6 py-8 text-center">
        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
          </svg>
        </div>
        <h4 class="text-2xl font-bold text-white">Restaurar Base de Datos</h4>
        <p class="text-purple-200 mt-2">Selecciona un archivo de respaldo .sql</p>
      </div>

      <!-- Contenido -->
      <div class="px-6 py-8">
        <!-- Alertas -->
        @if(session('success'))
          <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start space-x-3">
            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
          </div>
        @elseif(session('error'))
          <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start space-x-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
          </div>
        @endif

        <!-- Debug de errores de validación -->
        @if($errors->any())
          <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
            <ul class="text-red-800">
              @foreach($errors->all() as $error)
                <li class="flex items-start space-x-2">
                  <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                  </svg>
                  <span>{{ $error }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('restaurar') }}" method="POST" enctype="multipart/form-data" id="restoreForm">
          @csrf
          
          <!-- File Input -->
          <div class="mb-8">
            <label for="respaldo" class="block text-lg font-semibold text-gray-700 mb-3">
              <svg class="w-5 h-5 text-purple-600 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
              </svg>
              Archivo .sql
              <span class="text-red-500">*</span>
            </label>
            
            <div class="relative group">
              <input 
                type="file" 
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                id="respaldo" 
                name="respaldo" 
                accept=".sql" 
                required
              >
              <div class="border-2 border-dashed border-purple-300 rounded-xl p-6 text-center transition-all duration-200 group-hover:border-purple-400 group-hover:bg-purple-50">
                <svg class="w-12 h-12 text-purple-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                <p class="text-gray-600 font-medium text-base">Haz clic para seleccionar archivo</p>
                <p class="text-gray-500 mt-1 text-sm">Solo se permiten archivos con extensión .sql</p>
                <div id="fileName" class="text-purple-600 font-semibold mt-2 text-base"></div>
              </div>
            </div>
          </div>

          <!-- Información -->
          <div class="mb-8 p-4 bg-purple-50 border border-purple-200 rounded-xl">
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
              <div>
                <p class="text-purple-800 font-semibold text-base">Importante</p>
                <p class="text-purple-700 text-sm mt-1">
                  Esta acción reemplazará todos los datos actuales de la base de datos. 
                  Asegúrate de tener un respaldo reciente antes de continuar.
                </p>
              </div>
            </div>
          </div>

          <!-- Botones más pequeños -->
          <div class="flex flex-col sm:flex-row gap-3">
            <button 
              type="submit" 
              class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 text-sm"
            >
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              <span>Restaurar</span>
            </button>
            
            <a 
              href="{{ route('dashboard') }}" 
              class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 text-sm"
            >
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              <span>Cancelar</span>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Mostrar nombre del archivo seleccionado
document.getElementById('respaldo').addEventListener('change', function(e) {
  const fileNameDisplay = document.getElementById('fileName');
  if (this.files.length > 0) {
    fileNameDisplay.textContent = `Archivo seleccionado: ${this.files[0].name}`;
  } else {
    fileNameDisplay.textContent = '';
  }
});

// Confirmación antes de enviar
document.getElementById('restoreForm').addEventListener('submit', function(e) {
  const fileInput = document.getElementById('respaldo');
  if (fileInput.files.length === 0) {
    e.preventDefault();
    alert('Por favor, selecciona un archivo .sql para restaurar.');
    return false;
  }
  
  const fileName = fileInput.files[0].name;
  if (!fileName.toLowerCase().endsWith('.sql')) {
    e.preventDefault();
    alert('Por favor, selecciona un archivo con extensión .sql');
    return false;
  }
  
  const confirmacion = confirm('¿Estás seguro de que deseas restaurar la base de datos? Esta acción reemplazará todos los datos actuales y no se puede deshacer.');
  
  if (!confirmacion) {
    e.preventDefault();
    return false;
  }
});
</script>
@endsection