<?php
include('conexion.php');
session_start();

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
            <form action="comprar.php" method="post">
                <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                <input type="number" name="cantidad" value="1" min="1" required>
                <input type="submit" value="Comprar">
            </form>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
