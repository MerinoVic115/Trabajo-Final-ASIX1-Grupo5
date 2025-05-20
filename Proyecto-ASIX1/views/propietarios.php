<?php
// Iniciamos sesión primero (debe ser lo primero en el archivo)
session_start();

// Verificamos si el usuario está logueado
// if (!isset($_SESSION['username'])) {
//     header("Location: ../views/login.php");
//     exit();
// }

// Incluimos la conexión después de verificar la sesión
include "../conexion/conexion.php";

// Consulta para obtener la raza
$query = "SELECT DNI, Nombre, Direccion, Telefono, Email FROM propietario";
$result = mysqli_query($conn, $query);

// Almacenamos los resultados
$propietarios = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $propietarios[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../sets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="./sets/img/hueso.svg">
    <title>Propietarios - Vetis</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }
        .layout-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            box-sizing: border-box;
        }
        .sidebar {
            width: 260px;
            min-width: 220px;
            background: #2c3e50;
            color: #fff;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
            height: 100vh;
        }
        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .sidebar nav ul li {
            margin: 20px 0;
            text-align: center;
        }
        .sidebar nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
            padding: 8px 0;
            transition: background 0.3s;
        }
        .sidebar nav ul li a:hover {
            background-color: #34495e;
        }
        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: #fff;
            box-sizing: border-box;
        }
        .main-content {
            flex: 1 0 auto;
            padding: 40px 32px 0 32px;
            box-sizing: border-box;
            width: 100%;
            max-width: 100%;
            margin: 0;
            background: #fff;
        }
        .footer {
            flex-shrink: 0;
            width: 100%;
            text-align: center;
            background: #fff;
            color: #333;
            padding: 15px 0 10px 0;
            border-top: 1px solid #e0e0e0;
            font-size: 1rem;
            box-sizing: border-box;
            margin: 0;
        }
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
    <div class="layout-container">
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
                    <li><a href="mascotas.php">Mascotas</a></li>
                    <li><a href="veterinarios.php">Veterinarios</a></li>
                    <li><a href="historial.php">Historial</a></li>
                    <li><a href="propietarios.php">Propietarios</a></li>
                    <li><a href="raza.php">Raza</a></li>
                    <li><a href="noticias.php">Noticias</a></li>
                </ul>
            </nav>
        </aside>
        <div class="content-area">
            <main class="main-content">
                <nav>
                    <div style="padding: 10px; background: #f1f1f1;">
                        Bienvenido, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?>
                        <a href="../views/logout.php" style="float: right;">Cerrar sesión</a>
                    </div>
                </nav>
                
                <h1>Listado de Propietarios</h1>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Altura</th>
                            <th>Peso</th>
                            <th>Caracter</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($propietarios)): ?>
                            <?php foreach ($propietarios as $propietario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($propietario['Nombre']); ?></td>
                                    <td><?= htmlspecialchars($propietario['Direccion']); ?></td>
                                    <td><?= htmlspecialchars($propietario['Telefono']); ?></td>
                                    <td><?= htmlspecialchars($propietario['Email']); ?></td>

                                    <td class="actions">
                                        <a href="../procesos/mod_pro.php?DNI=<?= $propietario['DNI']; ?>" class="btn-action btn-edit">
                                            <i class="fa-solid fa-pen-to-square" ></i></a>
                                        <a href="../procesos/eliminar_pro.php?DNI=<?= $propietario['DNI']; ?>"  class="btn-action btn-delete"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este propietario?');">
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

                <div style="margin-top: 20px;">
                    <a href="../procesos/crear_pets.php">
                        <button type="submit">Registrar una mascota</button>
                    </a>
                </div>


                    <hr>

                <div style="margin-top: 20px;">
                    <a href="./veterinarios.php">
                        <button type="button">Ver veterinarios</button>
                    </a>
                </div>

                <div style="margin-top: 20px;">
                    <a href="./historial.php">
                        <button type="button">Ver historial</button>
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