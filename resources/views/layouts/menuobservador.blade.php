<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Observador')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            height: 100%;
            background-color: #8a0f38;
            color: white;
            padding-top: 60px;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            font-size: 24px;
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 12px;
            cursor: pointer;
            z-index: 1000;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full {
            margin-left: 0;
        }
    </style>

    @stack('styles')
</head>
<body>

    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <a href="#"><i class="fa fa-eye"></i> Ver Formularios</a>
        <a href="#"><i class="fa fa-user"></i> Perfil</a>
        <a href="#"><i class="fa fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>

    <div class="main-content" id="main">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            sidebar.classList.toggle('hidden');
            main.classList.toggle('full');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>