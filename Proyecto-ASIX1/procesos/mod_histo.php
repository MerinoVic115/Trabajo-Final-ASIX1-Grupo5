<!-- Modificación Historial - Consultas para inserción en la BBDD -->
 
<?php
include "../conexion/conexion.php";
session_start();

// // Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['id_historial'])) {
    echo "ID de historial no válido.";
    exit();
}

$id = $_GET['id_historial'];

// Obtener datos del historial
$sql = "SELECT * FROM historial WHERE id_historial = $id";
$result = mysqli_query($conn, $sql);
$historial = mysqli_fetch_assoc($result);

if (!$historial) {
    echo "Historial no encontrado.";
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacion = $_POST['observacion_his'];
    $fecha_entrada = $_POST['fecha_entrada_his'];
    $fecha_salida = $_POST['fecha_salida_his'];
    $ingresado = $_POST['ingresado_his'];

    $update_sql = "UPDATE historial SET observacion_his = '$observacion', `fecha-entrada_his` = '$fecha_entrada', `fecha-salida_his` = '$fecha_salida', ingresado_his = '$ingresado' WHERE id_historial = $id";
    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../views/historial.php"); // Redirigir a una página de éxito
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <title>Formulario de modificación de historial</title>
</head>

<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar historial</h2>
    </div>
    <a href="../views/historial.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label>Observación:</label>
    <input type="text" name="observacion_his" value="<?php echo $historial['observacion_his']; ?>">
    <br>
    
    <label>Fecha de entrada:</label>
    <input type="date" name="fecha_entrada_his" value="<?php echo $historial['fecha-entrada_his']; ?>" onblur="modFechaEntradaHis()">
    <br>
    
    <label>Fecha de salida:</label>
    <input type="date" name="fecha_salida_his" value="<?php echo $historial['fecha-salida_his']; ?>" onblur="modFechaSalidaHis()">
    <br>
    
    <label>Ingresado:</label>
    <select name="ingresado_his" required onblur="validarIngresadoHis()">
        <option value="">Selecciona una opción</option>
        <option value="Sí" <?php if ($historial['ingresado_his'] == "Sí") echo "selected"; ?>>Sí</option>
        <option value="No" <?php if ($historial['ingresado_his'] == "No") echo "selected"; ?>>No</option>
    </select>
    <br>
    
    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>