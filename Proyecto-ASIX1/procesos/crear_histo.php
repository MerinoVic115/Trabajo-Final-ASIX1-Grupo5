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
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fk_mascota = $_POST['fk_mascota'];
    $observacion = $_POST['observacion_his'];
    $fecha_entrada = $_POST['fecha_entrada_his'];
    $fecha_salida = $_POST['fecha_salida_his'];
    $ingresado = $_POST['ingresado_his'];
    $fk_veterinario = $_POST['Veterinario'];

    // Validación para Mascota
    if (!$fk_mascota) {
        $errores['fk_mascota'] = "La mascota es obligatoria.";
    }

    // Validación para Observación
    if (!$observacion || strlen($observacion) < 3) {
        $errores['observacion_his'] = "La observación es obligatoria y debe tener al menos 3 caracteres.";
    }

    // Validación para Fecha de Entrada
    if (!$fecha_entrada) {
        $errores['fecha_entrada_his'] = "La fecha de entrada es obligatoria.";
    } else {
        $fecha = strtotime($fecha_entrada);
        if (!$fecha) {
            $errores['fecha_entrada_his'] = "La fecha ingresada no es válida.";
        } elseif ((int)date('Y', $fecha) < 2001) {
            $errores['fecha_entrada_his'] = "La fecha no puede ser anterior a 2001.";
        } elseif ($fecha > strtotime(date('Y-m-d'))) {
            $errores['fecha_entrada_his'] = "La fecha no puede ser futura.";
        }
    }

    // Validación para Fecha de Salida
    if (!$fecha_salida) {
        $errores['fecha_salida_his'] = "La fecha de salida es obligatoria.";
    } else {
        $fecha = strtotime($fecha_salida);
        if (!$fecha) {
            $errores['fecha_salida_his'] = "La fecha ingresada no es válida.";
        } elseif ((int)date('Y', $fecha) < 2001) {
            $errores['fecha_salida_his'] = "La fecha no puede ser anterior a 2001.";
        } elseif ($fecha > strtotime(date('Y-m-d'))) {
            $errores['fecha_salida_his'] = "La fecha no puede ser futura.";
        }
    }

    // Validación para Ingresado
    if (!$ingresado) {
        $errores['ingresado_his'] = "La selección es obligatoria.";
    }

    // Validación para Veterinario
    if (!$fk_veterinario) {
        $errores['Veterinario'] = "El veterinario asignado es obligatorio.";
    }

    if (empty($errores)) {
        $query = "INSERT INTO historial 
            (`mascota`, `observacion_his`, `fecha-entrada_his`, `fecha-salida_his`, `ingresado_his`, `veterinario`) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssi", $fk_mascota, $observacion, $fecha_entrada, $fecha_salida, $ingresado, $fk_veterinario);
            if (mysqli_stmt_execute($stmt)) {
                $success = true;
                header("Location: ../views/historial.php?success=Proceso realizado con éxito");
                exit();
            } else {
                $errores['general'] = "Error al realizar el proceso";
            }
            mysqli_stmt_close($stmt);
        } else {
            $errores['general'] = "Error al preparar la consulta";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de creación de historial</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>

<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Historial</div>
                <div id="welcome-line-2">Rellena los datos del historial</div>
            </div>
            <div id="input-area">
                <div class="form-inp" id="div_mascota_his">
                    <label for="fk_mascota">Mascota</label>
                    <select id="mascota_his" name="fk_mascota" required onblur="validarMascotaHis()">
                        <option value="">Seleccionar mascota: </option>
                        <?php
                        $sql = "SELECT Chip, Nombre FROM mascota";
                        $result = mysqli_query($conn, $sql);
                        $listamasc = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($listamasc as $lm) {
                            echo "<option value='{$lm['Chip']}'>{$lm['Nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorMascotaHistorial"></p>
                    <?php if (isset($errores['fk_mascota'])): ?>
                        <p class="error"><?php echo $errores['fk_mascota']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-inp">
                    <label for="observacion_his">Observación</label>
                    <input type="text" name="observacion_his" id="observacion_his" placeholder="Introduce la observación">
                    <?php if (isset($errores['observacion_his'])): ?>
                        <p class="error"><?php echo $errores['observacion_his']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-inp">
                    <label for="fecha_entrada_his">Fecha de entrada</label>
                    <input type="date" name="fecha_entrada_his" id="fecha_entrada_his" required onblur="validarFechaEntradaHis()">
                    <p id="errorfecha_ent_his"></p>
                    <?php if (isset($errores['fecha_entrada_his'])): ?>
                        <p class="error"><?php echo $errores['fecha_entrada_his']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-inp">
                    <label for="fecha_salida_his">Fecha de salida</label>
                    <input type="date" name="fecha_salida_his" id="fecha_salida_his" required onblur="validarFechaSalidaHis()">
                    <p id="errorfecha_sal_his"></p>
                    <?php if (isset($errores['fecha_salida_his'])): ?>
                        <p class="error"><?php echo $errores['fecha_salida_his']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-inp">
                    <label for="ingresado_his">Ingresado</label>
                    <select name="ingresado_his" id="ingresado_his" required onblur="validarFechaIngresadoHis()">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                    <p id="erroringresado_his"></p>
                    <?php if (isset($errores['ingresado_his'])): ?>
                        <p class="error"><?php echo $errores['ingresado_his']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-inp">
                    <label for="Veterinario">Veterinario Asignado</label>
                    <select id="Veterinario_histo" name="Veterinario" required onblur="validarVeterinarioHis()">
                        <option value="">Seleccionar veterinario: </option>
                        <?php
                        $sql = "SELECT Id_Vet, Nombre FROM veterinario";
                        $result = mysqli_query($conn, $sql);
                        $listaVet = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($listaVet as $lv) {
                            echo "<option value='{$lv['Id_Vet']}'>{$lv['Nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorVeterinarioHistorial"></p>
                    <?php if (isset($errores['Veterinario'])): ?>
                        <p class="error"><?php echo $errores['Veterinario']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/historial.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>