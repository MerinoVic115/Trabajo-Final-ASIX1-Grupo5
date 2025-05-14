<?php
include "../conexion/conexion.php"; 

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ./view/login.php");
    exit();
}

// Construcción de la consulta SQL
$sql = "select a.id,a.nombre, ca.telefono, ca.email, ca.observaciones
        from artistas a
        inner join contactos_artistas ca on a.id = ca.id;";


// $sql .= " ORDER BY fecha_registro DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de contactos</title>
</head>
<body>
<div class="row">
            <!-- Tabla de artistas confirmados -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Artistas Confirmados
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Artista</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                                            <td><?= htmlspecialchars($row['correo']) ?></td>
                                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                                            <td><?= htmlspecialchars($row['observaciones']) ?></td>
                                            <td>
                                            <a href="./contacto/contact.php?id=<?= $row['id'] ?>" class="contacto-boton">CrearContacto</a>
                                                <a href="./form-contact.php?id=<?= $row['id'] ?>" class="contacto-boton">Contacto</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron artistas</td>
                                       <a href="./form-contact.php">Formulario de contacto</a>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</body>
</html>