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
$query = "SELECT Id_Vet, Nombre, Telefono, Especialidad, Fecha_Contrato, Salario FROM veterinario";
$result = mysqli_query($conn, $query);

// Almacenamos los resultados
$veterinario = [];
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
    <title>Veterinarios - Vetis</title>
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
            Bienvenido, <?php echo $_SESSION['user_name'] ?? 'Usuario'; ?>
            <a href="../procesos/logout.php" style="float: right;">Cerrar sesión</a>
        </div>
    </nav>
    
    <h1>Listado de Veterinarios</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Especialidad</th>
                <th>Fecha de contrato</th>
                <th>Salario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($veterinario)): ?>
                <?php foreach ($veterinario as $veterinario): ?>
                    <tr>
                        <td><?= $veterinario['Nombre']; ?></td>
                        <td><?= $veterinario['Telefono']; ?></td>
                        <td><?= $veterinario['Especialidad']; ?></td>
                        <td><?= date('d/m/Y', strtotime($veterinario['Fecha_Contrato'])); ?></td>
                        <td><?= $veterinario['Salario']; ?></td>
                        <td class="actions">
                            <a href="../procesos/mod_vet.php?Id_Vet=<?= $veterinario['Id_Vet']; ?>">Modificar</a>
                            <a href="../procesos/eliminar_vet.php?Id_Vet=<?= $veterinario['Id_Vet']; ?>" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar a este veterinario?');">
                               Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay veterinarios registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="../procesos/crear_vet.php">
            <button type="button">Registrar un veterinario</button>
        </a>
    </div>
    
</body>
</html>
<?php
// Cerramos la conexión al final del archivo
if (isset($conn)) {
    mysqli_close($conn);
}