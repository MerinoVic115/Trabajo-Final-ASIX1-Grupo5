<!-- Eliminación de animales  -->

<?php

include "../conexion/conexion.php";

if (isset($_GET['Chip']) && !empty($_GET['Chip'])) {
    $chip = $_GET['Chip'];

    // Eliminamos la mascota
    $sql_eliminar_mascota = "DELETE FROM mascota WHERE Chip = ?";
    
    $stmt_mascota = mysqli_prepare($conn, $sql_eliminar_mascota);
    mysqli_stmt_bind_param($stmt_mascota, "s", $chip); // Cambiado a "s" para cadenas

    $resultado_mascota = mysqli_stmt_execute($stmt_mascota);
    mysqli_stmt_close($stmt_mascota);

    if ($resultado_mascota) {
        echo "<p>Mascota eliminada correctamente.</p>";
        header("Location: ../views/principal.php");
        exit(); // Detenemos la ejecución después de redirigir
    } else {
        echo "<p>Error al eliminar la mascota: " . mysqli_error($conn) . "</p>";
    }

} else {
    echo "<p>Chip no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>