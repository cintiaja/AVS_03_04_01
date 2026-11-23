<?php
// Clase Producto: aquí está TODO lo que habla con la base de datos
class Producto {
    private $conexion; // guarda la conexión a MySQL

    // El constructor se ejecuta solo al crear el objeto: nos conectamos a la BD
    public function __construct() {
        // Datos: servidor, usuario, contraseña (vacía en XAMPP), nombre de la base
        $this->conexion = new mysqli("localhost", "root", "", "avs_03_04_01");
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
        $this->conexion->set_charset("utf8mb4"); // para que se vean bien los acentos
    }

    // INSERTAR un producto nuevo
    public function insertar($nombre, $precio, $stock, $foto, $categoria_id) {
        // Los ? se llenan después (protege contra inyección SQL)
        $sql = "INSERT INTO productos (nombre, precio, stock, foto_p, categoria_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        // s = texto, d = decimal, i = entero
        $stmt->bind_param("sdisi", $nombre, $precio, $stock, $foto, $categoria_id);
        return $stmt->execute(); // true si salió bien
    }

    // LISTAR todos los productos junto con el nombre de su categoría
    public function listar() {
        $sql = "SELECT p.*, c.descripcion AS categoria
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id_categoria";
        return $this->conexion->query($sql);
    }

    // OBTENER un solo producto (para llenar el formulario de actualizar)
    public function obtener($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ACTUALIZAR un producto
    public function actualizar($id, $nombre, $precio, $stock, $foto, $categoria_id) {
        $sql = "UPDATE productos
                SET nombre=?, precio=?, stock=?, foto_p=?, categoria_id=?
                WHERE id_producto=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sdisii", $nombre, $precio, $stock, $foto, $categoria_id, $id);
        return $stmt->execute();
    }

    // BORRAR un producto
    public function borrar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Trae las categorías para el menú desplegable del formulario
    public function categorias() {
        return $this->conexion->query("SELECT * FROM categorias");
    }
}
?>