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
    <title>Formulario de modificación de veterinario</title>
    <link rel="stylesheet" href="../sets/css/styles.css">
</head>

<body id="body_crud">
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
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($veterinario['Nombre']); ?>">
                </div>
                    
                    <br>

                <div class="form-inp">
                    <label for="Telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($veterinario['Telefono']); ?>">
                </div>
                    
                    <br>

                <div class="form-inp">
                    <label for="Especialidad">Especialidad:</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($veterinario['Especialidad']); ?>">
                </div>
                
                    <br>

                <div class="form-inp">
                    <label for="Fecha_Contrato">Fecha de Contrato:</label>
                    <input type="date" id="fechacontrato" name="fechacontrato" value="<?php echo htmlspecialchars($veterinario['Fecha_Contrato']); ?>" required>
                </div>
                
                    <br>
                    
                <div class="form-inp">
                    <label for="Salario">Salario:</label>
                    <input type="text" id="salario" name="salario" value="<?php echo htmlspecialchars($veterinario['Salario']); ?>">
                </div>
        </div>
        
        <div id="submit-button-cvr">
            <button id="submit-button" type="submit">Guardar cambios</button>
            <a href="../views/veterinarios.php"><button type="button" class="btn-back">Atrás</button></a>
        </div>

    </form>  
</div>
</body>
</html>




