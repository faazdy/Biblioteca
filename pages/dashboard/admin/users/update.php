<?php
session_start();
require "../../../../config/config.php";

if (!isset($_SESSION["idUsuario"]) || $_SESSION['isAdmin'] != 1) {
    header('Location: ../../../../login.php');
    exit();
}

if (!isset($_GET['idUsuario'])) {
    die("Error: Usuario no especificado.");
}

$idUsuario = $_GET['idUsuario'];
$error = "";

$sql = "SELECT email, isAdmin FROM Usuarios WHERE idUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Usuario no encontrado.");
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $isAdmin = isset($_POST["isAdmin"]) ? 1 : 0;
    
    // contraseña
    if (!empty($_POST['pass'])) {
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $update_sql = "UPDATE Usuarios SET email = ?, pass = ?, isAdmin = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('ssii', $email, $pass, $isAdmin, $idUsuario);
    } else {
        $update_sql = "UPDATE Usuarios SET email = ?, isAdmin = ? WHERE idUsuario = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('sii', $email, $isAdmin, $idUsuario);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario nuevo</title>
    <link rel="stylesheet" href="../../../../styles/crud.css">
    <link rel="stylesheet" href="../../../../styles/main.css">
    <link rel="stylesheet" href="../../../../styles/buttons.css">
</head>

<body>
    <header>
        <label class="burger" for="burger">
            <input type="checkbox" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <nav class="menu-burger">
            <ul>
                <li>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span></li>
                <li ><a href="../index.php">Home</a></li>
                <li><a href="../../books/index.php">Gestión de libros</a></li>
                <li><a href="../../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>, eres administrador.</p>
    </header>
    <section class="main-content">
        <aside>
            <ul>
            <li ><a href="../index.php">Home</a></li>
                <li><a href="../../books/index.php">Gestión de libros</a></li>
                <li><a href="../../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Actualizar usuario</h1>
            <h3>Edita la información del usuario.</h3>
            <hr>
            <section class="home-menu">
                <div class="container-crud">
                    <form method="POST">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        <label for="email">Contraseña</label>
                        <input type="password" name="pass" placeholder="Nueva contraseña (opcional)">
                        <hr>
                        <label>
                            <input type="checkbox" name="isAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>> Es administrador
                        </label>
                        <hr>
                        <div class="btns-form">
                            <button type="submit" class="btn primary">Actualizar</button>
                            <a href="index.php" class="btn secondary">Cancelar</a>
                        </div>
                    </form>
                    
                    <?php if (!empty($error)) : ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </section>
    
    <script src="../../../../styles/app.js"></script>
</body>

</html>

