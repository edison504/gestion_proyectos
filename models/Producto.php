<?php
class Producto {
    private $conn;
    private $table = "productos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Consulta con JOIN para traer el nombre de la categoría vinculada
    public function obtenerTodos() {
        $query = "SELECT p.*, c.nombre AS categoria_nombre 
                  FROM " . $this->table . " p 
                  INNER JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener un registro por su ID (para cargar en el formulario de edición)
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Obtener listado de categorías para el select del formulario
    public function obtenerCategorias() {
        $query = "SELECT * FROM categorias ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Insertar un nuevo registro (Crear)
    public function insertar($nombre, $descripcion, $precio, $cantidad, $categoria_id) {
        $query = "INSERT INTO " . $this->table . " (nombre, descripcion, precio, categoria_id, cantidad) 
                  VALUES (:nombre, :descripcion, :precio, :categoria_id, :cantidad)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':cantidad' => $cantidad,
            ':categoria_id' => $categoria_id
        ]);
    }

    // Actualizar un registro existente (Editar)
    public function actualizar($id, $nombre, $descripcion, $precio, $cantidad, $categoria_id) {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, descripcion = :descripcion, precio = :precio, Cantidad = :cantidad, categoria_id = :categoria_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':cantidad' => $cantidad,
            ':categoria_id' => $categoria_id
        ]);
    }

    // Eliminar un registro por ID (Borrar)
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>