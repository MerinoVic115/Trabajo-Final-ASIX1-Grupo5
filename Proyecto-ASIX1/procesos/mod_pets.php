<!-- Modificación Mascotas - Consultas para inserción en la BBDD -->

<?php
include "../conexion/conexion.php";
// session_start();

// // Verificar si el usuario está autenticado
// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../index.php"); // arreglar sesion(posible error esta en $_SESSION) 
// }

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

    $update_sql = "UPDATE mascota SET Nombre = '$nombre', Sexo = '$sexo', Especie = '$especie', Raza = '$raza' WHERE Chip = $id";
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
    <link rel="stylesheet" type="text/css" href="../css/modificar.css">
    <title>Formulario de modificación de mascota</title>
</head>

<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar mascota</h2>
    </div>
    <a href="../views/mascotas.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $mascota['Nombre']; ?>" required>
    <br>
    
    <label>Sexo:</label>
    <input type="text" name="genero" value="<?php echo $mascota['Sexo']; ?>">
    <br>
    
    <label>Especie:</label>
    <input type="text" name="especie" value="<?php echo $mascota['Especie']; ?>">
    <br>
    
    <label>Raza:</label>
    <input type="text" name="raza" value="<?php echo $mascota['Raza']; ?>">
    <br>
    
    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>