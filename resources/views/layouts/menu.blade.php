<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inicio')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: row;
            overflow-x: hidden;
        }

        .sidebar {
            width: 350px;
            background-color: #8a0f38;
            color: white;
            transition: transform 0.3s ease;
            z-index: 1001;
            height: 100vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .sidebar h4 {
            padding: 20px;
            margin: 0;
            background-color: #75112d;
        }

        .sidebar a, .sidebar button.dropdown-btn {
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover, .dropdown-btn:hover {
            background-color: #34344a;
        }

        .dropdown-container {
            display: none;
            background-color: #2a2a40;
        }

        .dropdown-container a {
            padding-left: 40px;
        }

        .fa-caret-down, .fa-caret-up {
            float: right;
            padding-right: 8px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        .toggle-btn {
            display: none;
            background-color: #8a0f38;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0%);
            }

            .toggle-btn {
                display: inline-block;
            }

            .content {
                flex-grow: 1;
                padding: 5px;
                transition: margin-left 0.3s ease;
            }

            .sidebar-header img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border: 2px solid #fff;
            }
            .sidebar-header h5 {
                color: #fff;
                font-weight: 500;
            }

        }
    </style>
</head>
<body>

    <div class="sidebar hidden" id="sidebar">

        <div class="sidebar-header text-center p-3">
            <img src="https://play-lh.googleusercontent.com/hZmdwiFSH5zYkiFjxeBrlZtNeHMN0y3EsVJomKt2hkVJu6H98ZWzfVJFxIoUaQXdpqw=w600-h300-pc0xffffff-pd" alt="Logo" class="img-fluid rounded-circle mb-2">
            <h5 class="mb-0">Administrador</h5>
        </div>

        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>

        <button class="dropdown-btn">
            <i class="fa-solid fa-tools"></i> Mantenimientos
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="{{ route('admin.usuarios') }}"><i class="fa-solid fa-users"></i> Gestión de Usuarios</a>
            <a href="{{ route('materias') }}"><i class="fa-solid fa-book"></i> Gestión de Materias</a>
            <a href="{{ route('catedras.index') }}"><i class="fa-solid fa-chalkboard-teacher"></i> Gestión de Catedras</a>
            <a href="{{ route('ciclos.index') }}"><i class="fa-solid fa-calendar-alt"></i> Gestión de Ciclos</a>
            <a href="{{ route('clases.index') }}"><i class="fa-solid fa-door-open"></i> Gestión de Clases</a>
            <a href="{{ route('docentes.index') }}"><i class="fa-solid fa-user-tie"></i> Gestión de Docentes</a>
        </div>

        <button class="dropdown-btn">
            <i class="fa-solid fa-file-lines"></i> Formularios
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="{{ route('formularios.index') }}"><i class="fa-solid fa-plus"></i> Crear formulario</a>
            <a href="{{ route('asignarForm.index') }}"><i class="fa-solid fa-user-check"></i> Asignar formulario</a>
            <a href="{{ route('admin.respuestas') }}"><i class="fa-solid fa-reply"></i> Respuestas</a>
        </div>

        <a href="#"><i class="fa-solid fa-chart-bar"></i> Reportes</a>
        <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
    </div>

    <!-- efecto de menu-->
    <div class="overlay" id="overlay"></div>

    <div class="content">
        <button class="toggle-btn" id="toggleMenu">
            <i class="fa fa-bars"></i>
        </button>

        @yield('content')

    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleMenu');
        const overlay = document.getElementById('overlay');

        function toggleSidebar(show) {
            if (window.innerWidth <= 768) {
                if (show) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('active');
                    overlay.style.display = 'block';
                } else {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('active');
                    overlay.style.display = 'none';
                }
            } else {
                sidebar.classList.remove('hidden');
                sidebar.classList.remove('active');
                overlay.style.display = 'none';
            }
        }

        toggleBtn.addEventListener('click', () => {
            toggleSidebar(true);
        });

        overlay.addEventListener('click', () => {
            toggleSidebar(false);
        });

        // Dropdown funcionalidad
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const dropdown = this.nextElementSibling;
                const icon = this.querySelector('.fa-caret-down, .fa-caret-up');

                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                    icon.classList.remove('fa-caret-up');
                    icon.classList.add('fa-caret-down');
                } else {
                    dropdown.style.display = 'block';
                    icon.classList.remove('fa-caret-down');
                    icon.classList.add('fa-caret-up');
                }
            });
        });

        // Detectar cambios de tamaño de pantalla
        window.addEventListener('resize', () => {
            toggleSidebar(false);
        });

        // Cargar estado inicial
        window.addEventListener('DOMContentLoaded', () => {
            toggleSidebar(false);
        });
    </script>

</body>
</html>