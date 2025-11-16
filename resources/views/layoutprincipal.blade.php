<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GarMorel - Sistema de Inventario</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b02c07e',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Estilos para móviles */
        @media (max-width: 768px) {
            .sidebar-mobile {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 40;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s ease-out;
            }
            .sidebar-mobile.open {
                transform: translateX(0);
            }
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 30;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            .overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Estados del sidebar */
        .sidebar-collapsed {
            width: 80px !important;
            transition: width 0.3s ease;
        }

        .sidebar-expanded {
            width: 200px !important;
            transition: width 0.3s ease;
        }

        /* Transiciones de texto */
        .nav-text {
            transition: opacity 0.3s ease, width 0.3s ease;
        }

        .nav-text-hidden {
            opacity: 0;
            width: 0;
        }

        .nav-text-visible {
            opacity: 1;
            width: auto;
        }

        /* Ocultar barra de desplazamiento */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Efectos de hover para elementos interactivos */
        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .nav-item:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="h-full bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Overlay -->
        <div class="overlay md:hidden" id="mobileOverlay" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-mobile md:relative md:transform-none w-56 bg-primary shadow-2xl z-40 transition-all duration-300" aria-label="Menú principal">
            <!-- Sidebar Header -->
            <div class="p-4 border-b border-white/20 flex items-center justify-between">
                <div class="flex items-center gap-3" id="sidebarLogo">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('IMG/logo.jpeg') }}" alt="GarMorel" class="w-60 h-10">
                    </div>
                    <div id="sidebarText">
                        <h1 class="text-lg font-bold text-white">kale Store</h1>
                        <p class="text-white/80 text-xs">Fashion Store</p>
                    </div>
                </div>
                
                <button id="closeSidebar" class="md:hidden text-white hover:text-white/80 transition-colors" aria-label="Cerrar menú">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>
            </div>

            <!-- Collapse Button -->
            <div class="hidden md:flex justify-end px-3 py-2 border-b border-white/20">
                <button id="toggleSidebar" class="text-white/80 hover:text-white transition-colors duration-200 p-1 rounded hover:bg-white/10" aria-label="Alternar barra lateral">
                    <i class="bi bi-chevron-double-left text-sm transition-transform duration-300" id="toggleIcon"></i>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-3 space-y-1 flex-1 overflow-y-auto no-scrollbar" aria-label="Navegación principal">
                
                <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                        <i class="bi bi-house-door text-sm"></i>
                    </div>
                    <span class="font-medium nav-text text-sm">Dashboard</span>
                </a>

                <a href="{{ route('facturas.index') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                        <i class="bi bi-receipt text-sm"></i>
                    </div>
                    <span class="font-medium nav-text text-sm">Facturación</span>
                </a>

                <a href="{{ route('clientes.index') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                        <i class="bi bi-people text-sm"></i>
                    </div>
                    <span class="font-medium nav-text text-sm">Clientes</span>
                </a>

                <a href="{{ route('productos.index') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                        <i class="bi bi-box-seam text-sm"></i>
                    </div>
                    <span class="font-medium nav-text text-sm">Productos</span>
                </a>

                <!-- NUEVA SECCIÓN: Estadísticas y Gráficas -->
                <div class="pt-3 mt-3 border-t border-white/20">
                    <a href=" " class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                            <i class="bi bi-graph-up text-sm"></i>
                        </div>
                        <span class="font-medium nav-text text-sm">Estadísticas</span>
                    </a>
                </div>
                
                @if(strtolower(Auth::user()->rol->tipo) != 'vendedor')
                <!-- Separador visual -->
                <div class="pt-3 mt-3 border-t border-white/20">
                    
                    <a href="{{ route('usuarios.index') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                            <i class="bi bi-person text-sm"></i>
                        </div>
                        <span class="font-medium nav-text text-sm">Usuarios</span>
                    </a>

                    <a href="{{ route('roles.index') }}" class="nav-item flex items-center gap-3 p-2 rounded-xl text-white hover:bg-white/10 transition-all duration-300 group">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-all duration-300 flex-shrink-0">
                            <i class="bi bi-shield-lock text-sm"></i>
                        </div>
                        <span class="font-medium nav-text text-sm">Roles</span>
                    </a>
                </div>
                @endif
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-3 border-t border-white/20">
                <div class="text-center text-white/80 text-xs" id="sidebarFooter">
                    <p>v1.0.0</p>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300" id="mainContent">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-4 md:px-6 py-3">
                    <div class="flex items-center gap-3">
                        <button id="hamburgerMenu" class="md:hidden text-primary hover:text-primary/80 transition-colors p-2" aria-label="Abrir menú">
                            <i class="bi bi-list text-xl"></i>
                        </button>

                        <button id="toggleSidebarMobile" class="hidden md:flex text-primary hover:text-primary/80 transition-colors p-2" aria-label="Alternar barra lateral">
                            <i class="bi bi-layout-sidebar text-xl"></i>
                        </button>
                        
                        <div>
                            <h2 class="text-lg md:text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                            <p class="text-gray-600 text-xs hidden md:block">Sistema de gestión</p>
                        </div>
                    </div>
                    
                    @auth
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->nombre }}</p>
                            <p class="text-xs text-gray-600">{{ Auth::user()->rol->tipo ?? 'Sin rol' }}</p>
                        </div>
                        <div class="relative group">
                            <button class="w-10 h-10 bg-primary rounded-2xl text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-sm" aria-label="Menú de usuario">
                                {{ strtoupper(substr(Auth::user()->nombre, 0, 2)) }}
                            </button>
                            
                            <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-3 border-b border-gray-100">
                                    <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->nombre }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ Auth::user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                                        {{ Auth::user()->rol->tipo ?? 'Sin rol' }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50 flex items-center gap-2 transition-colors duration-200 rounded-b-2xl text-sm">
                                        <i class="bi bi-box-arrow-right text-primary"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-white">
                <div class="p-4 md:p-6">
                    @yield('contenido')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Elementos DOM
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
        const toggleIcon = document.getElementById('toggleIcon');
        const navTexts = document.querySelectorAll('.nav-text');
        const sidebarText = document.getElementById('sidebarText');
        const sidebarFooter = document.getElementById('sidebarFooter');

        // Estado del sidebar
        let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        // Funciones de manejo del sidebar móvil
        function openMobileSidebar() {
            sidebar.classList.add('open');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            mobileOverlay.setAttribute('aria-hidden', 'false');
        }

        function closeMobileSidebar() {
            sidebar.classList.remove('open');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
            mobileOverlay.setAttribute('aria-hidden', 'true');
        }

        // Función para alternar el estado del sidebar
        function toggleSidebarState() {
            isSidebarCollapsed = !isSidebarCollapsed;
            updateSidebarState();
            localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
        }

        // Función para actualizar la visualización del sidebar
        function updateSidebarState() {
            if (isSidebarCollapsed) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                toggleIcon.style.transform = 'rotate(180deg)';
                
                navTexts.forEach(text => {
                    text.classList.add('nav-text-hidden');
                    text.classList.remove('nav-text-visible');
                });
                
                if (sidebarText) sidebarText.style.display = 'none';
                if (sidebarFooter) sidebarFooter.style.display = 'none';
                
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                toggleIcon.style.transform = 'rotate(0deg)';
                
                navTexts.forEach(text => {
                    text.classList.remove('nav-text-hidden');
                    text.classList.add('nav-text-visible');
                });
                
                if (sidebarText) sidebarText.style.display = 'block';
                if (sidebarFooter) sidebarFooter.style.display = 'block';
            }
        }

        // Función para manejar cambios de tamaño de ventana
        function handleResize() {
            if (window.innerWidth < 768) {
                closeMobileSidebar();
                
                // En móviles, siempre mostrar el sidebar expandido
                if (isSidebarCollapsed) {
                    isSidebarCollapsed = false;
                    updateSidebarState();
                }
            }
        }

        // Event Listeners
        hamburgerMenu.addEventListener('click', openMobileSidebar);
        closeSidebar.addEventListener('click', closeMobileSidebar);
        mobileOverlay.addEventListener('click', closeMobileSidebar);
        toggleSidebar.addEventListener('click', toggleSidebarState);
        toggleSidebarMobile.addEventListener('click', toggleSidebarState);

        // Cerrar sidebar móvil al hacer clic en un enlace
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeMobileSidebar();
                }
            });
        });

        // Cerrar sidebar móvil con tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && window.innerWidth < 768) {
                closeMobileSidebar();
            }
        });

        // Inicialización
        document.addEventListener('DOMContentLoaded', () => {
            updateSidebarState();
            window.addEventListener('resize', handleResize);
            handleResize(); // Ejecutar una vez al cargar
        });
    </script>
</body>
</html>