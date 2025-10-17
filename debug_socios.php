<?php
include 'models/conexion.php';

echo "<h3>Verificación de tabla socios en BD: GymDB</h3>";

$sql = "SELECT * FROM socios LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>DNI</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['dni'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellido'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay datos en la tabla socios";
}

$conn->close();
?>