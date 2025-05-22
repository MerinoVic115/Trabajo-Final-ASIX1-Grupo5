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

// Obtener especialidades para el filtro
$especialidadesFiltro = [];
$resEspeFiltro = mysqli_query($conn, "SELECT DISTINCT Nombre_e FROM especialidad");
while ($row = mysqli_fetch_assoc($resEspeFiltro)) {
    $especialidadesFiltro[] = $row['Nombre_e'];
}

// Filtro de especialidad
$filtroEspecialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';

// Modificar la consulta para aplicar el filtro si corresponde
$where = '';
if ($filtroEspecialidad !== '' && in_array($filtroEspecialidad, $especialidadesFiltro)) {
    $where = "WHERE v.Especialidad = '" . mysqli_real_escape_string($conn, $filtroEspecialidad) . "'";
}

$query = "SELECT v.Id_Vet, v.Nombre, v.Telefono, v.Especialidad, v.Fecha_Contrato, v.Salario, e.Nombre_e AS nombre_especialidad
          FROM veterinario v
          LEFT JOIN especialidad e ON v.Especialidad = e.Nombre_e
          $where";
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
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="layout-container">
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
                <li><a href="mascotas.php">Mascotas</a></li>
                <li style="background-color: #13512d; border-radius: 15px"><a href="veterinarios.php">Veterinarios</a></li>
                <li><a href="historial.php">Historial</a></li>
                <li><a href="propietarios.php">Propietarios</a></li>
                <li><a href="raza.php">Raza</a></li>
                <li><a href="especialidad.php">Especialidad</a></li>
                <li><a href="noticias.php">Noticias</a></li>
            </ul>
        </nav>
    </aside>
    <div class="content-area" style="margin-left: 250px;">
        <main class="main-content">
            <nav>
                <div style="padding: 10px; background: #f1f1f1; display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex:1; text-align: left;">
                        <strong>Bienvenido</strong>, <?php echo $_SESSION['username'] ?? 'Usuario'; ?>
                    </div>
                    <div style="flex:1; text-align: center;>
                    </div>
                    <div style="flex:1; text-align: right;">
                        <a href="logout.php" class="btn-cerrar-ses">Cerrar sesión</a>
                    </div>
                </div>
            </nav>
            <br>
            <!-- Filtro de especialidad -->
            <form method="get" style="margin-bottom: 20px; display: flex; gap: 20px; align-items: center;">
                <label for="especialidad">Especialidad:</label>
                <select name="especialidad" id="especialidad">
                    <option value="">Todas</option>
                    <?php foreach ($especialidadesFiltro as $esp): ?>
                        <option value="<?= htmlspecialchars($esp) ?>" <?php if ($filtroEspecialidad === $esp) echo 'selected'; ?>>
                            <?= htmlspecialchars($esp) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrar</button>
                <a href="veterinarios.php" style="margin-left:10px;">Quitar filtro</a>
            </form>
            <h1>Listado de Veterinarios</h1>
            <table class="table">
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
                                <td><?= $veterinario['nombre_especialidad'] ?? $veterinario['Especialidad']; ?></td>
                                <td><?= date('d/m/Y', strtotime($veterinario['Fecha_Contrato'])); ?></td>
                                <td><?= $veterinario['Salario']; ?></td>
                                <td class="actions">
                                    <a href="../procesos/mod_vet.php?Id_Vet=<?= $veterinario['Id_Vet']; ?>" class="btn-action btn-edit">
                                        <i class="fa-solid fa-pen-to-square" ></i></a>
                                    <a href="../procesos/eliminar_vet.php?Id_Vet=<?= $veterinario['Id_Vet']; ?>" class="btn-action btn-delete" 
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar a este veterinario?');">
                                       <i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No hay veterinarios registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="register-box">
                <a href="../procesos/crear_vet.php">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Registrar un veterinario
                </a>
            </div>
        </main>
        <footer class="footer">
            <p>© 2025 Vetis Andalucía - Todos los derechos reservados</p>
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