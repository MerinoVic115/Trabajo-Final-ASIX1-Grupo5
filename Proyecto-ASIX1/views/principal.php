<?php

// Indicamos que requerimos el archivo conexion.php para seguir
include "../conexion/conexion.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sets/css/styles.css">
    <link rel="icon" href="./sets/img/hueso.svg">
    <title>Página Principal Perriatra</title>
</head>

<body>
   
    <nav>
        
    </nav>
    
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
                    <td><?= $mascota['Nombre']; ?></td>

                    <td><?= $mascota['Sexo']; ?></td>

                    <td><?= date('d/m/Y', strtotime($mascota['Fecha_Nacimiento'])); ?></td>

                    <td><?= $mascota['Especie']; ?></td>
                    
                    <td>
                        <a href="./procesos/modificar.php?id=<?= $mascota['Chip']; ?>">Modificar</a>
                        <a href="./procesos/eliminar.php?id=<?= $mascota['Chip']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminarlo?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
    </tbody>
</table>

<a href="../procesos/crear-pets.php"><button>Insertar mascota</button></a>
    
</body>
</html>