<?php
include 'conexion.php';

function validate($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

// Aceptar tanto POST como GET para compatibilidad
$dni = '';
if (isset($_POST['dni'])) {
  $dni = validate($_POST['dni']);
} elseif (isset($_GET['numeroSocio'])) {
  $dni = validate($_GET['numeroSocio']);
}

if (!empty($dni)) {
  // Buscar socio por DNI (también probamos con LIKE por si hay espacios o diferencias)
  $sql = "SELECT * FROM socios WHERE dni = ? OR dni LIKE ?";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    die("Error en la preparación: " . $conn->error);
  }
  
  $dni_like = '%' . $dni . '%';
  $stmt->bind_param("ss", $dni, $dni_like);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows >= 1) {
    $socio = $result->fetch_assoc();
    
    // Construir URL con todos los datos para precargar ficha.html
    $params = array(
      'dni' => urlencode($socio['dni'] ?? ''),
      'nombre' => urlencode($socio['nombre'] ?? ''),
      'apellido' => urlencode($socio['apellido'] ?? ''),
      'nacimiento' => urlencode($socio['nacimiento'] ?? ''),
      'telefono' => urlencode($socio['telefono'] ?? ''),
      'direccion' => urlencode($socio['direccion'] ?? ''),
      'fecha_ingreso' => urlencode($socio['fecha_ingreso'] ?? ''),
      'cuota' => urlencode($socio['cuota'] ?? ''),
      'comentarios' => urlencode($socio['comentarios'] ?? ''),
      'modo' => 'editar'
    );
    
    $query_string = http_build_query($params);
    header('Location: ../ficha.html?' . $query_string);
    exit();
  } else {
    // No se encontró el socio, redirigir a ficha.html con el DNI para crear nuevo
    header('Location: ../ficha.html?dni=' . urlencode($dni) . '&modo=nuevo');
    exit();
  }
} else {
  echo "<p style='color:red;'>Por favor ingresa un DNI válido.</p>";
  echo "<a href='../socios.html'>Volver</a>";
}
?>