<!-- Página Principal de Navegación - Presentación y navegación por las otras páginas en que se muestran las tablas  -->
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
  <title>Bienvenido a Vetis</title>
  <link rel="stylesheet" type="text/css" href="../sets/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
  <div class="layout-container">
      <aside class="sidebar">
      <nav>
        <ul>
          <li style="background-color: #13512d; border-radius: 15px"><a href="principal.php"><img src="../sets/img/Vetis_logo_blanco.png" width="125px" alt="Vetis Logo"></a></li>
          <li><a href="mascotas.php">Mascotas</a></li>
          <li><a href="veterinarios.php">Veterinarios</a></li>
          <li><a href="historial.php">Historial</a></li>
          <li><a href="propietarios.php">Propietarios</a></li>
          <li><a href="raza.php">Raza</a></li>
          <li><a href="noticias.php">Noticias</a></li>
        </ul>
      </nav>
    </aside>  

    <div class="content-area flex-grow-1 d-flex flex-column" style="margin-left: 250px;">
      <main class="main-content flex-grow-1 bg-light py-4 px-2 d-flex flex-column align-items-center justify-content-start">
        <div class="container-fluid h-100 d-flex flex-column">
          <div class="row g-4 flex-grow-1 align-items-stretch justify-content-center ps-xl-5 ps-lg-5 ps-md-4 ps-3">
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Bienestar y Presentación</span>
                  <div><i class="fa-solid fa-dog fa-2x mt-1"></i></div>
                </div>
                <div class="card-body">
                  <p>
                    En nuestra clínica veterinaria nos dedicamos al cuidado y bienestar de tus mascotas.<br>
                    Utiliza la barra lateral para navegar por las diferentes secciones: consulta información sobre mascotas, veterinarios, historial y noticias.<br>
                    ¡Gracias por confiar en nosotros!
                  </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Contacto</span>
                  <div><i class="fa-solid fa-phone fa-2x mt-1"></i></div>
                </div>
                <div class="card-body">
                  <p>
                    Teléfono: <a>+34 923 052 025</a><br>
                    Email: <a href="mailto:info@vetisandalucia.com">info@vetisandalucia.com</a><br>
                    Dirección: Av. Mare de Déu de Bellvitge, 100, 110, 08907 L'Hospitalet de Llobregat, Barcelona
                  </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Horario de atención</span>
                  <div><i class="fa-solid fa-clock fa-2x mt-1"></i></div>
                </div>
                <div class="card-body">
                  <p>
                    Lunes a Viernes: 9:00 - 20:00<br>
                    Sábados: 10:00 - 14:00<br>
                    Domingos y festivos: Cerrado
                  </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Servicios principales</span>
                  <div><i class="fa-solid fa-stethoscope fa-2x mt-1"></i></div>
                </div>
                <div class="card-body">
                  <ul>
                    <li>Consultas generales y especializadas</li>
                    <li>Vacunación y desparasitación</li>
                    <li>Diagnóstico por imagen (radiografía, ecografía)</li>
                    <li>Asesoramiento nutricional</li>
                    <li>Identificación con microchip</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100 text-center" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Nuestra Identidad</span>
                  <div><i class="fa-solid fa-shield-dog fa-2x mt-1"></i></div>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <img src="../sets/img/Logo_final_sin_fondo.png" alt="Logo Clínica Veterinaria" class="img-fluid mb-2" style="max-width:120px;">
                  <div>Clínica Veterinaria Vetis Andalucía</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-stretch">
              <div class="card border-success shadow-sm w-100 h-100" style="max-width: 400px; min-height: 290px;">
                <div class="card-header bg-success text-white text-center py-2 d-flex flex-column align-items-center justify-content-center gap-1">
                  <span class="fw-bold">Información interna</span>
                  <div><i class="fa-solid fa-info-circle fa-2x mt-1"></i></div>
                </div>
                <div class="card-body">
                  <p>
                    Esta web es de uso interno para el personal de Vetis Andalucía.<br>
                    Consulta las <a href="noticias.php" class="link-success fw-bold">últimas noticias internas</a> para estar al día de novedades, comunicados y actualizaciones importantes de la clínica.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <footer class="footer bg-white border-top text-center py-1 mt-auto">
        <p class="mb-0 small">© 2023 Vetis Andalucía - Todos los derechos reservados - Información confidencial - Uso interno exclusivo</p>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>