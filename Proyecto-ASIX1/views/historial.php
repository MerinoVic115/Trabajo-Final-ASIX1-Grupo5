<?php
// Iniciamos sesión primero (debe ser lo primero en el archivo)
session_start();

// Verificamos si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

// Incluimos la conexión después de verificar la sesión
include "../conexion/conexion.php";

// Consulta para obtener los veterinarios
$query = "SELECT id_historial, observacion_his, fecha-entrada_his, fecha-salida_his, ingresado_his FROM historial";
$result = mysqli_query($conn, $query);

// Almacenamos los resultados
$historial = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $veterinario[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - Vetis</title>
</head>

    <body>
    <nav>
        <div style="padding: 10px; background: #f1f1f1;">
            Bienvenido, <?php echo $_SESSION['user_name'] ?? 'Usuario'; ?>
            <a href="../procesos/logout.php" style="float: right;">Cerrar sesión</a>
        </div>
    </nav>
    
    <h1>Listado de Historial</h1>
    
    <table>
        <thead>
            <tr>
                <th>Observaciones</th>
                <th>Fecha Entrada</th>
                <th>Fecha Salida</th>
                <th>Ingresado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $histo): ?>
                    <tr>
                        <td><?= $histo['observacion_his']; ?></td>
                        <td><?= date('d/m/Y', strtotime($histo['fecha-entrada_his'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($histo['fecha-salida_his'])); ?></td>
                        <td><?= $histo['ingresado_his']; ?></td>
                        <td class="actions">
                            <a href="../procesos/mod_histo.php?id_historial=<?= $histo['id_historial']; ?>">Modificar</a>
                            <a href="../procesos/eliminar_histo.php?id_historial=<?= $histo['id_historial']; ?>" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este historial?');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay historiales registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="../procesos/crear-histo.php">
            <button type="button">Registrar un historial</button>
        </a>
    </div>
    
</body>
</html>
<?php
// Cerramos la conexión al final del archivo
if (isset($conn)) {
    mysqli_close($conn);
}