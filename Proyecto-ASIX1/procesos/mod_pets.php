<!-- Modificación Mascotas - Consultas para inserción en la BBDD -->
 
<?php
include "../conexion/conexion.php";
session_start();

// // Verificar si el usuario está autenticado
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

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $sexo = mysqli_real_escape_string($conn, $_POST['genero']);
    $especie = mysqli_real_escape_string($conn, $_POST['especie']);
    $raza = mysqli_real_escape_string($conn, $_POST['raza']);

    // CORREGIDO: Elimina la coma antes de WHERE
    $update_sql = "UPDATE mascota SET Nombre = '$nombre', Sexo = '$sexo', Especie = '$especie' WHERE Chip = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Datos actualizados correctamente.";
        header("Location:   ../views/mascotas.php"); // Redirigir a una página de éxito
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de modificación de mascota</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <!-- Google Fonts: Montserrat -->
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
                    <input type="text" name="nombre" value="<?php echo $mascota['Nombre']; ?>" required placeholder="Nombre de la mascota"
                        oninput="validarNombreMascotaMod()" onblur="validarNombreMascotaMod()">
                    <p id="errorNombreMascota"></p>
                </div>
                
                <div class="form-inp">
                    <label>Sexo</label>
                    <input type="text" name="genero" value="<?php echo $mascota['Sexo']; ?>" placeholder="Sexo de la mascota"
                        oninput="validarSexoMascotaMod()" onblur="validarSexoMascotaMod()">
                    <p id="errorSexoMascota"></p>
                </div>
                
                <div class="form-inp">
                    <label>Raza</label>
                    <select name="veterinario" required>
                        <option value="">Seleccionar raza</option>
                        <?php foreach ($veterinarios as $v): 
                            $selected = (isset($histo['veterinario']) && $histo['veterinario'] == $v['Id_raza']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $v['Id_raza']; ?>" <?php echo $selected; ?>>
                                <?php echo htmlspecialchars($v['Nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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