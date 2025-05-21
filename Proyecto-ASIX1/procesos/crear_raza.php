<?php
include "../conexion/conexion.php";
session_start();
$error = false;

if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $id_raza = $_POST['Id_Raza'];
    $nombre = $_POST['Nombre'];
    $altura = $_POST['Altura'];
    $peso = $_POST['Peso'];
    $caracter = $_POST['Caracter'];

    // Consulta para insertar los datos
    $query1 = "INSERT INTO Raza (Nombre, Altura, Peso, Caracter) VALUES (?, ?, ?, ?)";
    $sentencia1 = mysqli_prepare($conn, $query1);

    if ($sentencia1) {
        mysqli_stmt_bind_param($sentencia1, "siis", $nombre, $altura, $peso, $caracter);

        if (!mysqli_stmt_execute($sentencia1)) {
            $error = true;
        }
        mysqli_stmt_close($sentencia1);
    } else {
        $error = true;
    }

    if ($error) {
        header("Location: ../views/principal.php?error=2");
    } else {
        header("Location: ../views/raza.php?success=1");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de creación de razas</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">  
</head>
<body class="body_forms">
<div class="header">
    <div class="logo-title">
        <h2>Crear raza</h2>
    </div>
    <a href="../views/raza.php"><button type="button">Atrás</button></a>
</div>

<form action="" method="post">
    <div class="form-group">
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre de la raza" required>
        <p id="errorNombreRaza"></p>
    </div>
    
    <div class="form-group">
        <label>Altura:</label>
        <input type="number" name="altura" id="altura" placeholder="Introduce la altura de la raza" required>
        <p id="errorAlturaRaza"></p>
    </div>

    <div class="form-group">
        <label>Peso:</label>
        <input type="number" name="peso" id="peso" placeholder="Introduce el peso de la raza" required>
        <p id="errorPesoRaza"></p>
    </div>

    <div class="form-group">
        <label>Caracter:</label>
        <input type="text" name="caracter" id="caracter" placeholder="Introduce el caracter de la raza">
        <p id="errorCaracterRaza"></p>
    </div>

    <button type="submit">Guardar cambios</button>
</form>  
<?php mysqli_close($conn); ?>
</body>
</html>