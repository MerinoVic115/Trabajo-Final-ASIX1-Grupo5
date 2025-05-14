<?php
include "../conexion/conexion.php";
// session_start();

// Verificar si el usuario está autenticado
// if (!isset($_SESSION['usuario'])) {
//     header("Location: ../index.php");
// }

// Verificar si se ha recibido un ID válido
if (!isset($_GET['id'])) {
    echo "ID de artista no válido.";
    exit();
}

$id = $_GET['id'];

// Obtener datos del Artista
$sql = "SELECT * FROM mascota WHERE id = $id";
$result = mysqli_query($conn, $sql);
$artista = mysqli_fetch_assoc($result);

if (!$artista) {
    echo "artista no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/modificar.css">
    <title>Modificar Artista</title>
</head>
<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar artista</h2>
    </div>
    <a href="../view/vista.php"><button>Atrás</button></a>
</div>

    <form action="../procesos/update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $artista['nombre']; ?>" required>
        <br>
        
        <label>Genero musical:</label>
        <input type="text" name="genero" value="<?php echo $artista['genero']; ?>">
        <br>

        <label>Pais:</label>
        <input type="text" name="pais" value="<?php echo $artista['pais']; ?>">
        <br>
        
        <button type="submit">Guardar cambios</button>
    </form>  
</body>
</html>



