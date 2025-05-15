<?php
include "../conexion/conexion.php";

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $observacion = $_POST['observacion_his'];
    $fecha_entrada = $_POST['fecha_entrada_his'];
    $fecha_salida = $_POST['fecha_salida_his'];
    $ingresado = $_POST['ingresado_his'];

    // Consulta para insertar los datos
    $query = "INSERT INTO historial (`observacion_his`, `fecha-entrada_his`, `fecha-salida_his`, `ingresado_his`) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $observacion, $fecha_entrada, $fecha_salida, $ingresado);

        if (!mysqli_stmt_execute($stmt)) {
            $error = true;
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = true;
    }

    if ($error) {
        header("Location: ../views/principal.php?error=2");
    } else {
        header("Location: ../views/historial.php?success=1");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <title>Formulario de creación de historial</title>
</head>
<body>
<div class="header">
    <div class="logo-title">
        <h2>Crear historial</h2>
    </div>
    <a href="../views/historiales.php"><button type="button">Atrás</button></a>
</div>

<form action="" method="post">
    <label>Observación:</label>
    <input type="text" name="observacion_his" placeholder="Introduce la observación" required>
    <p id="errorobservacion_his" style="color: red;"></p>
    <br>
    
    <label>Fecha de entrada:</label>
    <input type="date" name="fecha_entrada_his" required>
    <p id="errorfecha_ent_his" style="color: red;"></p>
    <br>

    <label>Fecha de salida:</label>
    <input type="date" name="fecha_salida_his">
    <p id="errorfecha_sal_his" style="color: red;"></p>
    <br>

    <label>Ingresado:</label>
    <select name="ingresado_his" required>
        <option value="">Selecciona una opción</option>
        <option value="Sí">Sí</option>
        <option value="No">No</option>
    </select>
    <p id="erroringresado_his" style="color: red;"></p>
    <br>

    <button type="submit">Guardar cambios</button>
</form>
<?php mysqli_close($conn); ?>
</body>
</html>