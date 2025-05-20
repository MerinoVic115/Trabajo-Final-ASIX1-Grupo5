<?php
session_start();

// Verificamos si el usuario está logueado
if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias Internas - Vetis Andalucía</title>
    <link rel="stylesheet" href="../sets/css/styles.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0 auto;
            background-color: #f5f5f5;
        }
        
        header {
            background-color: #1e8449;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            margin: 0;
            font-size: 2.5em;
        }
        
        .logo {
            height: 80px;
            margin-bottom: 15px;
        }
        
        .news-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .news-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
        }
        
        .news-image {
            width: 50%;
            /* height: 200px; */
            object-fit: cover;
        }
        
        .news-content {
            padding: 20px;
        }
        
        .news-title {
            color: #1e8449;
            margin-top: 0;
            font-size: 1.5em;
        }
        
        .news-date {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        
        .highlight .news-title {
            color: white;
        }
        
        .highlight .news-content {
            color: white;
        }
        
        .highlight .news-date {
            color: #e0e0e0;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #777;
            font-size: 0.9em;
        }
        
        @media (max-width: 768px) {
            .news-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
        <aside class="sidebar">
        <nav>
            <ul>
            <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
            <li><a href="mascotas.php">Mascotas</a></li>
            <li><a href="veterinarios.php">Veterinarios</a></li>
            <li><a href="historial.">Historial</a></li>
            <li><a href="propietarios.php">Propietarios</a></li>
            <li><a href="raza.php">Raza</a></li>
            <li><a href="noticias.php">Noticias</a></li>
            </ul>
        </nav>
        </aside>   

        <main class="main-content">
            <nav>
                <div style="padding: 10px; background: #f1f1f1;">
                    Bienvenido, <?php echo $_SESSION['username'] ?? 'Usuario'; ?>
                    <a href="logout.php" style="float: right;">Cerrar sesión</a>
                </div>
            </nav>

    <header>
        <img src="../sets/img/Vetis_logo_blanco.png" alt="Vetis Andalucía" class="logo">
        <h1>Noticias Internas</h1>
        <p>Actualizaciones, descubrimientos y logros de nuestro equipo</p>
    </header>
    
    <main class="news-container">
      
    <article class="news-card">
            <img src="../sets/img/camiseta_betis_patrocinio.png" alt="Vetis patrocina al Real Betis" class="news-image">
            <div class="news-content">
                <h2 class="news-title">Vetis se convierte en patrocinador oficial del Real Betis Balompié</h2>
                <p class="news-date">15 de junio, 2024</p>
                <p>Nos complace anunciar que Vetis ha firmado un acuerdo de patrocinio con el Real Betis Balompié. Como parte de este acuerdo, nuestro equipo veterinario proporcionará atención especializada a los animales mascota del club y participará en iniciativas conjuntas de bienestar animal.</p>
                <p>Además, nuestro logo aparecerá en las pantallas del estadio Benito Villamarín durante toda la temporada 2024-2025.</p>
            </div>

    </article>
        <article class="news-card">
            <img src="../sets/img/ChatGPT_Image_19_may_2025_12_40_04.png" alt="Rehabilitación canina" class="news-image">
            <div class="news-content">
                <h2 class="news-title">Nuevo patrocinio en camino</h2>
                <p class="news-date">20 de enero, 2025</p>
                <p>Nos enorgullece anunciar que Vetis Andalucía ha firmado un acuerdo de patrocinio con el Aston Martin Aramco Cognizant Formula One™ Team. Como parte de este emocionante acuerdo, nuestro equipo veterinario proporcionará atención especializada a las mascotas del equipo y desarrollaremos programas conjuntos de bienestar animal.</p>
                <p>Nuestro logo aparecerá en el monoplaza AMR23 durante varias carreras de la temporada 2023, incluyendo el Gran Premio de España en Barcelona.</p>
            </div>
            
        </article>

    </article>
        
        <article class="news-card">
            <img src="../sets/img/tratamiento-gato.jpg" alt="Nuevo tratamiento para gatos" class="news-image">
            <div class="news-content">
                <h2 class="news-title">Desarrollamos tratamiento pionero para enfermedades renales en gatos</h2>
                <p class="news-date">3 de mayo, 2025</p>
                <p>Nuestro equipo de investigación ha desarrollado un protocolo innovador para el tratamiento temprano de la enfermedad renal crónica en felinos, con una tasa de éxito del 87% en los casos estudiados.</p>
                <p>El tratamiento combina terapia nutricional, hidratación subcutánea y un nuevo suplemento renal desarrollado en nuestra clínica.</p>
            </div>
        </article>
        
        <article class="news-card">
            <img src="../sets/img/equipo-vet.jpg" alt="Equipo veterinario" class="news-image">
            <div class="news-content">
                <h2 class="news-title">Nuevo equipo de diagnóstico por imagen de última generación</h2>
                <p class="news-date">22 de abril, 2025</p>
                <p>Hemos instalado un nuevo equipo de resonancia magnética de 1.5 Tesla específicamente diseñado para animales pequeños. Esta tecnología nos permite realizar diagnósticos más precisos con menor tiempo de sedación.</p>
                <p>El equipo ya está disponible en nuestra sede central en Sevilla y próximamente se instalará en nuestras clínicas de Málaga y Córdoba.</p>
            </div>
        </article>
        
        <article class="news-card">
            <img src="../sets/img/rehabilitado-perro.jpeg" alt="Rehabilitación canina" class="news-image">
            <div class="news-content">
                <h2 class="news-title">Programa de rehabilitación canina obtiene resultados excepcionales</h2>
                <p class="news-date">10 de marzo, 2025</p>
                <p>Nuestro programa de rehabilitación post-quirúrgica para perros ha demostrado reducir el tiempo de recuperación en un 40% según los últimos datos. El protocolo incluye hidroterapia, láser terapéutico y ejercicios asistidos.</p>
                <p>El departamento de fisioterapia animal ha atendido ya a más de 150 pacientes con excelentes resultados.</p>
            </div>

        </article>

        <article class="news-card">
    <img src="../sets/img/vacuna-felina.png" alt="Vacunación felina" class="news-image">
    <div class="news-content">
        <h2 class="news-title">Nueva vacuna exclusiva para enfermedades felinas</h2>
        <p class="news-date">5 de octubre, 2025</p>
        <p>Vetis Andalucía presenta la primera vacuna contra el síndrome respiratorio felino complejo, con un 98% de efectividad comprobada en pruebas clínicas.</p>
        <p>El tratamiento ya está disponible en todas nuestras clínicas y ha demostrado reducir los casos graves en un 75% durante el periodo de pruebas.</p>
    </div>
</article>
    </main>
        
    <footer>
        <p>© 2023 Vetis Andalucía - Todos los derechos reservados</p>
        <p>Información confidencial - Uso interno exclusivo</p>
    </footer>
         </main>

</body>
</html>