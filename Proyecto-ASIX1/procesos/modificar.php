<?php

include "../conexion/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chip = $_POST['Chip'];
    $nombre = trim($_POST['Nombre']);
    $sexo = $_POST['Sexo'];
    $fecha_nacimiento = $_POST['Fecha_Nacimiento'];
    $especie = trim($_POST['Especie']);
    $raza = trim($_POST['Raza']);
    $propietario = trim($_POST['Propietario']);
    $veterinario = $_POST['Veterinario'];
    $

    if (!isset($chip) || !isset($nombre) || !isset($sexo) || !isset($fecha_nacimiento)  || !isset($especie) || !isset($raza) || !isset($propietario) || !isset($veterinario)) {
        die("Todos los campos son obligatorios")
    } 

    $sql = "UPDATE mascota SET Chip = ?, Nombre = ?, Sexo = ?, Fecha_Nacimiento = ?, Especie = ?, Raza = ?, Propietario = ?, Veterinario = ? WHERE Chip = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssssi", $chip, $nombre, $sexo, $fecha_nacimiento, $especie, $raza, $propietario, $veterinario, $);

    if (mysqli_stmt_execute($stmt)) {
       header("Location:../views/principal.php");
        exit();
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Método de solicitud no válido.";
}
?>
