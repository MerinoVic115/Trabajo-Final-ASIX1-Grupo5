<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "bd_festival";

// Intentar conectar a la base de datos
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificar si hubo un error en la conexión
if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}


?>
