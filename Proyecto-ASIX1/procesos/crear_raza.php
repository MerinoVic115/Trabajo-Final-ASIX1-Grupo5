<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}


// Validaciones PHP
$errores = [];
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $caracter = $_POST['caracter'];

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

    if (empty($errores)) {
        $query1 = "INSERT INTO Raza (`Nombre`, `Altura`, `Peso`, `Caracter`) VALUES (?, ?, ?, ?)";
        $sentencia1 = mysqli_prepare($conn, $query1);

        if ($sentencia1) {
            mysqli_stmt_bind_param($sentencia1, "siis", $nombre, $altura, $peso, $caracter);

            if (!mysqli_stmt_execute($sentencia1)) {
                $error = true;
            }
            mysqli_stmt_close($sentencia1);
        } else {
            $error = true;
        }

        if ($error) {
            header("Location: ../views/principal.php?error=" . urlencode("Problema al insertar la raza"));
        } else {
            header("Location: ../views/raza.php?success=" . urlencode("Raza creada correctamente"));
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de creación de razas</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Raza</div>
                <div id="welcome-line-2">Rellena los datos de la raza</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="raza_nombre" placeholder="Introduce el nombre de la raza" required onblur="validarNombreRaza()">
                    <p id="errorNombreRaza"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="altura">Altura</label>
                    <input type="number" name="altura" id="raza_altura" placeholder="Introduce la altura de la raza" required onblur="validarAlturaRaza()">
                    <p id="errorAlturaRaza"><?php echo isset($errores['altura']) ? $errores['altura'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="peso">Peso</label>
                    <input type="number" name="peso" id="raza_peso" placeholder="Introduce el peso de la raza" required onblur="validarPesoRaza()">
                    <p id="errorPesoRaza"><?php echo isset($errores['peso']) ? $errores['peso'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="caracter">Caracter</label>
                    <input type="text" name="caracter" id="raza_caracter" placeholder="Introduce el caracter de la raza" onblur="validarCaracterRaza()">
                    <p id="errorCaracterRaza"><?php echo isset($errores['caracter']) ? $errores['caracter'] : ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/raza.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>