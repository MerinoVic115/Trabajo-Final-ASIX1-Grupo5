<?php
include "../conexion/conexion.php";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$error = false;
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $telf = $_POST['telefono'];
    $email = $_POST['email'];

    // Consulta para insertar los datos
    $query1 = "INSERT INTO propietario (DNI, Nombre, Direccion, Telefono, Email) VALUES (?, ?, ?, ?, ?)";
    $sentencia1 = mysqli_prepare($conn, $query1);

    if ($sentencia1) {
        mysqli_stmt_bind_param($sentencia1, "sssss", $dni, $nombre, $direccion, $telf, $email);

        if (!mysqli_stmt_execute($sentencia1)) {
            $error = true;
        }
        mysqli_stmt_close($sentencia1);
    } else {
        $error = true;
    }

    if ($error) {
        header("Location: ../views/principal.php?error=2");
    } else {
        header("Location: ../views/mascotas.php?success=1");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de creación de propietario</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
</head>
<body class="body_forms">
<div id="form-ui">
    <form action="" method="post" id="form">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div id="form-body">
            <div id="welcome-lines">
                <div id="welcome-line-1">Crear Propietario</div>
                <div id="welcome-line-2">Rellena los datos de la propietario</div>
            </div>
            <div id="input-area">
                <div class="form-inp">
                    <label>DNI</label>
                    <input type="text" name="dni" placeholder="Introduce eld DNI del propietario" required>
                </div>

                <div class="form-inp">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" placeholder="Introduce el nombre de la propietario" required>
                    
                </div>

                <div class="form-inp">
                    <label>Direccion:</label>
                    <input type="text" name="direccion" placeholder="Introduce la direccion del propietario" required>
                    
                </div>

                <div class="form-inp">
                    <label>Teléfono:</label>
                    <input type="text" name="telefono" placeholder="Introduce el telefono del propietario" required>
                    
                </div>

                <div class="form-inp">
                    <label>Email:</label>
                    <input type="text" name="email" placeholder="Introduce el email del propietario" required>
                    
                </div>
            </div>
            <div id="submit-button-cvr">
                <button id="submit-button" type="submit">Guardar cambios</button>
                <a href="../views/propietarios.php"><button type="button" class="btn-back">Atrás</button></a>
            </div>
        </div>
    </form>
</div>
<?php mysqli_close($conn); ?>
</body>
</html>