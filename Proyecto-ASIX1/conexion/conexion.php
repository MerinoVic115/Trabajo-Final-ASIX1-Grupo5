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


// DELIMITER $$

// CREATE TRIGGER nombre_del_trigger
// [timing] [evento]
// ON nombre_de_la_tabla
// FOR EACH ROW
// BEGIN
//     -- Aquí va el código que quieres que se ejecute
// END$$

// DELIMITER ;
// DELIMITER $$

// CREATE TRIGGER check_salario
// BEFORE INSERT
// ON emp
// FOR EACH ROW
// BEGIN
//     IF NEW.salario < 1000 THEN
//         SIGNAL SQLSTATE '45000'
//         SET MESSAGE_TEXT = 'El salario no puede ser menor a 1000';
//     END IF;
// END$$

// DELIMITER ;
// nombre_del_trigger: el nombre que le des al trigger.

// timing: puede ser BEFORE o AFTER (antes o después del evento).

// evento: puede ser INSERT, UPDATE o DELETE.

// nombre_de_la_tabla: la tabla donde se aplicará el trigger.

// FOR EACH ROW: el trigger se ejecuta para cada fila afectada.

// Dentro del BEGIN...END: colocas el código que se ejecutará.


?>


