<?php
include "../conexion/conexion.php";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$error = false;
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $sexo = strtoupper(trim($_POST['sexo']));
    $fechanaci = $_POST['fecha'];
    $especie = trim($_POST['especie']);
    $raza = $_POST['raza'];
    $propietario = $_POST['propietario'];
    $veterinario = $_POST['veterinario'];

    $errores = [];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 2 || preg_match('/\d/', $nombre)) {
        $errores[] = "El nombre es obligatorio, debe tener al menos 2 caracteres y no contener números.";
    }

    // Validación PHP para Sexo (solo M o F)
    if ($sexo !== "M" && $sexo !== "F") {
        $errores[] = "El sexo debe ser 'M' para Macho o 'F' para Hembra.";
    }

    // Validación PHP para Fecha Nacimiento
    if (!$fechanaci) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } else {
        $fechaIngresada = strtotime($fechanaci);
        if (!$fechaIngresada) {
            $errores[] = "La fecha ingresada no es válida.";
        } else {
            $anio = (int)date('Y', $fechaIngresada);
            if ($anio < 2001) {
                $errores[] = "La fecha no puede ser anterior a 2001.";
            }
            $hoy = strtotime(date('Y-m-d'));
            $limite = strtotime('-2 months');
            if ($fechaIngresada > $hoy) {
                $errores[] = "La fecha no puede ser futura.";
            }
            if ($fechaIngresada > $limite) {
                $errores[] = "La fecha no puede ser de una mascota con menos de 2 meses.";
            }
        }
    }

    // Validación PHP para Especie
    if (!$especie || strlen($especie) < 3 || preg_match('/\d/', $especie)) {
        $errores[] = "La especie es obligatoria, debe tener al menos 3 caracteres y no contener números.";
    }

    // Validación PHP para Raza
    if (!$raza) {
        $errores[] = "La raza es obligatoria.";
    }

    // Validación PHP para Propietario
    if (!$propietario) {
        $errores[] = "El propietario es obligatorio.";
    }

    // Validación PHP para Veterinario
    if (!$veterinario) {
        $errores[] = "El veterinario es obligatorio.";
    }

    if (!empty($errores)) {
        // Mostrar errores arriba del formulario
        echo '<div style="color:red; margin-bottom:20px;"><ul>';
        foreach ($errores as $err) {
            echo "<li>$err</li>";
        }
        echo '</ul></div>';
    } else {
        // --- CORRECCIÓN DE INSERCIÓN FK ---
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

        // Si no existe alguna FK, error
        if (!$idRaza) {
            echo '<div style="color:red; margin-bottom:20px;">La raza seleccionada no existe.</div>';
        } elseif (!$dniProp) {
            echo '<div style="color:red; margin-bottom:20px;">El propietario seleccionado no existe.</div>';
        } elseif (!$idVet) {
            echo '<div style="color:red; margin-bottom:20px;">El veterinario seleccionado no existe.</div>';
        } else {
            // Consulta para insertar los datos
            $query1 = "INSERT INTO mascota (Nombre, Sexo, Fecha_Nacimiento, Especie, Raza, Propietario, Veterinario) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $sentencia1 = mysqli_prepare($conn, $query1);

            if ($sentencia1) {
                // Usar los IDs reales para las FK
                mysqli_stmt_bind_param($sentencia1, "sssssss", $nombre, $sexo, $fechanaci, $especie, $idRaza, $dniProp, $idVet);

                if (!mysqli_stmt_execute($sentencia1)) {
                    $error = true;
                }
                mysqli_stmt_close($sentencia1);
            } else {
                $error = true;
            }

            if ($error) {
                header("Location: ../views/principal.php?error=2");
            } else {
                header("Location: ../views/mascotas.php?success=1");
            }
            exit();
        }
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
                    <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre de la mascota" required onblur="validarNombreMascota()">
                    <p id="errorNombreMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Sexo:</label>
                    <input type="text" name="sexo" id="sexo" placeholder="Introduce el sexo de la mascota (M/F)" maxlength="1" required onblur="validarSexoMascota()">
                    <p id="errorSexoMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Fecha Nacimiento:</label>
                    <input type="date" name="fecha" id="fecha" placeholder="Introduce la fecha de nacimiento de la mascota" required onblur="validarFechaMascota()">
                    <p id="errorFechaMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Especie:</label>
                    <input type="text" name="especie" id="especie" placeholder="Introduce la especie de la mascota" onblur="validarEspecieMascota()">
                    <p id="errorEspecieMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Raza:</label>
                    <select id="raza" name="raza" required onblur="validarRazaMascota()">
                        <option value="">Seleccionar raza: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM raza";
                        $result = mysqli_query($conn, $sql);
                        $listarazas = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($listarazas as $lr) {
                            echo "<option value='{$lr['nombre']}'>{$lr['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorRazaMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Propietario:</label>
                    <select id="propietario" name="propietario" required onblur="validarPropietarioMascota()">
                        <option value="">Seleccionar propietario: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM propietario";
                        $result = mysqli_query($conn, $sql);
                        $listaprop = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($listaprop as $lp) {
                            echo "<option value='{$lp['nombre']}'>{$lp['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorPropietarioMascota"></p>
                </div>
                <div class="form-inp">
                    <label>Veterinario:</label>
                    <select id="veterinario" name="veterinario" required onblur="validarVeterinarioMascota()">
                        <option value="">Seleccionar veterinario: </option>
                        <?php
                        $sql = "SELECT DISTINCT nombre FROM veterinario";
                        $result = mysqli_query($conn, $sql);
                        $listavet = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        foreach ($listavet as $lv) {
                            echo "<option value='{$lv['nombre']}'>{$lv['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <p id="errorVeterinarioMascota"></p>
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