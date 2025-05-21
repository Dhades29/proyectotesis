<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (opcional para íconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body, html {
            height: 100%;
            background-color: #5d0a28;
        }
        .login-container {
            min-height: 100vh;
        }
        .login-box {
            max-width: 900px;
            box-shadow: 0 0 10px rgba(14, 13, 13, 0.1);
            border-radius: 1rem;
            overflow: hidden;
        }
        .login-image {
            background: url('https://play-lh.googleusercontent.com/8-1RW87JPE8sKA-iVFM42kepAxt4fvx0ei8AQcmmuZZ7mrgGqP_ktv8NLCHDUOe7P_in') no-repeat center center;
            background-size: cover;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center login-container">
    <div class="row w-100 login-box bg-white">
        <div class="col-md-6 login-image d-none d-md-block"></div>
        <div class="col-md-6 p-5">
            <h3 class="mb-4 text-center">Iniciar Sesión</h3>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>