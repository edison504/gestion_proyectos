<?php
require_once 'config/database.php';
require_once 'models/Producto.php';

class ProductoController {
    private $db;
    private $producto;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->producto = new Producto($this->db);
    }

    // Cargar la vista principal con la tabla de datos y categorías
    public function index() {
        $productos = $this->producto->obtenerTodos();
        $categorias = $this->producto->obtenerCategorias();
        $productoEditar = null;

        // Si se presiona el botón "Editar", recuperamos los datos de ese producto
        if (isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id'])) {
            $productoEditar = $this->producto->obtenerPorId($_GET['id']);
        }

        require_once 'views/producto_view.php';
    }

    // Procesar el envío del formulario (Guardar nuevo o Actualizar)
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];
            $categoria_id = $_POST['categoria_id'];

            if (!empty($nombre) && $precio > 0 && $cantidad >= 0 && !empty($categoria_id)) {
                if ($id) {
                    $this->producto->actualizar($id, $nombre, $descripcion, $precio, $cantidad, $categoria_id);
                } else {
                    $this->producto->insertar($nombre, $descripcion, $precio, $cantidad, $categoria_id);
                }
            }
            header("Location: index.php");
            exit();
        }
    }

    // Eliminar un registro
    public function eliminar() {
        if (isset($_GET['id'])) {
            $this->producto->eliminar($_GET['id']);
        }
        header("Location: index.php");
        exit();
    }
}
?>