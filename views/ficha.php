<?php
session_start();
$socio = $_SESSION['socio'] ?? [];
$modo = $_SESSION['modo'] ?? 'nuevo';

// NO borrar la sesión hasta después de mostrar el formulario
// Los datos se limpiarán cuando se envíe el formulario
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title><?= $modo === 'editar' ? 'Modificar Ficha de Socio' : 'Nueva Ficha de Socio' ?></title>
  <link rel="stylesheet" href="../assets/css/style2.css?v=2.0" />
</head>
<body>
  <div class="form-container">
    <h2 class="titulo-brillo"><?= $modo === 'editar' ? 'Modificar Ficha de Socio' : 'Nueva Ficha de Socio' ?></h2>

    <form action="../controllers/admin_socio.php" method="post" class="form-ficha">
      <div class="form-row">
        <div class="form-group">
          <label for="dni">D.N.I.</label>
          <input type="text" id="dni" name="dni" required value="<?= htmlspecialchars($socio['dni'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($socio['nombre'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" name="apellido" required value="<?= htmlspecialchars($socio['apellido'] ?? '') ?>" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="tel" id="telefono" name="telefono" required value="<?= htmlspecialchars($socio['telefono'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="nacimiento">Fecha de nacimiento</label>
          <input type="date" id="nacimiento" name="nacimiento" required value="<?= htmlspecialchars($socio['nacimiento'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="fecha_ingreso">Fecha de ingreso</label>
          <input type="date" id="fecha_ingreso" name="fecha_ingreso" required value="<?= htmlspecialchars($socio['fecha_ingreso'] ?? '') ?>" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="cuota">Última cuota</label>
          <input type="month" id="cuota" name="cuota" required value="<?= htmlspecialchars($socio['cuota'] ?? '') ?>" />
        </div>

        <div class="form-group">
          <label for="direccion">Dirección</label>
          <input type="text" id="direccion" name="direccion" required value="<?= htmlspecialchars($socio['direccion'] ?? '') ?>" />
        </div>

        <div class="form-group"></div>
      </div>

      <div class="form-row">
        <div class="form-group full-width">
          <label for="comentarios">Observaciones</label>
          <textarea id="comentarios" name="comentarios" rows="3"><?= htmlspecialchars($socio['comentarios'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-actualizar"><?= $modo === 'editar' ? 'Actualizar' : 'Registrar' ?></button>
        <button type="button" class="btn-rutina" onclick="window.open('rutina.pdf', '_blank')">Abrir PDF</button>
      </div>
    </form>
  </div>

<?php
// Limpiar la sesión DESPUÉS de mostrar los datos
unset($_SESSION['socio'], $_SESSION['modo']);
?>
</body>
</html>