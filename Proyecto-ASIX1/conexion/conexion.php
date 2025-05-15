<?php

// Indicamos que requerimos el archivo config.php para poder continuar
include "config.php";

// Creamos una variable con la conexión a la BBDD y sus respectivas variables
$conn = mysqli_connect($servername, $username, $password, $dbname);


// Hacemos un condicional de si NO existe la variable creada anteriormente
if (!$conn) {

    // Mostramos por pantalla un mensaje de error y cerramos la conexión
    echo "<script> alert('Error de conexión con la base de datos'); </script>";
    die("Connection failed: " . mysqli_connect_error());

}

?>