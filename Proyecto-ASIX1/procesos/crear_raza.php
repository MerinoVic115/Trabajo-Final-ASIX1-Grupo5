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
    // NOTA: El campo Id_Raza no debe venir del formulario, ya que es autoincremental normalmente
    $nombre = $_POST['nombre'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $caracter = $_POST['caracter'];

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
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Raza</div>
                <div id="welcome-line-2">Rellena los datos de la raza</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre de la raza" required>
                    <p id="errorNombreRaza"></p>
                </div>
                <div class="form-inp">
                    <label for="altura">Altura</label>
                    <input type="number" name="altura" id="altura" placeholder="Introduce la altura de la raza" required>
                    <p id="errorAlturaRaza"></p>
                </div>
                <div class="form-inp">
                    <label for="peso">Peso</label>
                    <input type="number" name="peso" id="peso" placeholder="Introduce el peso de la raza" required>
                    <p id="errorPesoRaza"></p>
                </div>
                <div class="form-inp">
                    <label for="caracter">Caracter</label>
                    <input type="text" name="caracter" id="caracter" placeholder="Introduce el caracter de la raza">
                    <p id="errorCaracterRaza"></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/raza.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>