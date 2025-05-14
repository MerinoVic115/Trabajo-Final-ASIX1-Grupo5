<?php
include "./conexion/conexion.php"; 

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ./view/login.php");
    exit();
}

// Inicialización de arrays para filtros
$where = [];
$mensajes_filtro = [];

// Filtro por género
if (!empty($_GET['genero'])) {
    $genero = mysqli_real_escape_string($conn, $_GET['genero']);
    $where[] = "genero = '$genero'";
    $mensajes_filtro[] = "Filtrado por género: $genero";
}

// Filtro por país
if (!empty($_GET['pais'])) {
    $pais = mysqli_real_escape_string($conn, $_GET['pais']);
    $where[] = "pais = '$pais'";
    $mensajes_filtro[] = "Filtrado por país: $pais";
}

// Construcción de la consulta SQL
$sql = "SELECT id, nombre, genero, pais, fecha_registro FROM artistas";

// Añadir WHERE si hay filtros
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY fecha_registro DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festival Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .filter-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .filter-form label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filter-form input {
            margin-right: 15px;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ced4da;
        }
        .filter-form button {
            padding: 5px 15px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .filter-form a {
            margin-left: 15px;
            color: #0d6efd;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg bg-primary text-white p-3">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Festival Manager</a>
            <div class="ms-auto">
            <span class="me-3">Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
            <a href="./logout/logout.php" class="btn btn-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Mostrar mensajes de filtro -->
        <?php if (!empty($mensajes_filtro)): ?>
            <div class="alert alert-info">
                <?php echo implode(" | ", $mensajes_filtro); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de filtrado -->
        <div class="filter-form mb-4">
            <form method="get" action="">
                <label for="genero">Género:</label>
                <input type="text" name="genero" id="genero" placeholder="Ej: Trap"
                       value="<?php echo isset($_GET['genero']) ? htmlspecialchars($_GET['genero']) : ''; ?>">

                <label for="pais">País:</label>
                <input type="text" name="pais" id="pais" placeholder="Ej: España"
                       value="<?php echo isset($_GET['pais']) ? htmlspecialchars($_GET['pais']) : ''; ?>">

                <button type="submit" class="btn btn-primary">Filtrar</button>

                <?php if (!empty($_GET['genero']) || !empty($_GET['pais'])): ?>
                    <a href="index.php" class="btn btn-secondary">Quitar filtros</a>
                <?php endif; ?>
            </form>
        </div>

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
                                    <th>Género</th>
                                    <th>País</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                                            <td><?= htmlspecialchars($row['genero']) ?></td>
                                            <td><?= htmlspecialchars($row['pais']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['fecha_registro'])) ?></td>
                                            <td>
                                                <a href="./eliminar-artista/eliminar.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                                <a href="./view/modificar.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Modificar</a>
                                                <a href="./contacto/contacto.php?id=<?= $row['id'] ?>" class="contacto-boton">Contacto</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron artistas</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulario para agregar nuevo artista -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning">
                        Nuevo Artista
                    </div>
                    <div class="card-body">
                        <form action="./inserts/insert-artista.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nombre del artista</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Género musical</label>
                                <input type="text" name="genero" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">País de origen</label>
                                <input type="text" name="pais" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Artista</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>