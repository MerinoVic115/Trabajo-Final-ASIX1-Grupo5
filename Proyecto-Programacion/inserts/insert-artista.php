<?php
include "../conexion/conexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre'], $_POST['genero'], $_POST['pais'])) {
        $nombre = trim($_POST['nombre']);
        $genero = trim($_POST['genero']);
        $pais = trim($_POST['pais']);
        $fecha = date('Y-m-d');

        $sql_insert = "INSERT INTO artistas (nombre, genero, pais, fecha_registro) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $nombre, $genero, $pais, $fecha);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    
}
header("Location: ../index.php");



?>