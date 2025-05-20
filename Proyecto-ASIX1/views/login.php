<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perriatra</title>
    <!-- Bootstrap CSS -->
    <link href="../sets/css/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light" style="background: linear-gradient(135deg, #007a3d 0%, #ffffff 100%); min-height: 100vh;">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card shadow border-success" style="max-width: 400px; width: 100%; border-width:2px;">
            <div class="card-body">
                <img src="../sets/img/Logo_final_sin_fondo.png" alt="Vetis Logo" class="d-block mx-auto mb-3" style="width: 250px;" />
                <h2 class="text-center mb-4 text-success">Bienvenido a Perriatra</h2>
                <form action="../validaciones/php/val_login.php" method="POST">
                    <div class="mb-3">
                        <label for="lnombre" class="form-label">Usuario</label>
                        <input type="text" class="form-control border-success" name="lnombre" id="lnombre" placeholder="Introduce tu nombre de usuario" required />
                    </div>
                    <div class="mb-3">
                        <label for="lpwd" class="form-label">Contraseña</label>
                        <input type="password" class="form-control border-success" name="lpwd" id="lpwd" placeholder="Introduce tu contraseña" required />
                    </div>
                    <button class="btn btn-success w-100" type="submit">Iniciar sesión</button>
                </form>
                <div class="text-center mt-4 text-success">
                    ¿No tienes cuenta? <a href="registro.php" class="text-success fw-bold">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>