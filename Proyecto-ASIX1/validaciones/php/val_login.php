
<?php

include "../../conexion/conexion.php";

session_start();

if (isset($_POST['submit']) && $_POST['l_nombre'] != null && $_POST['l_pwd'] != null) {

    $lusuario = $_POST['l_nombre'];
    $lpwd = $_POST['l_pwd'];

    $val = "SELECT nom_personal, contra_personal FROM personal_vet WHERE nom_personal = '$lusuario'";
    $result = mysqli_query($conn, $val);

    if (mysqli_num_rows($result) > 0) {

        $pwduser = mysqli_fetch_assoc($result);
        $pwdhash = $pwduser['contra_personal'];

        if (password_verify($lpwd, $pwdhash)) {
            
            $_SESSION['lusuario'] = $lusuario;
            header("Location:../../views/principal.php");
            exit();
       
        } else {

            header("Location:../../views/login.html?=ErrorContraseñas");
            exit();
        
        }

    } else {
    
        header("Location:../../views/registro.php");
        exit();
        
    }

} else {
    
    header('Location:../../views/login.html?=ErrorTotal');
    exit();

}

mysqli_close($conn);

?>