<?php
include 'conexion.php';

// Asegurar que la petición es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Mostrar un mensaje claro y un enlace de vuelta al formulario
    echo "<p>Método inválido. Usa el formulario de registro en <a href='../admin_socio.html'>Registro</a>.</p>";
    exit();
}

// Usar valores seguros para evitar notices
$nombre = $_POST['nombre'] ?? '';
$password = $_POST['password'] ?? '';
$rol = $_POST['rol'] ?? 'usuario';

if ($nombre === '' || $password === '') {
    echo "<p>Faltan datos: nombre y contraseña son obligatorios. <a href='../admin_socio.html'>Volver</a></p>";
    exit();
}

// Verificar que la tabla 'usuarios' existe antes de intentar insertar
$res = $conn->query("SHOW TABLES LIKE 'usuarios'");
if (!$res || $res->num_rows == 0) {
    echo "<h3>Tabla 'usuarios' no encontrada.</h3>";
    echo "<p>Debes crear las tablas ejecutando <code>php/crear_tablas.php</code>. Abre en tu navegador: <a href='../php/crear_tablas.php'>Crear tablas</a></p>";
    $conn->close();
    exit();
}

// Encriptar contraseña
$password_segura = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, password, rol) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    $conn->close();
    exit();
}
$stmt->bind_param("sss", $nombre, $password_segura, $rol);

if ($stmt->execute()) {
  // Redirigir de vuelta a la página de origen (referer) con parámetro de éxito
  $ref = $_SERVER['HTTP_REFERER'] ?? '';
  if ($ref) {
    $sep = (strpos($ref, '?') === false) ? '?' : '&';
    header('Location: ' . $ref . $sep . 'reg=success');
  } else {
    header('Location: ../ingreso.php?reg=success');
  }
  exit();
} else {
  // Loguear el error para depuración
  $logFile = __DIR__ . DIRECTORY_SEPARATOR . 'register_debug.log';
  $logEntry = date('Y-m-d H:i:s') . " - Nombre: $nombre - Rol: $rol - Error: " . $stmt->error . PHP_EOL;
  @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

  // Redirigir de vuelta a la página de origen (si existe) con parámetro de error
  $ref = $_SERVER['HTTP_REFERER'] ?? '';
  if ($ref) {
    $sep = (strpos($ref, '?') === false) ? '?' : '&';
    header('Location: ' . $ref . $sep . 'reg=error');
    exit();
  }

  // Fallback: mostrar mensaje genérico
  echo "<h3>Error al registrar</h3><p>Ha ocurrido un error al intentar guardar el usuario. Si el problema persiste, revisa el log en <code>php/register_debug.log</code> o consulta al administrador.</p>";
}

$stmt->close();
$conn->close();
?>
