<?php
/**
 * Controlador Frontal - Punto de entrada principal
 * Proyecto: Sistema de Gestión Gimnasio Olimpia
 * Estructura MVC Profesional
 */

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirigir a la página principal de login
header('Location: views/index.html');
exit();
?>