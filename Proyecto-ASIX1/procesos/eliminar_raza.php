<!-- Eliminación de razas  -->

<?php

include "../conexion/conexion.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}
if (isset($_GET['Id_Raza']) && !empty($_GET['Id_Raza'])) {
    $Id_Raza = $_GET['Id_Raza'];

    // Verificar si existen mascotas asociadas a esta raza
    $sql_check = "SELECT COUNT(*) FROM mascota WHERE Raza = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $Id_Raza);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $count);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($count > 0) {
        // Hay mascotas asociadas, no se puede eliminar
        echo "<script>alert('No se puede eliminar la raza porque existen mascotas asociadas.');window.location.href='../views/raza.php';</script>";
        mysqli_close($conn);
        exit();
    }

    // Si no hay mascotas asociadas, eliminar la raza
    $sql_eliminar_raza = "DELETE FROM raza WHERE `Id_Raza` = ?";
    $stmt_raza = mysqli_prepare($conn, $sql_eliminar_raza);
    mysqli_stmt_bind_param($stmt_raza, "i", $Id_Raza);
    $resultado_raza = mysqli_stmt_execute($stmt_raza);
    mysqli_stmt_close($stmt_raza);

    if ($resultado_raza) {
        header("Location: ../views/raza.php?success=Raza eliminada correctamente");
        exit();
    } else {
        echo "<p>Error al eliminar la raza: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de la raza no encontrada o no válida para eliminar.</p>";
}
mysqli_close($conn);
?>