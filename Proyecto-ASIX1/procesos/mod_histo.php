<!-- Modificación Historial - Consultas para inserción en la BBDD -->
 
<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Validar si se ha enviado un ID válido por GET o POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $observacion = mysqli_real_escape_string($conn, $_POST['observacion']);
    $fecha_entrada = mysqli_real_escape_string($conn, $_POST['fecha_entrada']);
    $fecha_salida = mysqli_real_escape_string($conn, $_POST['fecha_salida']);
    $ingresado = mysqli_real_escape_string($conn, $_POST['ingresado']);
    $mascota = mysqli_real_escape_string($conn, $_POST['mascota']);
    $veterinario = mysqli_real_escape_string($conn, $_POST['veterinario']);

    $update_sql = "UPDATE historial 
                   SET observacion_his = '$observacion', 
                       `fecha-entrada_his` = '$fecha_entrada', 
                       `fecha-salida_his` = '$fecha_salida', 
                       ingresado_his = '$ingresado',
                       mascota = '$mascota',
                       veterinario = '$veterinario'
                   WHERE id_historial = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../views/historial.php");
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
} else {
    if (!isset($_GET['id_historial']) || empty($_GET['id_historial'])) {
        die("ID de historial no válido.");
    }
    $id = mysqli_real_escape_string($conn, $_GET['id_historial']);
    $sql = "SELECT * FROM historial WHERE id_historial = $id";
    $result = mysqli_query($conn, $sql);
    $histo = mysqli_fetch_assoc($result);

    if (!$histo) {
        die("Historial no encontrado.");
    }
}

// Obtener mascotas y veterinarios para los selects
$mascotas = [];
$veterinarios = [];
$resMasc = mysqli_query($conn, "SELECT Chip, Nombre FROM mascota");
while ($row = mysqli_fetch_assoc($resMasc)) {
    $mascotas[] = $row;
}
$resVet = mysqli_query($conn, "SELECT Id_Vet, Nombre FROM veterinario");
while ($row = mysqli_fetch_assoc($resVet)) {
    $veterinarios[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar historial</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($histo['id_historial'] ?? $id); ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Historial</div>
                <div id="welcome-line-2">Actualiza los datos del historial</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Observaciones</label>
                    <input type="text" name="observacion" value="<?php echo htmlspecialchars($histo['observacion_his'] ?? ''); ?>">
                </div>
                <div class="form-inp">
                    <label>Fecha Entrada</label>
                    <input type="date" name="fecha_entrada" value="<?php echo isset($histo['fecha-entrada_his']) ? htmlspecialchars($histo['fecha-entrada_his']) : ''; ?>">
                </div>
                <div class="form-inp">
                    <label>Fecha Salida</label>
                    <input type="date" name="fecha_salida" value="<?php echo isset($histo['fecha-salida_his']) ? htmlspecialchars($histo['fecha-salida_his']) : ''; ?>">
                </div>
                <div class="form-inp">
                    <label>Ingresado</label>
                    <input type="text" name="ingresado" value="<?php echo htmlspecialchars($histo['ingresado_his'] ?? ''); ?>">
                </div>
                <div class="form-inp">
                    <label>Mascota</label>
                    <select name="mascota" required>
                        <option value="">Seleccionar mascota</option>
                        <?php foreach ($mascotas as $m): 
                            $selected = (isset($histo['mascota']) && $histo['mascota'] == $m['Chip']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $m['Chip']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($m['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-inp">
                    <label>Veterinario</label>
                    <select name="veterinario" required>
                        <option value="">Seleccionar veterinario</option>
                        <?php foreach ($veterinarios as $v): 
                            $selected = (isset($histo['veterinario']) && $histo['veterinario'] == $v['Id_Vet']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $v['Id_Vet']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($v['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/historial.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>