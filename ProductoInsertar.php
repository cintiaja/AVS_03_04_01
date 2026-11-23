<?php
// Este formulario sirve para INSERTAR y para ACTUALIZAR
require_once "Producto.php";
$producto = new Producto();

// Si en la URL viene un id, estamos actualizando: cargamos sus datos
$id = $_GET['id'] ?? null;
$datos = $id ? $producto->obtener($id) : null;
$categorias = $producto->categorias();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? "Actualizar" : "Insertar" ?> producto</title>
</head>
<body>
    <h1><?= $id ? "Actualizar" : "Insertar" ?> producto</h1>

    <!-- enctype es OBLIGATORIO para poder subir la foto -->
    <form action="productoCont.php" method="POST" enctype="multipart/form-data">
        <!-- Campos ocultos: le dicen a productoCont.php qué hacer -->
        <input type="hidden" name="accion" value="<?= $id ? 'actualizar' : 'insertar' ?>">
        <input type="hidden" name="id_producto" value="<?= $datos['id_producto'] ?? '' ?>">
        <input type="hidden" name="foto_actual" value="<?= $datos['foto_p'] ?? '' ?>">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" maxlength="30" required
               value="<?= htmlspecialchars($datos['nombre'] ?? '') ?>"><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" required
               value="<?= $datos['precio'] ?? '' ?>"><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" required
               value="<?= $datos['stock'] ?? '' ?>"><br><br>

        <label>Categoría:</label><br>
        <select name="categoria_id" required>
            <?php while ($c = $categorias->fetch_assoc()) { ?>
                <option value="<?= $c['id_categoria'] ?>"
                    <?= (isset($datos) && $datos['categoria_id'] == $c['id_categoria']) ? 'selected' : '' ?>>
                    <?= $c['descripcion'] ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Foto:</label><br>
        <?php if ($id && $datos['foto_p']) { ?>
            <img src="fotos/<?= $datos['foto_p'] ?>" width="100"><br>
        <?php } ?>
        <!-- Al insertar la foto es obligatoria; al actualizar es opcional -->
        <input type="file" name="foto" accept="image/*" <?= $id ? '' : 'required' ?>><br><br>

        <button type="submit"><?= $id ? "Actualizar" : "Guardar" ?></button>
        <a href="index.php">Volver al menú</a>
    </form>
</body>
</html>