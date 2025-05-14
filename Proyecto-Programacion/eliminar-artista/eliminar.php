<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminacion</title>
</head>
<body>
<?php
 include "../conexion/conexion.php";
 $id = $_GET['id'];

 if ($id != null) {
    $sql = "DELETE FROM `bd_festival`.`artistas` WHERE `id` = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $id);
        $aceptado = mysqli_stmt_execute($stmt);

        if($aceptado){
            echo "Se ha eliminado de forma correctamemte<br>";
            echo "<a href='../index.php'>Volver al inicio</a>"; 
        }else{
            echo "No se ha podido borrrar";
        }
    }
 }
 
?>
</body>
</html>










