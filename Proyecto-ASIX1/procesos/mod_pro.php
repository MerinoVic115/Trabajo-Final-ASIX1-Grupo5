<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un DNI válido
if (!isset($_GET['DNI'])) {
    echo "ID de propietario no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['DNI']);

// Obtener datos del propietario
$sql = "SELECT * FROM propietario WHERE DNI = '$id'";
$result = mysqli_query($conn, $sql);
$propietario = mysqli_fetch_assoc($result);

if (!$propietario) {
    echo "Propietario no encontrado.";
    exit();
}


// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $direc = $_POST['direccion'];
    $telf = $_POST['telefono'];
    $email = $_POST['email'];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Dirección
    if (!$direc || strlen($direc) < 5) {
        $errores['direccion'] = "La dirección es obligatoria y debe tener al menos 5 caracteres.";
    }

    // Validación PHP para Teléfono
    if (!$telf) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    } elseif (!preg_match('/^\d{9}$/', $telf)) {
        $errores['telefono'] = "El teléfono debe tener exactamente 9 dígitos.";
    }

    // Validación PHP para Email
    if (!$email) {
        $errores['email'] = "El email es obligatorio.";
    } elseif (!preg_match('/^[\w.+-]+@[\w.-]+\.[a-zA-Z]{2,10}$/', $email)) {
        $errores['email'] = "El formato de email no es válido.";
    }

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $nombre = mysqli_real_escape_string($conn, $nombre);
        $direc = mysqli_real_escape_string($conn, $direc);
        $telf = mysqli_real_escape_string($conn, $telf);
        $email = mysqli_real_escape_string($conn, $email);

        $update_sql = "UPDATE propietario 
                       SET Nombre = '$nombre', Direccion = '$direc', Telefono = '$telf', Email = '$email' 
                       WHERE DNI = '$id'";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: ../views/propietarios.php");
            exit();
        } else {
            echo "Error al actualizar los datos: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar propietario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="mod_pro.php?DNI=<?php echo urlencode($propietario['DNI']); ?>" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($propietario['DNI']); ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Propietario</div>
                <div id="welcome-line-2">Actualiza los datos del propietario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Nombre</label>
                    <input type="text" name="nombre" id="mod_propietario_nombre" value="<?php echo htmlspecialchars($propietario['Nombre'] ?? ''); ?>" required onblur="validarNombrePropietarioMod()">
                    <p id="errorModNombrePropietario"><?php echo $errores['nombre'] ?? ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Dirección</label>
                    <input type="text" name="direccion" id="mod_propietario_direccion" value="<?php echo htmlspecialchars($propietario['Direccion'] ?? ''); ?>" onblur="validarDireccionPropietarioMod()">
                    <p id="errorModDireccionPropietario"><?php echo $errores['direccion'] ?? ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" id="mod_propietario_telefono" value="<?php echo htmlspecialchars($propietario['Telefono'] ?? ''); ?>" required onblur="validarTelefonoPropietarioMod()">
                    <p id="errorModTelefonoPropietario"><?php echo $errores['telefono'] ?? ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Email</label>
                    <input type="text" name="email" id="mod_propietario_email" value="<?php echo htmlspecialchars($propietario['Email'] ?? ''); ?>" onblur="validarEmailPropietarioMod()">
                    <p id="errorModEmailPropietario"><?php echo $errores['email'] ?? ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/propietarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
