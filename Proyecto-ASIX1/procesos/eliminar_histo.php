<!-- Eliminación de historial  -->

<?php


include "../conexion/conexion.php";

if (isset($_GET['id_historial']) && !empty($_GET['id_historial'])) {
    $id_historial = $_GET['id_historial'];

    // Eliminamos el historial
    $sql_eliminar_histo = "DELETE FROM historial WHERE id_historial = ?";
    $stmt_histo = mysqli_prepare($conn, $sql_eliminar_histo);
    mysqli_stmt_bind_param($stmt_histo, "i", $id_historial);

    $resultado_histo = mysqli_stmt_execute($stmt_histo);
    mysqli_stmt_close($stmt_histo);

    if ($resultado_histo) {
        echo "<p>Historial eliminado correctamente.</p>";
        header("Location: ../views/historial.php");
        exit();
    } else {
        echo "<p>Error al eliminar el historial: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de historial no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>