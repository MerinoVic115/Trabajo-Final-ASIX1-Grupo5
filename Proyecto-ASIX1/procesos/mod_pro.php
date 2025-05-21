<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Validar si se ha enviado un DNI válido por GET
if (!isset($_GET['DNI']) || empty($_GET['DNI'])) {
    die("ID de propietario no válido. ¿Estás accediendo directamente a esta página? Debes hacerlo desde la lista de propietarios.");
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

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger el ID del formulario, no del GET
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $telf = mysqli_real_escape_string($conn, $_POST['telefono']);
    $direc = mysqli_real_escape_string($conn, $_POST['direccion']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Consulta de actualización
    $update_sql = "UPDATE propietario 
                   SET Nombre = '$nombre', Direccion = '$direc', Telefono = '$telf', Email = '$email' 
                   WHERE DNI = '$id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../views/propietarios.php"); // Redirigir a la lista
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
    <title>Modificar propietario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
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
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($propietario['Nombre'] ?? ''); ?>" required>
                </div>
                <div class="form-inp">
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="<?php echo htmlspecialchars($propietario['Direccion'] ?? ''); ?>">
                </div>
                <div class="form-inp">
                    <label>Teléfono</label>
                    <input type="tel" name="telefono" value="<?php echo htmlspecialchars($propietario['Telefono'] ?? ''); ?>" required>
                </div>
                <div class="form-inp">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($propietario['Email'] ?? ''); ?>">
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
