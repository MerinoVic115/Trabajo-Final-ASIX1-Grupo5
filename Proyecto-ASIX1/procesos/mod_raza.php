<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

$id = null;
$raza = null;

// Si es POST (se ha enviado el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("ID de raza no recibido correctamente.");
    }

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $altura = mysqli_real_escape_string($conn, $_POST['altura']);
    $peso = mysqli_real_escape_string($conn, $_POST['peso']);
    $caracter = mysqli_real_escape_string($conn, $_POST['caracter']);

    $update_sql = "UPDATE raza 
                   SET Nombre = '$nombre', Altura = '$altura', Peso = '$peso', Caracter = '$caracter' 
                   WHERE Id_Raza = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: ../views/raza.php"); // Redirige si se actualiza correctamente
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
} else {
    // Es GET (se accede por URL para editar)
    if (!isset($_GET['Id_raza']) || empty($_GET['Id_raza'])) {
        die("ID de raza no válido.");
    }

    $id = mysqli_real_escape_string($conn, $_GET['Id_raza']);
    $sql = "SELECT * FROM raza WHERE Id_Raza = $id";
    $result = mysqli_query($conn, $sql);
    $raza = mysqli_fetch_assoc($result);

    if (!$raza) {
        die("Raza no encontrada.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar raza</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Raza</div>
                <div id="welcome-line-2">Actualiza los datos de la raza</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($raza['Nombre'] ?? ''); ?>" required>
                </div>
                <div class="form-inp">
                    <label>Altura</label>
                    <input type="text" name="altura" value="<?php echo htmlspecialchars($raza['Altura'] ?? ''); ?>">
                </div>
                <div class="form-inp">
                    <label>Peso</label>
                    <input type="text" name="peso" value="<?php echo htmlspecialchars($raza['Peso'] ?? ''); ?>">
                </div>
                <div class="form-inp">
                    <label>Caracter</label>
                    <input type="text" name="caracter" value="<?php echo htmlspecialchars($raza['Caracter'] ?? ''); ?>">
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/raza.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
