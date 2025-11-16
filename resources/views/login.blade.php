<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - GarMorel</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #E9D5FF; /* Morado pastel */
      font-family: 'Inter', sans-serif;
    }
    
    .login-card {
      background: white;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 10px 25px rgba(139, 92, 246, 0.1);
      width: 100%;
      max-width: 400px;
    }
    
    .form-input {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #D8B4FE;
      border-radius: 8px;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }
    
    .form-input:focus {
      outline: none;
      border-color: #8B5CF6;
      box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      user-select: none;
    }
    
    .btn {
      width: 100%;
      background: #8B5CF6;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    
    .btn:hover {
      background: #7C3AED;
    }
    
    .error {
      color: #EF4444;
      font-size: 0.875rem;
      margin-top: -0.5rem;
      margin-bottom: 1rem;
      display: block;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4 py-12">

  <div class="login-card text-center">
    <img src="{{ asset('IMG/logo.jpeg') }}" alt="Logo GarMorel" class="mx-auto mb-4 rounded-full w-40 h-40 object-cover">
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">KALE STORE</h1>

    <form method="POST" action="{{ route('login.submit') }}" class="text-left">
      @csrf

      <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required class="form-input">
      @error('email')
        <span class="error">{{ $message }}</span>
      @enderror

      <div class="relative">
        <input type="password" name="password" id="password" placeholder="Contraseña" required class="form-input pr-10">
        <span class="toggle" onclick="togglePassword()">👁️</span>
      </div>
      @error('password')
        <span class="error">{{ $message }}</span>
      @enderror

      <div class="flex items-center mb-4">
        <input type="checkbox" name="keep-session" id="keep-session" class="mr-2">
        <label for="keep-session" class="text-sm text-gray-600">Mantener sesión activa</label>
      </div>

      <a href="#" class="text-sm text-purple-600 hover:underline block mb-4">¿Olvidó su contraseña?</a>

      <button type="submit" class="btn">INICIAR SESIÓN</button>
    </form>
  </div>

  <script>
    function togglePassword() {
      const field = document.getElementById('password');
      field.type = field.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>