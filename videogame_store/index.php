<?php
include('conexion.php');
session_start();

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === 'agregar') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
        $stmt->execute();
    } elseif ($accion === 'editar') {
        $id = $_POST['producto_id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=? WHERE id=?");
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);
        $stmt->execute();
    } elseif ($accion === 'eliminar') {
        $id = $_POST['producto_id'];
        
        $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Obtener productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Videojuegos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>Lista de Productos</h1>

<div class="product-container">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="product">
            <h2><?php echo $row['nombre']; ?></h2>
            <p><?php echo $row['descripcion']; ?></p>
            <p class="precio">Precio: $<?php echo $row['precio']; ?></p>
            <form action="" method="post">
                <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                <input type="number" name="cantidad" value="1" min="1" required>
                <input type="submit" name="accion" value="comprar">
            </form>
            <form action="" method="post">
                <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                <textarea name="descripcion" required><?php echo $row['descripcion']; ?></textarea>
                <input type="number" name="precio" value="<?php echo $row['precio']; ?>" required>
                <input type="submit" name="accion" value="editar">
                <input type="submit" name="accion" value="eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
            </form>
        </div>
    <?php endwhile; ?>
</div>

<h2>Agregar Producto</h2>
<form action="" method="post">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="number" name="precio" placeholder="Precio" required>
    <input type="submit" name="accion" value="agregar">
</form>

</body>
</html>

