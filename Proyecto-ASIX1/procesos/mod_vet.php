<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['Id_Vet'])) {
    echo "ID de veterinario no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['Id_Vet']);

// Obtener datos del veterinario
$sql = "SELECT * FROM veterinario WHERE Id_Vet = $id";
$result = mysqli_query($conn, $sql);
$veterinario = mysqli_fetch_assoc($result);

if (!$veterinario) {
    echo "Veterinario no encontrado.";
    exit();
}

// Obtener especialidades para el select
$especialidades = [];
$resEspe = mysqli_query($conn, "SELECT id_especialidad, Nombre_e FROM especialidad");
while ($row = mysqli_fetch_assoc($resEspe)) {
    $especialidades[] = $row;
}

// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telf = $_POST['telefono'];
    $especialidad = $_POST['especialidad'];
    $fechcontrato = $_POST['mod_vet_fecha_contrato'];
    $salario = $_POST['mod_vet_salario'];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Teléfono
    if (!$telf) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    } elseif (!preg_match('/^\d{9}$/', $telf)) {
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
    if (!$fechcontrato) {
        $errores['fechacontrato'] = "La fecha de contrato es obligatoria.";
    } else {
        $fechaIngresada = strtotime($fechcontrato);
        if (!$fechaIngresada) {
            $errores['fechacontrato'] = "La fecha ingresada no es válida.";
        } elseif ($fechaIngresada > strtotime(date('Y-m-d'))) {
            $errores['fechacontrato'] = "La fecha de contrato no puede ser futura.";
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

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $nombre = mysqli_real_escape_string($conn, $nombre);
        $telf = mysqli_real_escape_string($conn, $telf);
        $especialidad = mysqli_real_escape_string($conn, $especialidad);
        $fechcontrato = mysqli_real_escape_string($conn, $fechcontrato);
        $salario = mysqli_real_escape_string($conn, $salario);

        $update_sql = "UPDATE veterinario SET Nombre = ?, Telefono = ?, Especialidad = ?, `Fecha_Contrato` = ?, Salario = ? WHERE Id_Vet = ?";

        $stmt = mysqli_prepare($conn, $update_sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssssdi', $nombre, $telf, $especialidad, $fechcontrato, $salario, $id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Veterinario actualizado correctamente.')</script>";
                header("Location: ../views/veterinarios.php");
                exit();
            } else {
                echo "Error al actualizar el veterinario: " . mysqli_stmt_error($stmt);
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
    <title>Formulario de modificación de veterinario</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
        <script src="../validaciones/js/validacion.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body id="body_crud" class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Veterinario</div>
                <div id="welcome-line-2">Actualiza los datos del veterinario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="mod_vet_nombre" name="nombre" value="<?php echo htmlspecialchars(isset($_POST['nombre']) ? $_POST['nombre'] : $veterinario['Nombre']); ?>" required required onblur="validarNombreVetMod()">
                    <p id="errorModNombreVet"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <br>
                <div class="form-inp">
                    <label for="Telefono">Teléfono:</label>
                    <input type="text" id="mod_vet_telefono" name="telefono" value="<?php echo htmlspecialchars(isset($_POST['telefono']) ? $_POST['telefono'] : $veterinario['Telefono']); ?>" required onblur="validarTelefonoVetMod()">
                    <p id="errorModTelefonoVet"><?php echo isset($errores['telefono']) ? $errores['telefono'] : ''; ?></p>
                </div>
                <br>
                <div class="form-inp">
                    <label for="Especialidad">Especialidad:</label>
                    <select id="mod_vet_especialidad" name="especialidad" required onblur="validarEspecialidadVetMod()">
                        <option value="">Seleccionar especialidad</option>
                        <?php foreach ($especialidades as $esp): 
                            $selected = (isset($_POST['especialidad']) ? $_POST['especialidad'] : $veterinario['Especialidad']) == $esp['Nombre_e'] ? 'selected' : '';
                        ?>
                            <option value="<?php echo htmlspecialchars($esp['Nombre_e']); ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($esp['Nombre_e']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="errorModEspecialidadVet"><?php echo isset($errores['especialidad']) ? $errores['especialidad'] : ''; ?></p>
                </div>
                <br>
                <div class="form-inp">
                    <label for="Fecha_Contrato">Fecha de Contrato:</label>
                    <input type="date" id="mod_vet_fecha_contrato" name="mod_vet_fecha_contrato" value="<?php echo htmlspecialchars(isset($_POST['mod_vet_fecha_contrato']) ? $_POST['mod_vet_fecha_contrato'] : $veterinario['Fecha_Contrato']); ?>" required onblur="validarFechaContratoVetMod()">
                    <p id="errorModFechaContratoVet"><?php echo isset($errores['fechacontrato']) ? $errores['fechacontrato'] : ''; ?></p>
                </div>
                <br>
                <div class="form-inp">
                    <label for="Salario">Salario:</label>
                    <input type="text" id="mod_vet_salario" name="mod_vet_salario" value="<?php echo htmlspecialchars(isset($_POST['mod_vet_salario']) ? $_POST['mod_vet_salario'] : $veterinario['Salario']); ?>" required onblur="validarSalarioVetMod()">
                    <p id="errorModSalarioVet"><?php echo isset($errores['salario']) ? $errores['salario'] : ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/veterinarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>  
</div>
</body>
</html>




