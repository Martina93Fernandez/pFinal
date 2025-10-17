<?php
include '../models/conexion.php';

// Validar ingreso por POST, si se intenta por otro método, salir
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido.');
}
//captura los datos del formulario 
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$dni = $_POST['dni'] ?? '';
$nacimiento = $_POST['nacimiento'] ?? null;
$telefono = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
$cuota = $_POST['cuota'] ?? '';
$comentarios = $_POST['comentarios'] ?? '';

// Verificar si el socio ya existe con una consulta(para actualizar o insertar)
$check_sql = "SELECT id FROM socios WHERE dni = ?";
$check_stmt = $conn->prepare($check_sql);
if (!$check_stmt) {
    die('Error en preparación de consulta: ' . $conn->error);
}
$check_stmt->bind_param("s", $dni); //evitar inyecciones SQL
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // El socio existe, hacer UPDATE
    $sql = "UPDATE socios SET nombre=?, apellido=?, nacimiento=?, telefono=?, direccion=?, fecha_ingreso=?, cuota=?, comentarios=? WHERE dni=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error en preparación de UPDATE: ' . $conn->error);
    }
    $stmt->bind_param("sssssssss", $nombre, $apellido, $nacimiento, $telefono, $direccion, $fecha_ingreso, $cuota, $comentarios, $dni);
    
    if ($stmt->execute()) {
        echo "<h2>Socio actualizado exitosamente.</h2>";
        echo "<p>DNI: " . htmlspecialchars($dni) . "</p>";
        echo "<a href='../views/socios.html'>Volver a la lista de socios</a>";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }
} else {
    // El socio no existe, hacer INSERT
    $sql = "INSERT INTO socios (dni, nombre, apellido, nacimiento, telefono, direccion, fecha_ingreso, cuota, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error en preparación de INSERT: ' . $conn->error);
    }
    $stmt->bind_param("sssssssss", $dni, $nombre, $apellido, $nacimiento, $telefono, $direccion, $fecha_ingreso, $cuota, $comentarios);
    
    if ($stmt->execute()) {
        echo "<h2>Socio registrado exitosamente.</h2>";
        echo "<p>DNI: " . htmlspecialchars($dni) . "</p>";
        echo "<a href='../views/socios.html'>Volver a la lista de socios</a>";
    } else {
        echo "Error al registrar: " . $stmt->error;
    }
}

$check_stmt->close();
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>