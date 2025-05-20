<?php
include "../conexion/conexion.php";
session_start();

// // Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Verificar si se ha recibido un ID válido
if (!isset($_GET['DNI'])) {
    echo "ID de propietario no válido.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['DNI']);

// Obtener datos del propietario
$sql = "SELECT * FROM propietario WHERE DNI = $id";
$result = mysqli_query($conn, $sql);
$propietario = mysqli_fetch_assoc($result);

if (!$propietario) {
    echo "Propietario no encontrada.";
    exit();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telf = $_POST['telf'];
    $direc = $_POST['direccion'];
    $email = $_POST['email'];


    $update_sql = "UPDATE propietario SET Nombre = '$nombre', Direccion = '$direc', Telefono = '$telf', Email = '$email' WHERE DNI = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "Datos actualizados correctamente.";
        header("Location:   ../views/propietarios.php"); // Redirigir a una página de éxito
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
        <h2>Modificar propietario</h2>
    </div>
    <a href="../views/veterinarios.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label for="Nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($propietario['Nombre']); ?>">
    <br>
    <label for="Telefono">Dirección:</label>
    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($propietario['Direccion']); ?>">
    <br>
    <label for="Fecha_Contrato">Teléfono:</label>
    <input type="text" id="telf" name="telf" value="<?php echo htmlspecialchars($propietario['Telefono']); ?>">
    <br>
    <label for="Salario">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($propietario['Email']); ?>">


    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>




