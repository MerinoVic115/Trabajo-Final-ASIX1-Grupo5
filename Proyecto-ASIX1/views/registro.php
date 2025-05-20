<!-- Registro de usuarios -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Perriatra</title>
    <link href="../sets/css/styles.css" rel="stylesheet" type="text/css">
    <script src="../validaciones/js/validacion.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light" style="background: linear-gradient(135deg, #007a3d 0%, #ffffff 100%); min-height: 100vh;">
    
    <form class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;" action="../validaciones/php/val_regist.php" method="POST">
        
        <div class="card shadow border-success" style="max-width: 400px; width: 100%; border-width:2px;">

            <div class="card-body">
                <img src="../sets/img/Logo_final_sin_fondo.png" alt="Vetis Logo" class="d-block mx-auto mb-3" style="width: 120px;" />
                <h2 class="text-center mb-4 text-success">Registro al Perriatra</h2>
                <form action="index.php" method="POST" id="form">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control border-success" id="r_nombre" name="r_nombre" placeholder="Ingresa tu nombre" onblur="r_validarNombre()" required>
                        <p id="r_errorNombre" style="color: red;"></p>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control border-success" id="r_email" name="r_email" placeholder="Ingresa tu email" onblur="r_validarEmail()" required>
                        <p id="r_errorEmail" style="color: red;"></p>
                    </div>

                    <div class="mb-3">
                        <label for="pwd" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control border-success" id="r_pwd" name="r_pwd" placeholder="Crea una contraseña" onblur="r_validarPwd()" required>
                        <p id="r_errorPwd" style="color: red;"></p>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPwd" class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control border-success" id="r_confirmPwd" name="r_confirmPwd" placeholder="Confirma tu contraseña" onblur="r_validarconfirmPwd()" required>
                        <p id="r_errorconfirmPwd" style="color: red;"></p>
                    </div>

                    <div>
                        <button class="btn btn-success w-100" type="submit">
                            <a href="index.php" style="color: white;">Registrarse</a>
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4 text-success mb-3">
                <a href="login.php" style="color: red;" class="text-success fw-bold">Volver al login</a>
            </div>
        </div>
        
        <br><br>

    </form>
</body>
</html>