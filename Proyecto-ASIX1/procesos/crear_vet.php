<?php
include "../conexion/conexion.php";

$error = false;

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
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <title>Formulario de creación de veterinario</title>
</head>
<body>
<div class="header">
    <div class="logo-title">
        <h2>Crear veterinario</h2>
    </div>
    <a href="../views/veterinarios.php"><button type="button">Atrás</button></a>
</div>

<form action="" method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre" placeholder="Introduce el nombre del veterinario" required>
    <br>
    
    <label>Teléfono:</label>
    <input type="text" name="telefono" placeholder="Introduce el teléfono" required>
    <br>

    <label>Especialidad:</label>
    <input type="text" name="especialidad" placeholder="Introduce la especialidad" required>
    <br>

    <label>Fecha de Contrato:</label>
    <input type="date" name="fecha_contrato" required>
    <br>

    <label>Salario:</label>
    <input type="number" name="salario" placeholder="Introduce el salario" required>
    <br>

    <button type="submit">Guardar cambios</button>
</form>  
<?php mysqli_close($conn); ?>
</body>
</html>