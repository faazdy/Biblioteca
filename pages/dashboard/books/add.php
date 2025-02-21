<?php 
require "../../../config/config.php";
session_start();

if (!isset($_SESSION["idUsuario"]) || $_SESSION["isAdmin"] != 1) {
    header("Location: ../../../login.php");
    exit;
}

$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombreLibro']);
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];

    $check_sql = "SELECT COUNT(*) as total FROM Libros WHERE nombreLibro = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('s', $nombre);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['total'] > 0) {
        $error = "Ya existe un libro con el nombre '$nombre'.";
    } else {
        $sql = "INSERT INTO Libros (nombreLibro, genero, autor) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $nombre, $genero, $autor);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al insertar el libro: " . $stmt->error;
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
    <title>Agregar Libro</title>
    <link rel="stylesheet" href="../../../styles/crud.css">
    <link rel="stylesheet" href="../../../styles/main.css">
    <link rel="stylesheet" href="../../../styles/buttons.css">
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
                <li><a href="../admin/index.php">Home</a></li>
                <li><a href="index.php">Gestión de libros</a></li>
                <li><a href="mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>, eres administrador.</p>
    </header>
    <section class="main-content">
        <aside>
            <ul>
            <li><a href="../admin/index.php">Home</a></li>
                <li><a href="index.php">Gestión de libros</a></li>
                <li><a href="mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Agregar Libro</h1>
            <h3>Ingrese los datos del libro a registrar.</h3>
            <hr>
            <section class="home-menu">
                <div class="container-crud">
                    <?php if (!empty($error)) : ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <label for="nombreLibro">Nombre del libro</label>
                        <input type="text" name="nombreLibro" required>
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" required>
                        <label for="genero">Género</label>
                        <input type="text" name="genero" required>
                        <hr>
                        <div class="btns-form">
                            <button type="submit" class="btn primary">Agregar</button>
                            <a href="index.php" class="btn secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </section>
    <script src="../../../styles/app.js"></script>
</body>
</html>