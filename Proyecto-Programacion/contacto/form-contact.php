<?php
include "../conexion/conexion.php"; 

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ./view/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Contacto</title>
</head>
<body>
<script src="./validacion.js"></script>

    <form action="./form-contact.php" method="post">
        <br>
        <label>Num de Telefono</label>
        <input type="telephone" name="telefono" id="telefono" onblur="ValidNum()">
        <p id="errortelf"></p>
        <br>
        <label>Correo Electronico</label>
        <input type="email" name="correo1" placeholder="Inserte correo" id="correo" onblur="Validcorreo()">
        <p id="errorcorreo"></p>
        <br><br>
        <label>Obsevarciones:</label><br>
        <textarea placeholder="Inserte aqui tus observaciones" name="observacion"></textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>

<?php

include "../conexion/conexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['telefono'], $_POST['correo1'], $_POST['observacion'])) {
        $telefono = trim($_POST['telefono']);
        $correo = trim($_POST['correo1']);
        $observacion = trim($_POST['observacion']);

        $sql_insert = "INSERT INTO contacto_artistas (telefono, email, observaciones) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iss", $telefono, $correo, $observacion);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    
}
header("Location: ../index.php");
?>