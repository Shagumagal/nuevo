<?php
include('conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id']) && isset($_SESSION['usuario_id'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Verificar que el producto exista
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if ($producto) {
        $total = $producto['precio'] * $cantidad;

        // Insertar el pedido en la base de datos
        $usuario_id = $_SESSION['usuario_id'];
        $sql = "INSERT INTO pedidos (usuario_id, producto_id, cantidad, total) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $usuario_id, $producto_id, $cantidad, $total);
        if ($stmt->execute()) {
            echo "Compra realizada con éxito. Total: $" . $total;
        } else {
            echo "Error al procesar la compra: " . $conn->error;
        }
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "Debe iniciar sesión para comprar o el producto no fue especificado.";
}
?>
