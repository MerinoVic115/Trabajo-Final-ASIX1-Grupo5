<?php

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/modificar.css">
    <title>Formulario de modificación de veterinario</title>
    <link rel="stylesheet" href="../sets/css/styles.css">
</head>

<body>
<div class="header">
    <div class="logo-title">
        <h2>Modificar veterinario</h2>
    </div>
    <a href="../views/veterinarios.php"><button>Atrás</button></a>
</div>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    
    <button type="submit">Guardar cambios</button>
</form>  
</body>
</html>




