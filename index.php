<?php
// Cargar el controlador de productos
require_once 'controllers/ProductoController.php';

// Instanciar el controlador
$controller = new ProductoController();

// Determinar la acción enviada mediante GET
$action = $_GET['action'] ?? 'index';

// Enrutar según la acción solicitada
if ($action == 'guardar') {
    $controller->guardar();
} elseif ($action == 'eliminar') {
    $controller->eliminar();
} else {
    $controller->index();
}
?>