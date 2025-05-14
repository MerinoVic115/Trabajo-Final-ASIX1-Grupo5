
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Registro</title>
</head>
<body>
    <script src="../validaciones/validacion.js"></script>
    <form method="post" action="../validaciones/validacion.php" >

        <label for="user">Nombre Usuario:</label><br><br>
        <input type="text" name="user" id="user" placeholder="Inserte el nombre de usuario" onblur="validacionNombre()">
        <p id="errorNombre"></p>

        <label for="email">Correo:</label><br><br>
        <input type="email" name="email" id="email" placeholder="Inserte el email" onblur="validacionEmail()">
        <p id="errorEmail"></p>

        <label for="passwd">Contraseña:</label><br><br>
        <input type="password" name="passwd" id="passwd" placeholder="Inserte la contraseña" onblur="validacionContra1()">
        <p id="errorContra1"></p>

        <label for="passwd2">Confirmar contraseña:</label><br><br>
        <input type="password" name="passwd2" id="passwd2" placeholder="Inserte la contraseña" onblur="validacionContra2()">
        <p id="errorContra2"></p><br><br>

        <button type="submit"> Enviar </button><br><br>



    </form>
</body>
</html>