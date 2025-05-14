<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">

    <title>Login</title>
</head>
<body>
    <script src="../validaciones/valid-log.js"></script>

    <form method="post" action="../validaciones/valid-log.php" >
        <label>Usuario</label>
        <input type="text" name="userlog" id="user" onblur="NomLog()">
        <p id="errorNombre"></p>
        <label>Contraseña</label>
        <input type="password" name="passwdlog" id="password" onblur="ConLog()">
        <p id="errorContra"></p>

        <button type="submit">Enviar</button><br><br>

        <a href="../view/register.php">¿No tienes cuenta? Create una cuenta crack</a>

    </form>
</body>
</html>