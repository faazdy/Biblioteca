<?php
session_start();
require_once "./config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $sql = "SELECT idUsuario, pass, isAdmin FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($pass, $user['pass'])) {
            $_SESSION["idUsuario"] = $user["idUsuario"];
            $_SESSION["isAdmin"] = $user["isAdmin"];
            $_SESSION["email"] = $email;
            if($_SESSION["isAdmin"] == 0){
                header("Location: pages/dashboard/user/index.php");
            } else {
                header("Location: pages/dashboard/admin/index.php");
            }
            exit;
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <title>Login</title>
</head>
<body>
    <main class="container">
    <h2>Login</h2>
    <hr>
    <form method="POST">
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="pass" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    <a href="pages/register/register.php">Registrarse</a>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </main>
</body>
</html>
