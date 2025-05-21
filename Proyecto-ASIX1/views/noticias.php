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
    <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
</head>
<body class="body_noticias">
        <aside class="sidebar">
            <nav>
                <ul>
                <li><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px"></a></li>
                <li><a href="mascotas.php">Mascotas</a></li>
                <li><a href="veterinarios.php">Veterinarios</a></li>
                <li><a href="historial.">Historial</a></li>
                <li><a href="propietarios.php">Propietarios</a></li>
                <li><a href="raza.php">Raza</a></li>
                <li style="background-color: #13512d; border-radius: 15px"><a href="noticias.php">Noticias</a></li>
                </ul>
            </nav>
        </aside>   

    <main class="main-content_noticias" style="margin-left: 19%;">
                    <nav>
                        <div style="padding: 10px; background: #f1f1f1;">
                            Bienvenido, <?php echo $_SESSION['username'] ?? 'Usuario'; ?>
                            <a href="logout.php" style="float: right;">Cerrar sesión</a>
                        </div>
                    </nav>

            <header class="header_noticias" style="margin-left: 0px;">
                <img src="../sets/img/Vetis_logo_blanco.png" alt="Vetis Andalucía" class="logo_noticias">
                <h1 class="h1_noticias">Noticias Internas</h1>
                <p>Actualizaciones, descubrimientos y logros de nuestro equipo</p>
            </header>
            
            <main class="news-container_noticias">
            
                    <article class="news-card_noticias">
                            <img src="../sets/img/camiseta_betis_patrocinio.png" alt="Vetis patrocina al Real Betis" class="news-image_noticias">
                            <div class="news-content_noticias">
                                <h2 class="news-title_noticias">Vetis se convierte en patrocinador oficial del Real Betis Balompié</h2>
                                <p class="news-date_noticias">15 de junio, 2024</p>
                                <p>Nos complace anunciar que Vetis ha firmado un acuerdo de patrocinio con el Real Betis Balompié. Como parte de este acuerdo, nuestro equipo veterinario proporcionará atención especializada a los animales mascota del club y participará en iniciativas conjuntas de bienestar animal.</p>
                                <p>Además, nuestro logo aparecerá en las pantallas del estadio Benito Villamarín durante toda la temporada 2024-2025.</p>
                            </div>

                    </article>
                        <article class="news-card_noticias">
                            <img src="../sets/img/ChatGPT_Image_19_may_2025_12_40_04.png" alt="Rehabilitación canina" class="news-image_noticias">
                            <div class="news-content_noticias">
                                <h2 class="news-title_noticias">Nuevo patrocinio en camino</h2>
                                <p class="news-date_noticias">20 de enero, 2025</p>
                                <p>Nos enorgullece anunciar que Vetis Andalucía ha firmado un acuerdo de patrocinio con el Aston Martin Aramco Cognizant Formula One™ Team. Como parte de este emocionante acuerdo, nuestro equipo veterinario proporcionará atención especializada a las mascotas del equipo y desarrollaremos programas conjuntos de bienestar animal.</p>
                                <p>Nuestro logo aparecerá en el monoplaza AMR23 durante varias carreras de la temporada 2023, incluyendo el Gran Premio de España en Barcelona.</p>
                            </div>
                            
                        </article>

                    </article>
                        
                        <article class="news-card_noticias">
                            <img src="../sets/img/tratamiento-gato.jpg" alt="Nuevo tratamiento para gatos" class="news-image_noticias">
                            <div class="news-content_noticias">
                                <h2 class="news-title_noticias">Desarrollamos tratamiento pionero para enfermedades renales en gatos</h2>
                                <p class="news-date_noticias">3 de mayo, 2025</p>
                                <p>Nuestro equipo de investigación ha desarrollado un protocolo innovador para el tratamiento temprano de la enfermedad renal crónica en felinos, con una tasa de éxito del 87% en los casos estudiados.</p>
                                <p>El tratamiento combina terapia nutricional, hidratación subcutánea y un nuevo suplemento renal desarrollado en nuestra clínica.</p>
                            </div>
                        </article>
                        
                        <article class="news-card_noticias">
                            <img src="../sets/img/equipo-vet.jpg" alt="Equipo veterinario" class="news-image_noticias">
                            <div class="news-content_noticias">
                                <h2 class="news-title_noticias">Nuevo equipo de diagnóstico por imagen de última generación</h2>
                                <p class="news-date_noticias">22 de abril, 2025</p>
                                <p>Hemos instalado un nuevo equipo de resonancia magnética de 1.5 Tesla específicamente diseñado para animales pequeños. Esta tecnología nos permite realizar diagnósticos más precisos con menor tiempo de sedación.</p>
                                <p>El equipo ya está disponible en nuestra sede central en Sevilla y próximamente se instalará en nuestras clínicas de Málaga y Córdoba.</p>
                            </div>
                        </article>
                        
                        <article class="news-card_noticias">
                            <img src="../sets/img/rehabilitado-perro.jpeg" alt="Rehabilitación canina" class="news-image_noticias">
                            <div class="news-content_noticias">
                                <h2 class="news-title_noticias">Programa de rehabilitación canina obtiene resultados excepcionales</h2>
                                <p class="news-date_noticias">10 de marzo, 2025</p>
                                <p>Nuestro programa de rehabilitación post-quirúrgica para perros ha demostrado reducir el tiempo de recuperación en un 40% según los últimos datos. El protocolo incluye hidroterapia, láser terapéutico y ejercicios asistidos.</p>
                                <p>El departamento de fisioterapia animal ha atendido ya a más de 150 pacientes con excelentes resultados.</p>
                            </div>

                        </article>

                        <article class="news-card_noticias">
                    <img src="../sets/img/vacuna-felina.png" alt="Vacunación felina" class="news-image_noticias">
                    <div class="news-content_noticias">
                        <h2 class="news-title_noticias">Nueva vacuna exclusiva para enfermedades felinas</h2>
                        <p class="news-date_noticias">5 de octubre, 2025</p>
                        <p>Vetis Andalucía presenta la primera vacuna contra el síndrome respiratorio felino complejo, con un 98% de efectividad comprobada en pruebas clínicas.</p>
                        <p>El tratamiento ya está disponible en todas nuestras clínicas y ha demostrado reducir los casos graves en un 75% durante el periodo de pruebas.</p>
                    </div>
                </article>
            </main>
                
            <footer class="footer_noticias">
                <p>© 2025 Vetis Andalucía - Todos los derechos reservados</p>
                <p>Información confidencial - Uso interno exclusivo</p>
            </footer>
    </main>

</body>
</html>