<?php
// Muestra todos los productos con sus botones de actualizar y borrar
require_once "Producto.php";
$producto = new Producto();
$lista = $producto->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de productos</title>
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <h1>Lista de productos</h1>

    <!-- Mensaje de éxito (viene desde productoCont.php) -->
    <?php if (isset($_GET['msg'])) { ?>
        <p><strong><?= htmlspecialchars($_GET['msg']) ?></strong></p>
    <?php } ?>

    <table>
        <tr>
            <th>ID</th><th>Foto</th><th>Nombre</th><th>Precio</th>
            <th>Stock</th><th>Categoría</th><th>Acciones</th>
        </tr>
        <?php while ($p = $lista->fetch_assoc()) { ?>
        <tr>
            <td><?= $p['id_producto'] ?></td>
            <td><img src="fotos/<?= $p['foto_p'] ?>" width="80"></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td>$<?= $p['precio'] ?></td>
            <td><?= $p['stock'] ?></td>
            <td><?= $p['categoria'] ?></td>
            <td>
                <a href="productoInsertar.php?id=<?= $p['id_producto'] ?>">Actualizar</a> |
                <a href="productoCont.php?accion=borrar&id=<?= $p['id_producto'] ?>"
                   onclick="return confirm('¿Seguro que quieres borrar este producto?')">Borrar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br><a href="index.php">Volver al menú</a>
</body>
</html>