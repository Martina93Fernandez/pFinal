<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GymDB";

// Conexión inicial sin seleccionar base de datos
$conn = new mysqli($host, $user, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Base de datos '$dbname' lista.<br>";
} else {
    die("Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear las tablas
$sql = "
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS socios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dni VARCHAR(50) DEFAULT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    nacimiento DATE NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(150),
    fecha_ingreso DATE NOT NULL,
    cuota VARCHAR(10),
    comentarios TEXT
);
";

// Ejecutar múltiples consultas
if ($conn->multi_query($sql)) {
    echo "Tablas creadas correctamente.";
} else {
    echo "Error al crear tablas: " . $conn->error;
}

$conn->close();
?>