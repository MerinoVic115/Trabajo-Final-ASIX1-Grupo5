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
if (!isset($_GET['Id_Raza'])) {
    echo "ID de la raza no válida.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['Id_Raza']);

// Obtener datos de la Raza
$sql = "SELECT * FROM raza WHERE Id_Raza = $id";
$result = mysqli_query($conn, $sql);
$raza = mysqli_fetch_assoc($result);

if (!$raza) {
    echo "Raza no encontrada.";
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $altura = mysqli_real_escape_string($conn, $_POST['altura']);
    $peso = mysqli_real_escape_string($conn, $_POST['peso']);
    $caracter = mysqli_real_escape_string($conn, $_POST['caracter']);

    $update_sql = "UPDATE raza SET Nombre = '$nombre', Altura = '$altura', Peso = '$peso', Caracter = '$caracter' WHERE `Id_Raza` = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Datos actualizados correctamente.";
        header("Location:../views/raza.php"); // Redirigir a una página de éxito
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
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <title>Formulario de modificación de la raza</title>
</head>

<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar raza</h2>
    </div>
    <a href="../views/raza.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $raza['Nombre']; ?>" required>
    <br>
    
    <label>Altura:</label>
    <input type="number" name="altura" value="<?php echo $raza['Altura']; ?>">
    <br>
    
    <label>Peso:</label>
    <input type="number" name="peso" value="<?php echo $raza['Peso']; ?>">
    <br>
    
    <label>Caracter:</label>
    <input type="text" name="caracter" value="<?php echo $raza['Caracter']; ?>">
    <br>

    
    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>