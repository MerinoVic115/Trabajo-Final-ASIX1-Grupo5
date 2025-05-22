<?php
include "../conexion/conexion.php";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$error = false;
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}



// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telf = $_POST['telefono'];
    $email = $_POST['email'];

    // Validación PHP para DNI
    if (!$dni) {
        $errores['dni'] = "El DNI es obligatorio.";
    } elseif (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
        $errores['dni'] = "El DNI debe tener 8 números y una letra.";
    }

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Dirección
    if (!$direccion || strlen($direccion) < 5) {
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


    // Solo insertar si no hay errores
    if (empty($errores)) {
        // Consulta para insertar los datos
        $query1 = "INSERT INTO propietario (`DNI`, `Nombre`, `Direccion`, `Telefono`, `Email`) VALUES (?, ?, ?, ?, ?)";
        $sentencia1 = mysqli_prepare($conn, $query1);

        if ($sentencia1) {
            mysqli_stmt_bind_param($sentencia1, "sssss", $dni, $nombre, $direccion, $telf, $email);

            if (!mysqli_stmt_execute($sentencia1)) {
                $error = true;
            }
            mysqli_stmt_close($sentencia1);
        } else {
            $error = true;
        }

        if ($error) {
            header("Location: ../views/principal.php?error=Problema al insertar el propietario");
        } else {
            header("Location: ../views/propietarios.php?success=Propietario creado correctamente");
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
    <title>Formulario de creación de propietario</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Propietario</div>
                <div id="welcome-line-2">Rellena los datos de la propietario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>DNI</label>
                    <input type="text" name="dni" id="propietario_dni" placeholder="Introduce el DNI del propietario" required onblur="validarDNIPropietario()">
                    <p id="errorDNIPropietario"></p>
                    <?php if (isset($errores['dni'])): ?>
                        <p class="error"><?php echo $errores['dni']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-inp">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" id="propietario_nombre" placeholder="Introduce el nombre de la propietario" required onblur="validarNombrePropietario()">
                    <p id="errorNombrePropietario"></p>
                    <?php if (isset($errores['nombre'])): ?>
                        <p class="error"><?php echo $errores['nombre']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-inp">
                    <label>Direccion:</label>
                    <input type="text" name="direccion" id="propietario_direccion" placeholder="Introduce la direccion del propietario" required onblur="validarDireccionPropietario()">
                    <p id="errorDireccionPropietario"></p>
                    <?php if (isset($errores['direccion'])): ?>
                        <p class="error"><?php echo $errores['direccion']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-inp">
                    <label>Teléfono:</label>
                    <input type="text" name="telefono" id="propietario_telefono" placeholder="Introduce el telefono del propietario" required onblur="validarTelefonoPropietario()">
                    <p id="errorTelefonoPropietario"></p>
                    <?php if (isset($errores['telefono'])): ?>
                        <p class="error"><?php echo $errores['telefono']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-inp">
                    <label>Email:</label>
                    <input type="text" name="email" id="propietario_email" placeholder="Introduce el email del propietario" required onblur="validarEmailPropietario()">
                    <p id="errorEmailPropietario"></p>
                    <?php if (isset($errores['email'])): ?>
                        <p class="error"><?php echo $errores['email']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/propietarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>