<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['Id_Raza']) || !is_numeric($_GET['Id_Raza'])) {
    echo "ID de raza no válido.";
    exit();
}

$id = intval($_GET['Id_Raza']);

// Obtener datos de la raza
$sql = "SELECT * FROM raza WHERE Id_Raza = $id";
$result = mysqli_query($conn, $sql);
$raza = mysqli_fetch_assoc($result);

if (!$raza) {
    echo "Raza no encontrada.";
    exit();
}

// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['mod_raza_nombre'];
    $altura = $_POST['mod_raza_altura'];
    $peso = $_POST['mod_raza_peso'];
    $caracter = $_POST['mod_raza_caracter'];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Altura
    if (!$altura) {
        $errores['altura'] = "La altura es obligatoria.";
    } elseif (!is_numeric($altura) || $altura <= 0) {
        $errores['altura'] = "La altura debe ser un número positivo.";
    }

    // Validación PHP para Peso
    if (!$peso) {
        $errores['peso'] = "El peso es obligatorio.";
    } elseif (!is_numeric($peso) || $peso <= 0) {
        $errores['peso'] = "El peso debe ser un número positivo.";
    }

    // Validación PHP para Caracter
    if (!$caracter || strlen($caracter) < 3) {
        $errores['caracter'] = "El carácter es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $caracter)) {
        $errores['caracter'] = "El carácter no puede contener números.";
    }

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $update_sql = "UPDATE raza SET Nombre = ?, Altura = ?, Peso = ?, Caracter = ? WHERE Id_Raza = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $altura, $peso, $caracter, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../views/raza.php");
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
    <title>Modificar raza</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../validaciones/js/validacion.js"></script>
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
                    <input type="text" name="mod_raza_nombre" id="mod_raza_nombre" value="<?php echo htmlspecialchars(isset($_POST['mod_raza_nombre']) ? $_POST['mod_raza_nombre'] : ($raza['Nombre'] ?? '')); ?>" required onblur="validarNombreRazaMod()">
                    <p id="errorModNombreRaza"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Altura</label>
                    <input type="text" name="mod_raza_altura" id="mod_raza_altura" value="<?php echo htmlspecialchars(isset($_POST['mod_raza_altura']) ? $_POST['mod_raza_altura'] : ($raza['Altura'] ?? '')); ?>" required onblur="validarAlturaRazaMod()">
                    <p id="errorModAlturaRaza"><?php echo isset($errores['altura']) ? $errores['altura'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Peso</label>
                    <input type="text" name="mod_raza_peso" id="mod_raza_peso" value="<?php echo htmlspecialchars(isset($_POST['mod_raza_peso']) ? $_POST['mod_raza_peso'] : ($raza['Peso'] ?? '')); ?>" required onblur="validarPesoRazaMod()">
                    <p id="errorModPesoRaza"><?php echo isset($errores['peso']) ? $errores['peso'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Caracter</label>
                    <input type="text" name="mod_raza_caracter" id="mod_raza_caracter" value="<?php echo htmlspecialchars(isset($_POST['mod_raza_caracter']) ? $_POST['mod_raza_caracter'] : ($raza['Caracter'] ?? '')); ?>" required onblur="validarCaracterRazaMod()">
                    <p id="errorModCaracterRaza"><?php echo isset($errores['caracter']) ? $errores['caracter'] : ''; ?></p>
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
