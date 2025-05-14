<?php
session_start();
include "../conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar datos
    $nombre = $_POST['user'];
    $correo = $_POST['email'];
    $contra1 = $_POST['passwd'];
    $contra2 = $_POST['passwd2'];
    $error = false;

    // Verificar si el usuario ya existe
    $sql = "SELECT id FROM usuarios WHERE username = ?";
    $sentencia1 = mysqli_prepare($conn, $sql);

    if ($sentencia1) {
        mysqli_stmt_bind_param($sentencia1, "s", $nombre);
        mysqli_stmt_execute($sentencia1);
        mysqli_stmt_store_result($sentencia1);

        if (mysqli_stmt_num_rows($sentencia1) > 0) {
            $error = true;
            $_SESSION['error'] = "El usuario ya existe.";
        }

        mysqli_stmt_close($sentencia1);
    } else {
        $error = true;
    }

    // Verificar si las contraseñas coinciden
    if ($contra1 !== $contra2) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location:../login.php");
        exit();
    }

    // Validar la contraseña
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $contra1)) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres, 1 mayúscula y 1 número.";
        header("Location: ./login.php");
        exit();
    }

    // Si no hay errores, insertar el usuario
    if (!$error) {
        $cifrado = password_hash($contra1, PASSWORD_DEFAULT);
        $query1 = "INSERT INTO usuarios(username, email, password) VALUES (?, ?, ?)";
        $sentencia1 = mysqli_prepare($conn, $query1);

        if ($sentencia1) {
            mysqli_stmt_bind_param($sentencia1, "sss", $nombre, $correo, $cifrado);

            if (!mysqli_stmt_execute($sentencia1)) {
                $error = true;
            }

            mysqli_stmt_close($sentencia1);
        } else {
            $error = true;
        }
    }

    // Redirecciones según resultado
    if ($error) {
        header("Location: ../view/register.php?error=1");
    } else {
        header("Location: ../view/login.php?success=1");
    } 
}




mysqli_close($conn);
?>

?>