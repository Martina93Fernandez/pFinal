<?php
include 'conexion.php';

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido.');
}

$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$dni = $_POST['dni'] ?? '';
$nacimiento = $_POST['nacimiento'] ?? null;
$telefono = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
$cuota = $_POST['cuota'] ?? '';
$comentarios = $_POST['comentarios'] ?? '';

$sql = "INSERT INTO socios (dni, nombre, apellido, nacimiento, telefono, direccion, fecha_ingreso, cuota, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die('Error en preparación: ' . $conn->error);
}
$stmt->bind_param("sssssssss", $dni, $nombre, $apellido, $nacimiento, $telefono, $direccion, $fecha_ingreso, $cuota, $comentarios);

if ($stmt->execute()) {
  echo "<h2>Socio registrado exitosamente.</h2>";
  echo "<a href='../socios.html'>Volver a la lista de socios</a>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>