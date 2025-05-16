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

// Consulta para obtener cada historial junto con el nombre de la mascota asociada
// $query = "SELECT h.id_historial, h.observacion_his, h.`fecha-entrada_his`, h.`fecha-salida_his`, h.ingresado_his,
//           m.Nombre AS nombre_mascota
//           FROM historial h
//           LEFT JOIN mascota m ON h.Mascota_Chip = m.Chip";


$query = "SELECT h.id_historial, h.observacion_his, h.`fecha-entrada_his`, h.`fecha-salida_his`, h.ingresado_his,
    m.Nombre AS nombre_mascota,
    v.Nombre AS nombre_veterinario
    FROM historial h
    LEFT JOIN mascota m ON h.fk_mascota = m.Chip
    LEFT JOIN veterinario v ON m.veterinario = v.Id_Vet";

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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #2196F3;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <div style="padding: 10px; background: #f1f1f1;">
            Bienvenido, <?php echo $_SESSION['username'] ?? 'Usuario'; ?>
            <a href="logout.php" style="float: right;">Cerrar sesión</a>
        </div>
    </nav>
    
    <h1>Listado de Historial</h1>
    
    <table>
        <thead>
            <tr>
                <th>Mascota</th>
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
                        <td><?= htmlspecialchars($histo['observacion_his']); ?></td>
                        <td><?= htmlspecialchars($histo['nombre_veterinario'] ?? ''); ?></td>
                        <td><?= date('d/m/Y', strtotime($histo['fecha-entrada_his'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($histo['fecha-salida_his'])); ?></td>
                        <td><?= htmlspecialchars($histo['ingresado_his']); ?></td>
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
                    <td colspan="6" style="text-align: center;">No hay historiales registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="../procesos/crear_histo.php">
            <button type="button">Registrar un historial</button>
        </a>
        <a href="principal.php">
            <button type="button">Volver a la pagina principal</button>
        </a>
    </div>
    
</body>
</html>
<?php
// Cerramos la conexión al final del archivo
if (isset($conn)) {
    mysqli_close($conn);
}