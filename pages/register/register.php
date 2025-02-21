<?php
require_once "../../config/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $isAdmin = 0;

    // verificar si el correo existe
    $check_sql = "SELECT COUNT(*) as total FROM Usuarios WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['total'] > 0) {
        $error = "El correo ya está registrado.";
    } else {
        // insert
        $sql = "INSERT INTO Usuarios (email, pass, isAdmin) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $pass, $isAdmin);

        if ($stmt->execute()) {
            header("Location: ../../login.php");
            exit();
        } else {
            $error = "Error al registrar.";
        }
        $stmt->close();
    }

    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../styles/login.css">
    <link rel="stylesheet" href="../../styles/buttons.css">
</head>
<body>
    <div class="container">
        <h2>Registro</h2>
        <hr>
        <?php if (!empty($error)) : ?>
            <div class="error"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Correo" value="<?= htmlspecialchars($email ?? '') ?>" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <a href="../../login.php" class="btn secondary">Cancelar</a>
    </div>
</body>
</html>