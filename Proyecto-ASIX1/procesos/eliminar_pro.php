<!-- Eliminación de veterinarios  -->

<?php

include "../conexion/conexion.php";

// if (!isset($_SESSION['username'])) {
//     header("Location: ../views/login.php");
//     exit();
// }

if (isset($_GET['DNI']) && !empty($_GET['DNI'])) {
    $idpro = $_GET['DNI'];

    // Eliminamos la mascota
    $sql_eliminar_pro = "DELETE FROM propietario WHERE DNI = ?";
    
    $stmt_pro = mysqli_prepare($conn, $sql_eliminar_pro);
    mysqli_stmt_bind_param($stmt_pro, "s", $idpro); // Cambiado a "s" para cadenas

    $resultado_pro = mysqli_stmt_execute($stmt_pro);
    mysqli_stmt_close($stmt_pro);

    if ($resultado_pro) {
        echo "<p>Propietario eliminado correctamente.</p>";
        header("Location:../views/propietarios.php"); // Redirigir a la página de propietarios
        exit(); // Detenemos la ejecución después de redirigir
    } else {
        echo "<p>Error al eliminar el propietario: " . mysqli_error($conn) . "</p>";
    }

} else {
    echo "<p>DNI no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>