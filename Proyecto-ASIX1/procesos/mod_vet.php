<?php
include "../conexion/conexion.php";
session_start();

// // Verificar si el usuario está autenticado
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

// Obtener datos de la mascota
$sql = "SELECT * FROM veterinario WHERE Id_Vet = $id";
$result = mysqli_query($conn, $sql);
$veterinario = mysqli_fetch_assoc($result);

if (!$veterinario) {
    echo "Veterinario no encontrada.";
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telf = $_POST['telefono'];
    $especialidad = $_POST['especialidad'];
    $fechcontrato = $_POST['fechacontrato'];
    $salario = $_POST['salario'];


    $update_sql = "UPDATE veterinario SET Nombre = '$nombre', Telefono = '$telf', Especialidad = '$especialidad', `Fecha_Contrato` = '$fechcontrato', Salario = '$salario' WHERE Id_Vet = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Datos actualizados correctamente.";
        header("Location:   ../views/veterinarios.php"); // Redirigir a una página de éxito
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
    <link rel="stylesheet" type="text/css" href="../css/modificar.css">
    <title>Formulario de modificación de veterinario</title>
    <link rel="stylesheet" href="../sets/css/styles.css">
</head>

<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar veterinario</h2>
    </div>
    <a href="../views/veterinarios.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label for="Nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($veterinario['Nombre']); ?>">
    <br>
    <label for="Telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($veterinario['Telefono']); ?>">
    <br>
    <label for="Especialidad">Especialidad:</label>
    <input type="text" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($veterinario['Especialidad']); ?>">
    <br>
    <label for="Fecha_Contrato">Fecha de Contrato:</label>
    <input type="date" id="fechacontrato" name="fechacontrato" value="<?php echo htmlspecialchars($veterinario['Fecha_Contrato']); ?>" required>
    <br>
    <label for="Salario">Salario:</label>
    <input type="text" id="salario" name="salario" value="<?php echo htmlspecialchars($veterinario['Salario']); ?>">


    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>




