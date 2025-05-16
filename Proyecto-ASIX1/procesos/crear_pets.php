<?php
include "../conexion/conexion.php";

$error = false;

if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $fechanaci = $_POST['fecha'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $propietario = $_POST['propietario'];
    $veterinario = $_POST['veterinario'];

    // Consulta para insertar los datos
    $query1 = "INSERT INTO mascota (Nombre, Sexo, Fecha_Nacimiento, Especie, Raza, Propietario, Veterinario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $sentencia1 = mysqli_prepare($conn, $query1);

    if ($sentencia1) {
        mysqli_stmt_bind_param($sentencia1, "sssssss", $nombre, $sexo, $fechanaci, $especie, $raza, $propietario, $veterinario);

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
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <title>Formulario de creación de mascota</title>
</head>
<body>
<div class="header">
    <div class="logo-title">
        <h2>Crear mascota</h2>
    </div>
    <a href="../views/mascotas.php"><button type="button">Atrás</button></a>
</div>

<form action="" method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre" placeholder="Introduce el nombre de la mascota" required>
    <p id="errorNombreMascota" style="color: red;"></p>
    <br>
    
    <label>Sexo:</label>
    <input type="text" name="sexo" placeholder="Introduce el sexo de la mascota" required>
    <p id="errorSexoMascota" style="color: red;"></p>
    <br>

    <label>Fecha Nacimiento:</label>
    <input type="date" name="fecha" placeholder="Introduce la fecha de nacimiento de la mascota" required>
    <p id="errorFechaMascota" style="color: red;"></p>
    <br>

    <label>Especie:</label>
    <input type="text" name="especie" placeholder="Introduce la especie de la mascota">
    <p id="errorEspecieMascota" style="color: red;"></p>
    <br>

    <label>Raza:</label>
    <select id="raza" name="raza">
        <option value="">Seleccionar raza: </option>
        <?php
        $sql = "SELECT DISTINCT nombre FROM raza";
        $result = mysqli_query($conn, $sql);
        $listarazas = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($listarazas as $lr) {
            echo "<option value='{$lr['nombre']}'>{$lr['nombre']}</option>";
        }
        ?>
    </select>
    <p id="errorRazaMascota" style="color: red;"></p>
    <br>

    <label>Propietario:</label>
    <select id="propietario" name="propietario">
        <option value="">Seleccionar propietario: </option>
        <?php
        $sql = "SELECT DISTINCT nombre FROM propietario";
        $result = mysqli_query($conn, $sql);
        $listaprop = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($listaprop as $lp) {
            echo "<option value='{$lp['nombre']}'>{$lp['nombre']}</option>";
        }
        ?>
    </select>
    <p id="errorPropietarioMascota" style="color: red;"></p>
    <br>

    <label>Veterinario:</label>
    <select id="veterinario" name="veterinario">
        <option value="">Seleccionar veterinario: </option>
        <?php
        $sql = "SELECT DISTINCT nombre FROM veterinario";
        $result = mysqli_query($conn, $sql);
        $listavet = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($listavet as $lv) {
            echo "<option value='{$lv['nombre']}'>{$lv['nombre']}</option>";
        }
        ?>
    </select>
    <p id="errorVeterinarioMascota" style="color: red;"></p>
    <br>

    <button type="submit">Guardar cambios</button>
</form>  
<?php mysqli_close($conn); ?>
</body>
</html>