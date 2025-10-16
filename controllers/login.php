<?php
include 'conexion.php';

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Aceptar tanto 'password' como 'contraseña' por compatibilidad
if (isset($_POST['nombre']) && (isset($_POST['password']) || isset($_POST['contraseña']))) {
    $nombre = validate($_POST['nombre']);
    $password_input = validate($_POST['password'] ?? $_POST['contraseña']);

    // Preparar y ejecutar consulta segura
    $sql = "SELECT nombre, password, rol FROM usuarios WHERE nombre = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        $conn->close();
        exit();
    }
    $stmt->bind_param('s', $nombre);
    $stmt->execute();

    // Vincular resultado y comprobar si existe usuario
    $stmt->bind_result($db_nombre, $db_password_hash, $db_rol);
    if ($stmt->fetch()) {
        // Verificar contraseña usando password_verify
        if (password_verify($password_input, $db_password_hash)) {
            session_start();
            $_SESSION['nombre'] = $db_nombre;
            $_SESSION['rol'] = $db_rol;

            // Redirigir ambos roles a ingreso.html (ruta existente)
            header('Location: ../ingreso.html');
            exit();
        } else {
            echo "Contraseña incorrecta";
            $stmt->close();
            $conn->close();
            exit();
        }
    } else {
        echo "Usuario no encontrado";
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Por favor, complete todos los campos";
    exit();
}
