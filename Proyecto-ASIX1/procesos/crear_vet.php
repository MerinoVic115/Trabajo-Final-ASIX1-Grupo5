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
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $especialidad = $_POST['especialidad'];
    $fecha_contrato = $_POST['fecha_contrato'];
    $salario = $_POST['salario'];

    // Consulta para insertar los datos
    $query1 = "INSERT INTO veterinario (Nombre, Telefono, Especialidad, Fecha_Contrato, Salario) VALUES (?, ?, ?, ?, ?)";
    $sentencia1 = mysqli_prepare($conn, $query1);

    if ($sentencia1) {
        mysqli_stmt_bind_param($sentencia1, "ssssd", $nombre, $telefono, $especialidad, $fecha_contrato, $salario);

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
        header("Location: ../views/veterinarios.php?success=1");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de creación de veterinario</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Veterinario</div>
                <div id="welcome-line-2">Rellena los datos del veterinario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre del veterinario" required>
                </div>
                <div class="form-inp">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" placeholder="Introduce el teléfono" required>
                </div>
                <div class="form-inp">
                    <label for="especialidad">Especialidad</label>
                    <input type="text" name="especialidad" id="especialidad" placeholder="Introduce la especialidad" required>
                </div>
                <div class="form-inp">
                    <label for="fecha_contrato">Fecha de Contrato</label>
                    <input type="date" name="fecha_contrato" id="fecha_contrato" required>
                </div>
                <div class="form-inp">
                    <label for="salario">Salario</label>
                    <input type="number" name="salario" id="salario" placeholder="Introduce el salario" required>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/veterinarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>