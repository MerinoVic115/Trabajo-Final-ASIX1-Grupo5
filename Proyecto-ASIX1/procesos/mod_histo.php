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
if (!isset($_GET['id_historial'])) {
    echo "ID de historial no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id_historial']);

// Obtener datos del historial
$sql = "SELECT * FROM historial WHERE id_historial = $id";
$result = mysqli_query($conn, $sql);
$histo = mysqli_fetch_assoc($result);

if (!$histo) {
    echo "Historial no encontrado.";
    exit();
}

// Obtener mascotas, veterinarios y razas para los selects
$mascotas = [];
$veterinarios = [];
$razas = [];
$resMasc = mysqli_query($conn, "SELECT Chip, Nombre FROM mascota");
while ($row = mysqli_fetch_assoc($resMasc)) {
    $mascotas[] = $row;
}
$resVet = mysqli_query($conn, "SELECT Id_Vet, Nombre FROM veterinario");
while ($row = mysqli_fetch_assoc($resVet)) {
    $veterinarios[] = $row;
}
$resRaza = mysqli_query($conn, "SELECT Id_Raza, Nombre FROM raza");
while ($row = mysqli_fetch_assoc($resRaza)) {
    $razas[] = $row;
}

// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacion = $_POST['observacion'] ?? '';
    $fecha_entrada = $_POST['fecha_entrada'] ?? '';
    $fecha_salida = $_POST['fecha_salida'] ?? '';
    $ingresado = $_POST['ingresado'] ?? '';
    $mascota = $_POST['mascota'] ?? '';
    $veterinario = $_POST['veterinario'] ?? '';

    // Validación para Observación
    if (!$observacion || strlen($observacion) < 3) {
        $errores['observacion'] = "La observación es obligatoria y debe tener al menos 3 caracteres.";
    }

    // Validación para Fecha de Entrada
    if (!$fecha_entrada) {
        $errores['fecha_entrada'] = "La fecha de entrada es obligatoria.";
    } else {
        $fechaEnt = strtotime($fecha_entrada);
        if (!$fechaEnt) {
            $errores['fecha_entrada'] = "La fecha de entrada no es válida.";
        } elseif ($fechaEnt > strtotime(date('Y-m-d'))) {
            $errores['fecha_entrada'] = "La fecha de entrada no puede ser futura.";
        }
    }

    // Validación para Fecha de Salida
    if (!$fecha_salida) {
        $errores['fecha_salida'] = "La fecha de salida es obligatoria.";
    } else {
        $fechaSal = strtotime($fecha_salida);
        if (!$fechaSal) {
            $errores['fecha_salida'] = "La fecha de salida no es válida.";
        } elseif ($fechaSal > strtotime(date('Y-m-d'))) {
            $errores['fecha_salida'] = "La fecha de salida no puede ser futura.";
        }
    }

    // Validación para Ingresado
    if (!$ingresado) {
        $errores['ingresado'] = "El campo ingresado es obligatorio.";
    } elseif ($ingresado !== "Sí" && $ingresado !== "No") {
        $errores['ingresado'] = "El campo ingresado debe ser 'Sí' o 'No'.";
    }

    // Validación para Mascota
    if (!$mascota) {
        $errores['mascota'] = "La mascota es obligatoria.";
    }

    // Validación para Veterinario
    if (!$veterinario) {
        $errores['veterinario'] = "El veterinario es obligatorio.";
    }

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $update_sql = "UPDATE historial 
            SET observacion_his = ?, 
                `fecha-entrada_his` = ?, 
                `fecha-salida_his` = ?, 
                ingresado_his = ?,
                mascota = ?,
                veterinario = ?
            WHERE id_historial = ?";

        $stmt = mysqli_prepare($conn, $update_sql);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt, "ssssiii",
                $observacion, $fecha_entrada, $fecha_salida, $ingresado,
                $mascota, $veterinario, $id
            );
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Historial actualizado correctamente.')</script>";
                header("Location: ../views/historial.php");
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
    <title>Modificar historial</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../validaciones/js/validacion.js"></script>
</head>

<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($histo['id_historial'] ?? $id); ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Historial</div>
                <div id="welcome-line-2">Actualiza los datos del historial</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Observaciones</label>
                    <input type="text" id="observacion" name="observacion" value="<?php echo htmlspecialchars($histo['observacion_his'] ?? ''); ?>">
                    
                </div>
                <div class="form-inp">
                    <label>Fecha Entrada</label>
                    <input type="date" id="fecha_mod_entrada_his" name="fecha_entrada" value="<?php echo isset($histo['fecha-entrada_his']) ? htmlspecialchars($histo['fecha-entrada_his']) : ''; ?>" required onblur="modFechaEntradaHis()">
                    <p id="errorfecha_mod_ent_his"><?php echo isset($errores['fecha_entrada']) ? $errores['fecha_entrada'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Fecha Salida</label>
                    <input type="date" id="fecha_mod_salida_his" name="fecha_salida" value="<?php echo isset($histo['fecha-salida_his']) ? htmlspecialchars($histo['fecha-salida_his']) : ''; ?>" required onblur="modFechaSalidaHis()">
                    <p id="errorfecha_mod_sal_his"><?php echo isset($errores['fecha_salida']) ? $errores['fecha_salida'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Ingresado</label>
                    <select name="ingresado" id="mod_ingresado_his" required onblur="modIngresadoHis()">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí" <?php echo (isset($histo['ingresado_his']) && $histo['ingresado_his'] == 'Sí') ? 'selected' : ''; ?>>Sí</option>
                        <option value="No" <?php echo (isset($histo['ingresado_his']) && $histo['ingresado_his'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                    <p id="errorModIngresadoHis"><?php echo isset($errores['ingresado']) ? $errores['ingresado'] : ''; ?></p>
                    
                </div>
                <div class="form-inp">
                    <label>Mascota</label>
                    <select name="mascota" id="mod_mascota_his" required onblur="modMascotaHis()">
                        <option value="">Seleccionar mascota</option>
                        <?php foreach ($mascotas as $m): 
                            $selected = (isset($histo['mascota']) && $histo['mascota'] == $m['Chip']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $m['Chip']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($m['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="errorModMascotaHistorial"><?php echo isset($errores['mascota']) ? $errores['mascota'] : ''; ?></p>
                    
                    
                </div>
                
                <div class="form-inp">
                    <label>Veterinario</label>
                    <select name="veterinario" id="mod_veterinario_his" required onblur="modVeterinarioHis()">
                        <option value="">Seleccionar veterinario</option>
                        <?php foreach ($veterinarios as $v): 
                            $selected = (isset($histo['veterinario']) && $histo['veterinario'] == $v['Id_Vet']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $v['Id_Vet']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($v['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="errorModVeterinarioHistorial"><?php echo isset($errores['veterinario']) ? $errores['veterinario'] : ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/historial.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>