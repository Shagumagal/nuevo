<?php
include('conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($contrasena, $user['contrasena'])) {
            $_SESSION['usuario_id'] = $user['id'];
            header("Location: index.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<form method="post">
    Usuario: <input type="text" name="nombre_usuario" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    <input type="submit" value="Iniciar sesión">
</form>
