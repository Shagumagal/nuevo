<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES ('$nombre_usuario', '$correo', '$contrasena')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    Usuario: <input type="text" name="nombre_usuario" required><br>
    Correo: <input type="email" name="correo" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    <input type="submit" value="Registrar">
</form>
