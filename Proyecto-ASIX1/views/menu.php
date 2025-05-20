<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
</head>
<body>
    

<nav class="sidebar">
    <div class="sidebar-header">
        <h3>Vetis Andalucía</h3>
    </div>
    <ul class="sidebar-menu">
        <li class="<?php echo ($current_page == 'mascotas.php') ? 'active' : ''; ?>">
            <a href="mascotas.php">
                <i class="fas fa-paw"></i>
                <span>Mascotas</span>
            </a>
        </li>
        <li class="<?php echo ($current_page == 'veterinarios.php') ? 'active' : ''; ?>">
            <a href="veterinarios.php">
                <i class="fas fa-user-md"></i>
                <span>Veterinarios</span>
            </a>
        </li>
        <li class="<?php echo ($current_page == 'historial.php') ? 'active' : ''; ?>">
            <a href="historial.php">
                <i class="fas fa-clipboard-list"></i>
                <span>Historial</span>
            </a>
        </li>
        <li class="<?php echo ($current_page == 'noticias.php') ? 'active' : ''; ?>">
            <a href="noticias.php">
                <i class="fas fa-newspaper"></i>
                <span>Noticias</span>
            </a>
        </li>
        <li class="<?php echo ($current_page == 'contacto.php') ? 'active' : ''; ?>">
            <a href="contacto.php">
                <i class="fas fa-envelope"></i>
                <span>Contacto</span>
            </a>
        </li>
    </ul>
</nav>
</body>
</html>