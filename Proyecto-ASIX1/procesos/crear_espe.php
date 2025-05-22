<?php
include "../conexion/conexion.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}
$error = false;

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nombre_e']) &&
        isset($_POST['descripcion_e'])
    ) {
        $nombre_e = trim($_POST['nombre_e']);
        $descripcion_e = trim($_POST['descripcion_e']);

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

        // Solo insertar si no hay errores
        if (empty($errores)) {
            $nombre_e = mysqli_real_escape_string($conn, $_POST['nombre_e']);
            $descripcion_e = mysqli_real_escape_string($conn, $_POST['descripcion_e']);

            $query = "INSERT INTO especialidad (Nombre_e, Descripcion_e) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $nombre_e, $descripcion_e);
                if (!mysqli_stmt_execute($stmt)) {
                    $error = true;
                }
                mysqli_stmt_close($stmt);
            } else {
                $error = true;
            }

            if ($error) {
                header("Location: ../views/especialidad.php?error=Error al insertar la especialidad");
            } else {
                header("Location: ../views/especialidad.php?success=Especialidad creada con éxito");
            }
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Especialidad</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Especialidad</div>
                <div id="welcome-line-2">Rellena los datos de la especialidad</div>
            </div>
            <div class="form-inp">
                <label for="nombre_e">Nombre</label>
                <input type="text" name="nombre_e" id="nombre_e" placeholder="Introduce el nombre" required onblur="validarNombreEspecialidad()">
                <p id="errorNombreEspecialidad"></p>
                <?php if (isset($errores['nombre_e'])): ?>
                    <p class="error"><?php echo $errores['nombre_e']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-inp">
                <label for="descripcion_e">Descripción</label>
                <input type="text" name="descripcion_e" id="descripcion_e" placeholder="Introduce la descripción" required onblur="validarDescripcionEspecialidad()">
                <p id="errorDescripcionEspecialidad"></p>
                <?php if (isset($errores['descripcion_e'])): ?>
                    <p class="error"><?php echo $errores['descripcion_e']; ?></p>
                <?php endif; ?>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/especialidad.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>