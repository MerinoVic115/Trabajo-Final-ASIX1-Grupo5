<!-- Eliminación de veterinarios  -->

<?php

include "../conexion/conexion.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_GET['Id_Vet']) && !empty($_GET['Id_Vet'])) {
    $idvet = $_GET['Id_Vet'];

    // Eliminamos la mascota
    $sql_eliminar_vet = "DELETE FROM veterinario WHERE Id_Vet = ?";
    
    $stmt_vet = mysqli_prepare($conn, $sql_eliminar_vet);
    mysqli_stmt_bind_param($stmt_vet, "s", $idvet); // Cambiado a "s" para cadenas

    $resultado_vet = mysqli_stmt_execute($stmt_vet);
    mysqli_stmt_close($stmt_vet);

    if ($resultado_vet) {
        echo "<p>Veterinario eliminado correctamente.</p>";
        header("Location:../views/veterinarios.php"); // Redirigir a la página de mascotas
        exit(); // Detenemos la ejecución después de redirigir
    } else {
        echo "<p>Error al eliminar el veterinario: " . mysqli_error($conn) . "</p>";
    }

} else {
    echo "<p>ID no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>