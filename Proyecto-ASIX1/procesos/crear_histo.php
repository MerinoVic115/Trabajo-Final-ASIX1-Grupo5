<?php
include "../conexion/conexion.php";

$error = false;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['fk_mascota']) &&
        isset($_POST['observacion_his']) &&
        isset($_POST['fecha_entrada_his']) &&
        isset($_POST['fecha_salida_his']) &&
        isset($_POST['ingresado_his']) &&
        isset($_POST['Veterinario']) // ✅ agregar esta validación
    ) {
        // Capturar los datos del formulario
        $fk_mascota = $_POST['fk_mascota']; // ✅ ojo: aquí usabas mal 'mascota'
        $fk_veterinario = $_POST['Veterinario']; // ✅ capturamos correctamente
        $observacion = $_POST['observacion_his'];
        $fecha_entrada = $_POST['fecha_entrada_his'];
        $fecha_salida = $_POST['fecha_salida_his'];
        $ingresado = $_POST['ingresado_his'];

        // Consulta corregida con veterinario incluido
        $query = "INSERT INTO historial 
            (`mascota`, `observacion_his`, `fecha-entrada_his`, `fecha-salida_his`, `ingresado_his`, `veterinario`) 
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssi", $fk_mascota, $observacion, $fecha_entrada, $fecha_salida, $ingresado, $fk_veterinario);
            if (!mysqli_stmt_execute($stmt)) {
                $error = true;
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = true;
        }

        if ($error) {
            header("Location: ../views/principal.php?error=2");
        } else {
            header("Location: ../views/historial.php?success=1");
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
    <title>Formulario de creación de historial</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
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
                <div class="form-inp">
                    <label for="fk_mascota">Mascota</label>
                    <select id="fk_mascota" name="fk_mascota" required>
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
                </div>
                <div class="form-inp">
                    <label for="observacion_his">Observación</label>
                    <input type="text" name="observacion_his" id="observacion_his" placeholder="Introduce la observación">
                </div>
                <div class="form-inp">
                    <label for="fecha_entrada_his">Fecha de entrada</label>
                    <input type="date" name="fecha_entrada_his" id="fecha_entrada_his" required onblur="validarFechaEntradaHis()">
                    <p id="errorfecha_ent_his"></p>
                </div>
                <div class="form-inp">
                    <label for="fecha_salida_his">Fecha de salida</label>
                    <input type="date" name="fecha_salida_his" id="fecha_salida_his" required onblur="validarFechaSalidaHis()">
                    <p id="errorfecha_sal_his"></p>
                </div>
                <div class="form-inp">
                    <label for="ingresado_his">Ingresado</label>
                    <select name="ingresado_his" id="ingresado_his" required onblur="validarIngresadoHis()">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                    <p id="erroringresado_his"></p>
                </div>
                <div class="form-inp">
                    <label for="Veterinario">Veterinario Asignado</label>
                    <select id="Veterinario" name="Veterinario" required>
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