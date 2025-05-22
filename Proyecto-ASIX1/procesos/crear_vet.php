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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $especialidad = $_POST['especialidad'];
    $fecha_contrato = $_POST['fecha_contrato'];
    $salario = $_POST['salario'];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Teléfono
    if (!$telefono) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    } elseif (!preg_match('/^\d{9}$/', $telefono)) {
        $errores['telefono'] = "El teléfono debe tener exactamente 9 dígitos.";
    }

    // Validación PHP para Especialidad
    if (!$especialidad) {
        $errores['especialidad'] = "La especialidad es obligatoria.";
    } elseif (strlen($especialidad) < 3) {
        $errores['especialidad'] = "La especialidad debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $especialidad)) {
        $errores['especialidad'] = "La especialidad no puede contener números.";
    }

    // Validación PHP para Fecha de Contrato
    if (!$fecha_contrato) {
        $errores['fecha_contrato'] = "La fecha de contrato es obligatoria.";
    } else {
        $fechaIngresada = strtotime($fecha_contrato);
        if (!$fechaIngresada) {
            $errores['fecha_contrato'] = "La fecha ingresada no es válida.";
        } elseif ($fechaIngresada > strtotime(date('Y-m-d'))) {
            $errores['fecha_contrato'] = "La fecha de contrato no puede ser futura.";
        }
    }

    // Validación PHP para Salario
    if (!$salario) {
        $errores['salario'] = "El salario es obligatorio.";
    } elseif (!is_numeric($salario)) {
        $errores['salario'] = "El salario debe ser un número.";
    } elseif ($salario <= 0) {
        $errores['salario'] = "El salario debe ser un número positivo.";
    } elseif ($salario > 20000) {
        $errores['salario'] = "El salario no puede superar 20000.";
    }

    
    // Solo insertar si no hay errores
    if (empty($errores)) {

        // Consulta para insertar los datos
        $query1 = "INSERT INTO veterinario (`Nombre`, `Telefono`, `Especialidad`, `Fecha_Contrato`, `Salario`) VALUES (?, ?, ?, ?, ?)";
        $sentencia1 = mysqli_prepare($conn, $query1);

        if ($sentencia1) {
            mysqli_stmt_bind_param($sentencia1, "ssssd", $nombre, $telefono, $especialidad, $fecha_contrato, $salario);

            if (!mysqli_stmt_execute($sentencia1)) {
                $error = true;
            }
            mysqli_stmt_close($sentencia1);
        } else {
            $error = true;
        }

        if ($error) {
            header("Location: ../views/principal.php?error=" . urlencode("Error al insertar el veterinario."));
        } else {
            header("Location: ../views/veterinarios.php?success=" . urlencode("Veterinario creado correctamente."));
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
    <title>Formulario de creación de veterinario</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>

<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Veterinario</div>
                <div id="welcome-line-2">Rellena los datos del veterinario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="vet_nombre" placeholder="Introduce el nombre del veterinario" required onblur="validarNombreVet()">
                    <p id="errorNombreVet"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="vet_telefono" placeholder="Introduce el teléfono" required onblur="validarTelefonoVet()">
                    <p id="errorTelefonoVet"><?php echo isset($errores['telefono']) ? $errores['telefono'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label for="especialidad">Especialidad</label>
                    <input type="text" name="especialidad" id="vet_especialidad" placeholder="Introduce la especialidad" required onblur="validarEspecialidadVet()">
                    <p id="errorEspecialidadVet"><?php echo isset($errores['especialidad']) ? $errores['especialidad'] : ''; ?></p>
                    
                </div>
                <div class="form-inp">
                    <label for="fecha_contrato">Fecha de Contrato</label>
                    <input type="date" name="fecha_contrato" id="vet_fecha_contrato" required onblur="validarFechaContratoVet()">
                    <p id="errorFechaContratoVet"><?php echo isset($errores['fecha_contrato']) ? $errores['fecha_contrato'] : ''; ?></p>                    
                </div>
                <div class="form-inp">
                    <label for="salario">Salario</label>
                    <input type="number" name="salario" id="vet_salario" placeholder="Introduce el salario" required onblur="validarSalarioVet()">
                    <p id="errorSalarioVet"><?php echo isset($errores['salario']) ? $errores['salario'] : ''; ?></p>
                    
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/veterinarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>