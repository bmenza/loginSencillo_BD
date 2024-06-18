<?php
// login.php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['contrasena'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['usuario'];
        echo "Inicio de sesión exitoso";
        // Redirigir al usuario a una página segura
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="post" action="login.php">
        <h2>Iniciar sesión</h2>
        <?php if (!empty($message)) { echo '<p class="message">' . $message . '</p>'; } ?>
        Nombre de usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit">Iniciar sesión</button>
        <a href="register.php">Registrarse</a>
    </form>
</body>
</html>