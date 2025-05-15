<!-- Modificación Veterinario - Consultas para la inserción en la BBDD -->
<?php
include "../conexion/conexion.php";
// session_start();

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
$sql = "SELECT * FROM veterianario WHERE Id_Vet = $id";
$result = mysqli_query($conn, $sql);
$veterinario = mysqli_fetch_assoc($result);

if (!$veterinario) {
    echo "Veterinario no encontrada.";
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['Nombre'];
    $telf = $_POST['Telefono'];
    $especialidad = $_POST['Especialidad'];
    $fechcontrato = $_POST['Fecha_Contrato'];
    $salario = $_POST['Salario'];


    $update_sql = "UPDATE veterinario SET Nombre = '$nombre', Telefono = '$telf', Especialidad = '$especialidad', `Fecha_Contrato` = '$fechcontrato', Salario = '$salario' WHERE Id_Vet = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Datos actualizados correctamente.";
        header("Location:   ../views/vetirnarios.php"); // Redirigir a una página de éxito
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
}
?>

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
    
    
    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>




