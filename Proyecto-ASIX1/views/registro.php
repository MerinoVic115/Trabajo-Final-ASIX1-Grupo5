
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Perriatra</title>
    <script src="../validaciones/js/validacion.js"></script>
</head>

<body>
    <form action="../validaciones/php/val_regist.php" method="POST">
        
        <div>
            <div>
                <h2>🐾 Registro al Perriatra 🐾</h2>
            </div>
                    <script src= "../validaciones/js/validacion.js"></script>
            <div>
                <form action="index.php" method="POST" id="form">

                    <div>
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="r_nombre" name="r_nombre" placeholder="Ingresa tu nombre" onblur="r_validarNombre()" required>
                        <p id="r_errorNombre" style="color: red;"></p>
                    </div>

                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="r_email" name="r_email" placeholder="Ingresa tu email" onblur="r_validarEmail()" required>
                        <p id="r_errorEmail" style="color: red;"></p>
                    </div>

                    <div>
                        <label for="pwd">Contraseña:</label>
                        <input type="password" id="r_pwd" name="r_pwd" placeholder="Crea una contraseña" onblur="r_validarPwd()" required>
                        <p id="r_errorPwd" style="color: red;"></p>
                    </div>

                    <div>
                        <label for="confirmPwd">Confirmar contraseña:</label>
                        <input type="password" id="r_confirmPwd" name="r_confirmPwd" placeholder="Confirma tu contraseña" onblur="r_validarconfirmPwd()" required>
                        <p id="r_errorconfirmPwd" style="color: red;"></p>
                    </div>

                    <div>
                        <button type="submit">
                            <a href="index.php" style="color: white;">Registrarse</a>
                        </button>
                    </div>
                </form>
            </div>

            <div>
                <a href="login.php" style="color: red;">Volver al login</a>
            </div>
        </div>
        
        <br><br>

    </form>
</body>
</html>