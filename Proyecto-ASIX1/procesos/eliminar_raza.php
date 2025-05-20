<!-- Eliminación de razas  -->

<?php

include "../conexion/conexion.php";

if (isset($_GET['Id_Raza']) && !empty($_GET['Id_Raza'])) {
    $Id_Raza = $_GET['Id_Raza'];

    // Eliminamos la raza
    $sql_eliminar_raza = "DELETE FROM raza WHERE `Id_Raza` = ?";
    
    $stmt_raza = mysqli_prepare($conn, $sql_eliminar_raza);
    mysqli_stmt_bind_param($stmt_raza, "s", $Id_Raza); // Cambiado a "s" para cadenas

    $resultado_raza = mysqli_stmt_execute($stmt_raza);
    mysqli_stmt_close($stmt_raza);

    if ($resultado_raza) {
        echo "<p>Raza eliminada correctamente.</p>";
        header("Location: ../views/raza.php"); // Redirigir a la página de raza
        exit(); // Detenemos la ejecución después de redirigir
    } else {
        echo "<p>Error al eliminar la raza: " . mysqli_error($conn) . "</p>";
    }

} else {
    echo "<p>ID de la raza no encontrada o no válida para eliminar.</p>";
}

mysqli_close($conn);
?>