<!-- Eliminación de historial  -->

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../views/login.php");
    exit();
}

include "../conexion/conexion.php";

if (isset($_GET['id_historial']) && !empty($_GET['id_historial'])) {
    $id_historial = $_GET['id_historial'];

    // Eliminamos el historial
    $sql_eliminar_histo = "DELETE FROM historial WHERE id_historial = ?";
    
    $stmt_histo = mysqli_prepare($conn, $sql_eliminar_histo);
    mysqli_stmt_bind_param($stmt_histo, "i", $id_historial);

    $resultado_histo = mysqli_stmt_execute($stmt_histo);
    mysqli_stmt_close($stmt_histo);

    if ($resultado_histo) {
        echo "<p>Historial eliminado correctamente.</p>";
        header("Location: ../views/historial.php");
        exit();
    } else {
        echo "<p>Error al eliminar el historial: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ID de historial no encontrado o no válido para eliminar.</p>";
}

mysqli_close($conn);
?>


<!-- From Uiverse.io by AnthonyPreite --> 
<!-- 
  <div id="form-ui">
    <form action="" method="post" id="form">
      <div id="form-body">
        <div id="welcome-lines">
          <div id="welcome-line-1">Spotify</div>
          <div id="welcome-line-2">Welcome Back, Loyd</div>
        </div>
        <div id="input-area">
          <div class="form-inp">
            <input placeholder="Email Address" type="text">
          </div>
          <div class="form-inp">
            <input placeholder="Password" type="password">
          </div>
        </div>
        <div id="submit-button-cvr">
          <button id="submit-button" type="submit">Login</button>
        </div>
        <div id="forgot-pass">
          <a href="#">Forgot password?</a>
        </div>
        <div id="bar"></div>
      </div>
    </form>
    </div>
   -->


<!-- <form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $mascota['Nombre']; ?>" required>
    <br>
    
    <label>Sexo:</label>
    <input type="text" name="genero" value="<?php echo $mascota['Sexo']; ?>">
    <br>
    
    <label>Especie:</label>
    <input type="text" name="especie" value="<?php echo $mascota['Especie']; ?>">
    <br>
    
    <label>Raza:</label>
<select id="Raza" name="raza" required>
        <option value="">Seleccionar raza: </option>
        <?php
        $sql = "SELECT $id Nombre FROM raza";
        $result = mysqli_query($conn, $sql);
        $listamasc = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($listamasc as $lm) {
            echo "<option value='{$lm['Chip']}'>{$lm['Nombre']}</option>";
        }
        ?>
    </select>    <br>
    
    <button type="submit">Guardar cambios</button>
</form> -->