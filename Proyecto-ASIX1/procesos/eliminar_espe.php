<!-- Eliminación de animales  -->

<?php

include "../conexion/conexion.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}
if (isset($_GET['id_especialidad']) && !empty($_GET['id_especialidad'])) {
    $id_especialidad = $_GET['id_especialidad'];

    // Eliminamos la especialidad
    $sql_eliminar_especialidad = "DELETE FROM especialidad WHERE id_especialidad = ?";
    $stmt = mysqli_prepare($conn, $sql_eliminar_especialidad);
    mysqli_stmt_bind_param($stmt, "i", $id_especialidad);

    $resultado = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($resultado) {
        header("Location: ../views/especialidad.php");
        exit();
    } else {
        echo "<p>Error al eliminar la especialidad: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de especialidad no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>