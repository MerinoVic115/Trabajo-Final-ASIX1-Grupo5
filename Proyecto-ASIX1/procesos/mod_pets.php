<!-- Modificación Mascotas - Consultas para inserción en la BBDD -->
 
<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['Chip'])) {
    echo "ID de mascota no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['Chip']);

// Obtener datos de la mascota
$sql = "SELECT * FROM mascota WHERE Chip = $id";
$result = mysqli_query($conn, $sql);
$mascota = mysqli_fetch_assoc($result);

if (!$mascota) {
    echo "Mascota no encontrada.";
    exit();
}

// Obtener razas para el select
$razas = [];
$resRaza = mysqli_query($conn, "SELECT Id_Raza, Nombre FROM raza");
while ($row = mysqli_fetch_assoc($resRaza)) {
    $razas[] = $row;
}



// Validaciones PHP
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $sexo = $_POST['genero'];
    $raza = $_POST['raza'];

    // Validación PHP para Nombre
    if (!$nombre || strlen($nombre) < 2) {
        $errores['nombre'] = "El nombre es obligatorio y debe tener al menos 2 caracteres.";
    } elseif (preg_match('/\d/', $nombre)) {
        $errores['nombre'] = "El nombre no puede contener números.";
    }

    // Validación PHP para Sexo
    if (!$sexo) {
        $errores['sexo'] = "El sexo es obligatorio.";
    } elseif ($sexo !== "M" && $sexo !== "F") {
        $errores['sexo'] = "El sexo debe ser 'M' para Macho o 'F' para Hembra.";
    }

    // Validación PHP para Raza
    if (!$raza) {
        $errores['raza'] = "La raza es obligatoria.";
    }

    // Solo actualizar si no hay errores
    if (empty($errores)) {
        $nombre = mysqli_real_escape_string($conn, $nombre);
        $sexo = mysqli_real_escape_string($conn, $sexo);
        $raza = mysqli_real_escape_string($conn, $raza);

        $update_sql = "UPDATE mascota SET Nombre = '$nombre', Sexo = '$sexo', Raza = '$raza' WHERE Chip = $id";
        if (mysqli_query($conn, $update_sql)) {
            // No imprimir nada antes del header
            header("Location: ../views/mascotas.php");
            exit();
        } else {
            echo "Error al actualizar los datos: " . mysqli_error($conn);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de modificación de mascota</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="../validaciones/js/validacion.js"></script>
</head>
<body id="body_crud" class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Editar Mascota</div>
                <div id="welcome-line-2">Actualiza los datos de tu mascota</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>Nombre</label>
                    <input type="text" name="nombre" id="nombremodpets" value="<?php echo htmlspecialchars($mascota['Nombre']); ?>" required placeholder="Nombre de la mascota"
                        oninput="validarNombreMascotaMod()" onblur="validarNombreMascotaMod()">
                    <p id="errorNombreMascotaMod"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Sexo</label>
                    <input type="text" name="genero" id="sexomodpets" value="<?php echo htmlspecialchars($mascota['Sexo']); ?>" placeholder="Sexo de la mascota"
                        oninput="validarSexoMascotaMod()" onblur="validarSexoMascotaMod()">
                    <p id="errorSexoMascotaMod"><?php echo isset($errores['sexo']) ? $errores['sexo'] : ''; ?></p>
                </div>
                <div class="form-inp">
                    <label>Raza</label>
                    <select name="raza" id="razamodpets" required
                        oninput="validarRazaMascotaMod()" onblur="validarRazaMascotaMod()">
                        <option value="">Seleccionar raza</option>
                        <?php foreach ($razas as $r): 
                            $selected = ($mascota['Raza'] == $r['Id_Raza']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $r['Id_Raza']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($r['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="errorRazaMascotaMod"><?php echo isset($errores['raza']) ? $errores['raza'] : ''; ?></p>
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/mascotas.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>