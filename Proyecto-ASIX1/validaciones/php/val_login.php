<?php
session_start();
include "../../conexion/conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['lnombre']) && isset($_POST['lpwd'])) {
        $errorLnombre = "";
        $errorLpwd = "";
        $lnombre = $_POST['lnombre'];
        $lpwd = $_POST['lpwd'];

        if (strlen($lnombre) < 2) {
            $errorLnombre = "El nombre de usuario debe tener al menos 2 caracteres.";
            header("refresh:3;url=../../views/login.php");
        } elseif (strlen($lnombre) > 30) {
            $errorLnombre = "El nombre de usuario debe contener menos de 30 caracteres.";
            header("refresh:3;url=../../views/login.php");
        }

        if (strlen($lpwd) < 2) {
            $errorLpwd = "La contraseña debe tener al menos 2 caracteres.";
            header("refresh:3;url=../../views/login.php");
        } elseif (!preg_match('/[A-Z]/', $lpwd)) {
            $errorLpwd = "La contraseña debe tener como mínimo una mayúscula.";
            header("refresh:3;url=../../views/login.php");
        }

        if (!empty($errorLnombre) || !empty($errorLpwd)) {
            echo $errorLnombre . "<br>" . $errorLpwd;
        } else {
            $query = "SELECT id_personal, contra_personal FROM personal WHERE nom_personal = '$lnombre'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error al ejecutar SELECT: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $userId = $row['id_personal'];
                $hashedPassword = $row['contra_personal'];

                if (password_verify($lpwd, $hashedPassword)) {
                    session_start();    
                    $_SESSION['username'] = $lnombre; 
                    $_SESSION['user_id'] = $userId;           
                    echo "Inicio de sesión exitoso. Bienvenido, $lnombre";
                    header("Location: ../../views/principal.php");
                    exit();
                } else {
                    echo "Contraseña incorrecta.";
                    header("refresh:3;url=../../views/login.php");
                }
            } else {
                echo "El usuario no existe. Por favor, regístrese para tener acceso.";
                header("refresh:3;url=../../views/registro.php");
            }
        }
    } 
}
mysqli_close($conn);
?>