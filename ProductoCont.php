<?php
// productoCont.php: recibe lo que manda el usuario y decide qué hacer
require_once "Producto.php";
$producto = new Producto();

// Vemos qué acción nos pidieron: insertar, borrar o actualizar
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

// Guarda la foto en la carpeta "fotos" y devuelve el nombre del archivo
function subirFoto() {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // time() pone la hora al nombre para que no se repita
        $nombreFoto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "fotos/" . $nombreFoto);
        return $nombreFoto;
    }
    return ""; // no subieron foto
}

if ($accion == "insertar") {
    $foto = subirFoto();
    $ok = $producto->insertar($_POST['nombre'], $_POST['precio'],
                              $_POST['stock'], $foto, $_POST['categoria_id']);
    $mensaje = $ok ? "Producto insertado con éxito" : "Error al insertar el producto";
    header("Location: productoLista.php?msg=" . urlencode($mensaje));

} elseif ($accion == "borrar") {
    $ok = $producto->borrar($_GET['id']);
    $mensaje = $ok ? "Producto borrado con éxito" : "Error al borrar el producto";
    header("Location: productoLista.php?msg=" . urlencode($mensaje));

} elseif ($accion == "actualizar") {
    $foto = subirFoto();
    // Si no subió foto nueva, se queda la que ya tenía
    if ($foto == "") { $foto = $_POST['foto_actual']; }
    $ok = $producto->actualizar($_POST['id_producto'], $_POST['nombre'], $_POST['precio'],
                                $_POST['stock'], $foto, $_POST['categoria_id']);
    $mensaje = $ok ? "Producto actualizado con éxito" : "Error al actualizar el producto";
    header("Location: productoLista.php?msg=" . urlencode($mensaje));

} else {
    // Si entran directo a este archivo, los mandamos al menú
    header("Location: index.php");
}
?>