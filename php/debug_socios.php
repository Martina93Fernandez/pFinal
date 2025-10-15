<?php
include 'conexion.php';

echo "<h1>Debug - Estado de la tabla socios</h1>";

// Verificar si la tabla existe
$tables_query = "SHOW TABLES LIKE 'socios'";
$tables_result = $conn->query($tables_query);

if ($tables_result->num_rows == 0) {
    echo "<p style='color:red;'>❌ La tabla 'socios' no existe.</p>";
    echo "<p>Necesitas ejecutar <a href='crear_tablas.php'>crear_tablas.php</a> primero.</p>";
} else {
    echo "<p style='color:green;'>✅ La tabla 'socios' existe.</p>";
    
    // Mostrar estructura de la tabla
    echo "<h2>Estructura de la tabla:</h2>";
    $structure_query = "DESCRIBE socios";
    $structure_result = $conn->query($structure_query);
    
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th></tr>";
    while ($row = $structure_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Mostrar contenido de la tabla
    echo "<h2>Contenido de la tabla (primeros 10 registros):</h2>";
    $content_query = "SELECT * FROM socios LIMIT 10";
    $content_result = $conn->query($content_query);
    
    if ($content_result->num_rows == 0) {
        echo "<p style='color:orange;'>⚠️ La tabla está vacía. No hay socios registrados.</p>";
    } else {
        echo "<p style='color:green;'>Registros encontrados: " . $content_result->num_rows . "</p>";
        
        echo "<table border='1' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>DNI</th><th>Nombre</th><th>Apellido</th><th>Nacimiento</th><th>Teléfono</th><th>Dirección</th><th>Fecha Ingreso</th><th>Cuota</th><th>Comentarios</th></tr>";
        
        while ($row = $content_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id'] ?? '') . "</td>";
            echo "<td><strong>" . htmlspecialchars($row['dni'] ?? '') . "</strong></td>";
            echo "<td>" . htmlspecialchars($row['nombre'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['apellido'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['nacimiento'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['telefono'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['direccion'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['fecha_ingreso'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['cuota'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($row['comentarios'] ?? '') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

$conn->close();
?>

<p><a href="../socios.html">← Volver a Socios</a></p>
<p><a href="../ficha.html">+ Agregar nuevo socio</a></p>