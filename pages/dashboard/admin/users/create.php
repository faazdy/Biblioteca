<?php
session_start();
require "../../../../config/config.php";
if(!isset($_SESSION["idUsuario"]) || $_SESSION['isAdmin'] != 1){
    header('Location: ../../../../login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $isAdmin = isset($_POST["isAdmin"]) ? 1 : 0;

    $check_sql = "SELECT COUNT(*) as total FROM Usuarios WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    if ($check_stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $check_stmt->bind_param('s', $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['total'] > 0) {
        $error = "Ya existe un usuario con el email '$email'.";
    } else {
        $sql = "INSERT INTO Usuarios (email, pass, isAdmin) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }
        $stmt->bind_param('ssi', $email,  $pass, $isAdmin);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "<div class='error'>Error al insertar el usuario: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    $check_stmt->close();
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
            <h1>Crear nuevo usuario</h1>
            <h3>Agrega nuevos usuarios.</h3>
            <hr>
            <section class="home-menu">
                <div class="container-crud">
                    <form method="POST">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Correo" required>
                        <label for="email">Contraseña</label>
                        <input type="password" name="pass" placeholder="Contraseña" required>
                        <hr>
                        <label><input type="checkbox" name="isAdmin">Es administrador</label>
                        <hr>
                        <div class="btns-form">
                            <button type="submit" class="btn primary">Añadir</button>
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