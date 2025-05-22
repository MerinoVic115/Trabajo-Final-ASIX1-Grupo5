<?php
include "../conexion/conexion.php";

// Comprobar si el usuario ha iniciado sesión
$id = isset($_GET['id']) ? $_GET['id'] : '';
$error = false;
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}



// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $sexo = strtoupper(trim($_POST['sexo']));
    $fechanaci = $_POST['fecha'];
    $especie = trim($_POST['especie']);
    $raza = $_POST['raza'];
    $propietario = $_POST['propietario'];
    $veterinario = $_POST['veterinario'];

    // Validación PHP para Nombre (mínimo 2 caracteres, sin números)
    if (!$nombre || strlen($nombre) < 2) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 2 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Sexo (solo M o F)
    if (!$sexo) {
        $errores['sexo'] = "El sexo es obligatorio.";
    } elseif ($sexo !== "M" && $sexo !== "F") {
        $errores['sexo'] = "El sexo debe ser 'M' para Masculino o 'F' para Femenino.";
    }

    // Validación PHP para Fecha Nacimiento
    if (!$fechanaci) {
        $errores['fecha'] = "La fecha de nacimiento es obligatoria.";
    } else {
        $fechaIngresada = strtotime($fechanaci);
        if (!$fechaIngresada) {
            $errores['fecha'] = "La fecha ingresada no es válida.";
        } elseif ((int)date('Y', $fechaIngresada) < 2001) {
            $errores['fecha'] = "La fecha no puede ser anterior a 2001.";
        } else {
            $hoy = strtotime(date('Y-m-d'));
            $limite = strtotime('-2 months');
            if ($fechaIngresada > $hoy) {
                $errores['fecha'] = "La fecha no puede ser futura.";
            } elseif ($fechaIngresada > $limite) {
                $errores['fecha'] = "La fecha no puede ser de una mascota con menos de 2 meses.";
            }
        }
    }

    // Validación PHP para Especie
    if (!$especie) {
        $errores['especie'] = "La especie es obligatoria.";
    } elseif (strlen($especie) < 3) {
        $errores['especie'] = "La especie debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $especie)) {
        $errores['especie'] = "La especie no puede contener números.";
    }

    // Validación PHP para Raza
    if (!$raza) {
        $errores['raza'] = "La raza es obligatoria.";
    }

    // Validación PHP para Propietario
    if (!$propietario) {
        $errores['propietario'] = "El propietario es obligatorio.";
    }

    // Validación PHP para Veterinario
    if (!$veterinario) {
        $errores['veterinario'] = "El veterinario es obligatorio.";
    }

    if (empty($errores)) {
        // Obtener el Id_Raza real a partir del nombre seleccionado
        $sqlRaza = "SELECT Id_Raza FROM raza WHERE nombre = ?";
        $stmtRaza = mysqli_prepare($conn, $sqlRaza);
        mysqli_stmt_bind_param($stmtRaza, "s", $raza);
        mysqli_stmt_execute($stmtRaza);
        mysqli_stmt_bind_result($stmtRaza, $idRaza);
        mysqli_stmt_fetch($stmtRaza);
        mysqli_stmt_close($stmtRaza);

        // Obtener el DNI del propietario a partir del nombre seleccionado
        $sqlProp = "SELECT DNI FROM propietario WHERE nombre = ?";
        $stmtProp = mysqli_prepare($conn, $sqlProp);
        mysqli_stmt_bind_param($stmtProp, "s", $propietario);
        mysqli_stmt_execute($stmtProp);
        mysqli_stmt_bind_result($stmtProp, $dniProp);
        mysqli_stmt_fetch($stmtProp);
        mysqli_stmt_close($stmtProp);

        // Obtener el Id_Vet del veterinario a partir del nombre seleccionado
        $sqlVet = "SELECT Id_Vet FROM veterinario WHERE nombre = ?";
        $stmtVet = mysqli_prepare($conn, $sqlVet);
        mysqli_stmt_bind_param($stmtVet, "s", $veterinario);
        mysqli_stmt_execute($stmtVet);
        mysqli_stmt_bind_result($stmtVet, $idVet);
        mysqli_stmt_fetch($stmtVet);
        mysqli_stmt_close($stmtVet);

        $error = false;
        if (!$idRaza) {
            $error = true;
            $errorMsg = "La raza seleccionada no existe.";
        } elseif (!$dniProp) {
            $error = true;
            $errorMsg = "El propietario seleccionado no existe.";
        } elseif (!$idVet) {
            $error = true;
            $errorMsg = "El veterinario seleccionado no existe.";
        } else {
            // Consulta para insertar los datos de la mascota
            $query1 = "INSERT INTO mascota (`Nombre`, `Sexo`, `Fecha_Nacimiento`, `Especie`, `Raza`, `Propietario`, `Veterinario`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $sentencia1 = mysqli_prepare($conn, $query1);

            if ($sentencia1) {
                mysqli_stmt_bind_param($sentencia1, "sssssss", $nombre, $sexo, $fechanaci, $especie, $idRaza, $dniProp, $idVet);

                if (!mysqli_stmt_execute($sentencia1)) {
                    $error = true;
                    $errorMsg = "Problema al insertar la mascota";
                }
                mysqli_stmt_close($sentencia1);
            } else {
                $error = true;
                $errorMsg = "Problema al preparar la consulta";
            }
        }

        if ($error) {
            header("Location: ../views/principal.php?error=" . urlencode($errorMsg));
        } else {
            header("Location: ../views/mascotas.php?success=" . urlencode("Mascota creada correctamente"));
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
    <title>Formulario de creación de mascota</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <script src="../validaciones/js/validacion.js"></script>
</head>

<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Mascota</div>
                <div id="welcome-line-2">Rellena los datos de la mascota</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Nombre</label>
                    <input type="text" name="nombre" id="nombrepets" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" placeholder="Introduce el nombre de la mascota" required onblur="validarNombreMascota()">
                    <p id="errorNombreMascota" style="color:black;"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Sexo:</label>
                    <input type="text" name="sexo" id="sexopets" value="<?php echo isset($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : ''; ?>" placeholder="Introduce el sexo de la mascota (M/F)" maxlength="1" required onblur="validarSexoMascota()">
                    <p id="errorSexoMascota" style="color:black;"><?php echo isset($errores['sexo']) ? $errores['sexo'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Fecha Nacimiento:</label>
                    <input type="date" name="fecha" id="fechapets" value="<?php echo isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : ''; ?>" placeholder="Introduce la fecha de nacimiento de la mascota" required onblur="validarFechaMascota()">
                    <p id="errorFechaMascota" style="color:black;"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Especie:</label>
                    <input type="text" name="especie" id="especiepets" value="<?php echo isset($_POST['especie']) ? htmlspecialchars($_POST['especie']) : ''; ?>" placeholder="Introduce la especie de la mascota" onblur="validarEspecieMascota()">
                    <p id="errorEspecieMascota" style="color:black;"><?php echo isset($errores['especie']) ? $errores['especie'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Raza:</label>
                    <select id="razapets" name="raza" required onblur="validarRazaMascota()">
                        <option value="">Seleccionar raza: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM raza";
                        $result = mysqli_query($conn, $sql);
                        $listarazas = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        foreach ($listarazas as $lr) {
                            $selected = (isset($_POST['raza']) && $_POST['raza'] == $lr['nombre']) ? 'selected' : '';
                            echo "<option value='{$lr['nombre']}' $selected>{$lr['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorRazaMascota" style="color:black;"><?php echo isset($errores['raza']) ? $errores['raza'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Propietario:</label>
                    <select id="propietariopets" name="propietario" required onblur="validarPropietarioMascota()">
                        <option value="">Seleccionar propietario: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM propietario";
                        $result = mysqli_query($conn, $sql);
                        $listaprop = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        foreach ($listaprop as $lp) {
                            $selected = (isset($_POST['propietario']) && $_POST['propietario'] == $lp['nombre']) ? 'selected' : '';
                            echo "<option value='{$lp['nombre']}' $selected>{$lp['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorPropietarioMascota" style="color:black;"><?php echo isset($errores['propietario']) ? $errores['propietario'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Veterinario:</label>
                    <select id="veterinariopets" name="veterinario" required onblur="validarVeterinarioMascota()">
                        <option value="">Seleccionar veterinario: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM veterinario";
                        $result = mysqli_query($conn, $sql);
                        $listavet = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        foreach ($listavet as $lv) {
                            $selected = (isset($_POST['veterinario']) && $_POST['veterinario'] == $lv['nombre']) ? 'selected' : '';
                            echo "<option value='{$lv['nombre']}' $selected>{$lv['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorVeterinarioMascota" style="color:black;"><?php echo isset($errores['veterinario']) ? $errores['veterinario'] : ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/mascotas.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>