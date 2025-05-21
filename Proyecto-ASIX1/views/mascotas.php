<?php
// Iniciamos sesión primero (debe ser lo primero en el archivo)
session_start();

// Verificamos si el usuario está logueado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

// Incluimos la conexión después de verificar la sesión
include "../conexion/conexion.php";

// Consulta para obtener las mascotas
$query = "SELECT Chip, Nombre, Sexo, Fecha_Nacimiento, Especie FROM mascota";
$result = mysqli_query($conn, $query);

// Almacenamos los resultados
$mascotas = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mascotas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sets/css/styles.css">
    <link rel="icon" href="./sets/img/hueso.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Mascotas - Vetis</title>
   
</head>
<body class="body_views">
    <div class="layout-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
                    <li style="background-color: #13512d; border-radius: 15px"><a href="mascotas.php">Mascotas</a></li>
                    <li><a href="veterinarios.php">Veterinarios</a></li>
                    <li><a href="historial.php">Historial</a></li>
                    <li><a href="propietarios.php">Propietarios</a></li>
                    <li><a href="raza.php">Raza</a></li>
                    <li><a href="noticias.php">Noticias</a></li>
                </ul>
            </nav>
        </aside>
        <div class="content-area" style="margin-left: 250px;">
            <main class="main-content">
                <nav>
                    <div style="padding: 10px; background: #f1f1f1;">
                        Bienvenido, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
                        <a href="../views/logout.php" style="float: right;">Cerrar sesión</a>
                    </div>
                </nav>

                    <br>
                
                <h1>Listado de Mascotas</h1>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Especie</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mascotas)): ?>
                            <?php foreach ($mascotas as $mascota): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mascota['Nombre']); ?></td>
                                    <td><?= htmlspecialchars($mascota['Sexo']); ?></td>
                                    <td><?= date('d/m/Y', strtotime($mascota['Fecha_Nacimiento'])); ?></td>
                                    <td><?= htmlspecialchars($mascota['Especie']); ?></td>
                                    <td class="actions">
                                        <a href="../procesos/mod_pets.php?Chip=<?= $mascota['Chip']; ?>" class="btn-action btn-edit">
                                            <i class="fa-solid fa-pen-to-square" ></i></a>
                                        <a href="../procesos/eliminar_pets.php?Chip=<?= $mascota['Chip']; ?>" class="btn-action btn-delete"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?');">
                                            <i class="fa-solid fa-trash-can"></i></a>                                
                                        </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No hay mascotas registradas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <div class="register-box">
                <a href="../procesos/crear_pets.php">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Registrar una mascota
                </a>
            </div>
            </main>
            <footer class="footer">
                <p>© 2023 Vetis Andalucía - Todos los derechos reservados</p>
                <p>Información confidencial - Uso interno exclusivo</p>
            </footer>
        </div>
    </div>
</body>
</html>

<?php
// Cerramos la conexión al final del archivo
if (isset($conn)) {
    mysqli_close($conn);
}
?>