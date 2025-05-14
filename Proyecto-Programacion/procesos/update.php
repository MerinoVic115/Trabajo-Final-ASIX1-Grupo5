<?php
include "../conexion/conexion.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar si el formulario fue enviado correctamente con datos válidos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['nombre'], $_POST['genero'], $_POST['pais'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $pais = $_POST['pais'];
    $genero = $_POST['genero'];
    

// Actualizar nombre,pais,genero del Artista
    $sql = "UPDATE artistas SET nombre = ?, pais = ?, genero = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt_update, "sssi", $nombre, $pais, $genero,  $id);
    $resultado_update = mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);

// Comprobar errores
     if ($resultado_update) {
          echo "<p>Artista actualizado correctamente.</p>";
          header("Location:../index.php");
        } else {
            echo "<p>Error al actualizar el Artista: " . mysqli_error($conn) . "</p>";
        }
        } else {
            echo "<p>ID no proporcionado para eliminar.</p>";
        }
        mysqli_close($conn);
?>
