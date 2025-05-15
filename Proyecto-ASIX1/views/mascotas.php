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
    <link rel="stylesheet" href="sets/css/styles.css">
    <link rel="icon" href="./sets/img/hueso.svg">
    <title>Mascotas - Vetis</title>
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
            Bienvenido, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
            <a href="../procesos/logout.php" style="float: right;">Cerrar sesión</a>
        </div>
    </nav>
    
    <h1>Listado de Mascotas</h1>
    
    <table>
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
                            <a href="../procesos/mod_pets.php?Chip=<?= $mascota['Chip']; ?>">Modificar</a>
                            <a href="../procesos/eliminar_pets.php?Chip=<?= $mascota['Chip']; ?>" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar esta mascota?');">
                               Eliminar
                            </a>
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

    <div style="margin-top: 20px;">
        <a href="../procesos/crear-pets.php">
            <button type="button">Registrar una mascota</button>
        </a>
    </div>
    
</body>
</html>
<?php
// Cerramos la conexión al final del archivo
if (isset($conn)) {
    mysqli_close($conn);
}
?>