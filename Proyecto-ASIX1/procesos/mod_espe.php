<!-- Modificación Historial - Consultas para inserción en la BBDD -->
 
<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['id_especialidad'])) {
    echo "ID de especialidad no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id_especialidad']);

// Obtener datos de la especialidad
$sql = "SELECT * FROM especialidad WHERE id_especialidad = $id";
$result = mysqli_query($conn, $sql);
$especialidad = mysqli_fetch_assoc($result);

if (!$especialidad) {
    echo "Especialidad no encontrada.";
    exit();
}

// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_e = $_POST['nombre_e'];
    $descripcion_e = $_POST['descripcion_e'];

    // Validación PHP para Nombre
    if (!$nombre_e || strlen($nombre_e) < 3) {
        $errores['nombre_e'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre_e)) {
        $errores['nombre_e'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Descripción
    if (!$descripcion_e || strlen($descripcion_e) < 10) {
        $errores['descripcion_e'] = "La descripción es obligatoria y debe tener al menos 10 caracteres.";
    }

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $update_sql = "UPDATE especialidad 
                       SET Nombre_e = ?, 
                           Descripcion_e = ?
                       WHERE id_especialidad = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssi", $nombre_e, $descripcion_e, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../views/especialidad.php");
                exit();
            } else {
                echo "Error al actualizar los datos: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Especialidad</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../validaciones/js/validacion.js"></script>
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id_especialidad" value="<?php echo htmlspecialchars($especialidad['id_especialidad'] ?? $id); ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Especialidad</div>
                <div id="welcome-line-2">Actualiza los datos de la especialidad</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="nombre_e">Nombre</label>
                    <input type="text" id="nombre_e" name="nombre_e" value="<?php echo htmlspecialchars($especialidad['Nombre_e'] ?? ''); ?>" required onblur="validarModEspeNom()">
                    <p id="errorNombreEspecialidad"><?php echo $errores['nombre_e'] ?? ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="descripcion_e">Descripción</label>
                    <input type="text" id="descripcion_e" name="descripcion_e" value="<?php echo htmlspecialchars($especialidad['Descripcion_e'] ?? ''); ?>" required onblur="validarModEspeDesc()">
                    <p id="errorDescripcionEspecialidad"><?php echo $errores['descripcion_e'] ?? ''; ?></p>

                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/especialidad.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>