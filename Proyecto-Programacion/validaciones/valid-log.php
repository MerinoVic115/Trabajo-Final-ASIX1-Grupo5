
       <?php
       session_start();
       include "../conexion/conexion.php";
       
       if (isset($_POST['userlog']) && isset($_POST['passwdlog'])) {
           $usuario = mysqli_real_escape_string($conn, $_POST['userlog']);
           $pass = $_POST['passwdlog'];
       
           // Consultar el usuario
           $sql = "SELECT username, password FROM usuarios WHERE username = '$usuario'";
           $result = mysqli_query($conn, $sql);
       
           if ($row = mysqli_fetch_assoc($result)) {
               $db_pass = $row['password'];
       
               // Verificar la contraseña
               if (password_verify($pass, $db_pass)) {
                   $_SESSION['usuario'] = $usuario;
                   header("location: ../index.php?usuario=" . urlencode($usuario));
                   exit();
               }
           }
       
           // Si el usuario o la contraseña son incorrectos, redirigir al login
           header("location: ../view/login.php");
           exit();
       }
       
       mysqli_close($conn);

       
       ?>
       
   
 
       





























<!-- if (isset($_POST['userlog']) && isset($_POST['passwdlog'])) {
    session_start();

    $usuario = $_POST['userlog'];
    $pass = $_POST['passwdlog'];

    $sql = "SELECT password FROM usuarios WHERE username = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $hash = $row['password'];

        if (password_verify($pass, $hash)) {
            $_SESSION['userlog'] = $usuario;
            header("location: ./index.php");
            exit();
        } else {
            echo "❌ Contraseña incorrecta";
        }
    } else {
        echo "❌ Usuario no encontrado";
    }

    exit();
}

?> -->

