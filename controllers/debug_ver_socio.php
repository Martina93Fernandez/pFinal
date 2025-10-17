<?php
session_start();
include '../models/conexion.php';

function limpiar($dato) {
  return htmlspecialchars(trim($dato));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo "Método debe ser POST<br>";
  echo "Método recibido: " . $_SERVER['REQUEST_METHOD'] . "<br>";
  die('Acceso no permitido.');
}

$dni = limpiar($_POST['dni'] ?? '');

echo "DNI recibido: '" . $dni . "'<br>";

if (empty($dni)) {
  echo "DNI está vacío<br>";
  $_SESSION['error'] = 'DNI no válido.';
  header('Location: ../views/socios.html');
  exit;
}

$sql = "SELECT * FROM socios WHERE dni = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Error en la preparación: " . $conn->error);
}

$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

echo "Filas encontradas: " . $result->num_rows . "<br>";

if ($result->num_rows > 0) {
  $socio_data = $result->fetch_assoc();
  $_SESSION['socio'] = $socio_data;
  $_SESSION['modo'] = 'editar';
  echo "Socio encontrado:<br>";
  print_r($socio_data);
} else {
  $_SESSION['socio'] = ['dni' => $dni];
  $_SESSION['modo'] = 'nuevo';
  echo "Socio NO encontrado, creando modo nuevo<br>";
}

$stmt->close();
$conn->close();

echo "<br><br><a href='../views/ficha.php'>Ir a ficha</a>";
?>