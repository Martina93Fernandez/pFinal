<?php
// Devuelve el método HTTP usado para la petición (útil para depurar 405)
header('Content-Type: text/plain; charset=utf-8');
echo "REQUEST_METHOD=" . ($_SERVER['REQUEST_METHOD'] ?? '');
echo "\n";
echo "REQUEST_URI=" . ($_SERVER['REQUEST_URI'] ?? '');
?>
