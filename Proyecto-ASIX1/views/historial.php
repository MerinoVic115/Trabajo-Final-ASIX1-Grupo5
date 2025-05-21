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

// Consulta para obtener cada historial junto con el nombre de la mascota, raza y veterinario asignado
$query = "SELECT 
    h.id_historial,
    h.observacion_his,
    h.`fecha-entrada_his`,
    h.`fecha-salida_his`,
    h.ingresado_his,
    m.Nombre AS nombre_mascota,
    r.Nombre AS nombre_raza,
    v.Nombre AS nombre_veterinario
FROM historial h
INNER JOIN mascota m ON h.mascota = m.Chip
INNER JOIN raza r ON m.Raza = r.Id_Raza
INNER JOIN veterinario v ON h.veterinario = v.Id_Vet;
";

$result = mysqli_query($conn, $query);

// Almacenamos los resultados
$historial = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $historial[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - Vetis</title>
    <link rel="stylesheet" href="../sets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="body_views">
    <div class="layout-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
                    <li><a href="mascotas.php">Mascotas</a></li>
                    <li><a href="veterinarios.php">Veterinarios</a></li>
                    <li style="background-color: #13512d; border-radius: 15px"><a href="historial.php">Historial</a></li>
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
                        Bienvenido, <?php echo $_SESSION['username'] ?? 'Usuario'; ?>
                        <a href="logout.php" style="float: right;">Cerrar sesión</a>
                    </div>
                </nav>

                    <br>
                
                <h1>Listado de Historial</h1>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mascota</th>
                            <th>Raza</th>
                            <th>Observaciones</th>
                            <th>Veterinario asignado</th>
                            <th>Fecha Entrada</th>
                            <th>Fecha Salida</th>
                            <th>Ingresado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $histo): ?>
                                <tr>
                                    <td><?= htmlspecialchars($histo['nombre_mascota'] ?? ''); ?></td>
                                    <td><?= htmlspecialchars($histo['nombre_raza'] ?? ''); ?></td>
                                    <td><?= htmlspecialchars($histo['observacion_his']); ?></td>
                                    <td><?= htmlspecialchars($histo['nombre_veterinario'] ?? ''); ?></td>
                                    <td><?= !empty($histo['fecha-entrada_his']) ? date('d/m/Y', strtotime($histo['fecha-entrada_his'])) : ''; ?></td>
                                    <td><?= !empty($histo['fecha-salida_his']) ? date('d/m/Y', strtotime($histo['fecha-salida_his'])) : ''; ?></td>
                                    <td><?= htmlspecialchars($histo['ingresado_his']); ?></td>
                                    <td class="actions">
                                        <a href="../procesos/mod_histo.php?id_historial=<?= $histo['id_historial']; ?>" class="btn-action btn-edit" >
                                            <i class="fa-solid fa-pen-to-square" ></i></a>
                                        <a href="../procesos/eliminar_histo.php?id_historial=<?= $histo['id_historial']; ?>" class="btn-action btn-delete" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar a este historial?');">
                                            <i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">No hay historiales registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="register-box">
                <a href="../procesos/crear_histo.php">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Crear registro
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