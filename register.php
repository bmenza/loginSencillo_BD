<?php
// register.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['username' => $username, 'password' => $password]);
        echo "Usuario registrado con éxito";
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "El nombre de usuario ya está en uso.";
        } else {
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="post" action="register.php">
        <h2>Registro</h2>
        <?php if (!empty($message)) { echo '<p class="message">' . $message . '</p>'; } ?>
        Nombre de usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit">Registrar</button>
        <a href="login.php">Iniciar sesión</a>
    </form>
</body>
</html>