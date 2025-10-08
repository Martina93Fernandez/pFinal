<?php
// Copia este archivo a php/conexion.php y completa tus credenciales locales.
$host = "localhost";
$usuario = "root";
$contrasena = ""; // añade tu contraseña si la tienes
$base_de_datos = "GymDB";

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>
