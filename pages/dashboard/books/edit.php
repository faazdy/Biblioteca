<?php
session_start();
require "../../../config/config.php";

if (!isset($_SESSION["idUsuario"]) || $_SESSION["isAdmin"] != 1) {
    header("Location: ../../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$idLibro = $_GET['id'];

// hacer el update en sql
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreLibro = $_POST["nombreLibro"];
    $autor = $_POST["autor"];
    $genero = $_POST["genero"];

    $stmt = $conn->prepare("UPDATE Libros SET nombreLibro = ?, autor = ?, genero = ? WHERE idLibro = ?");
    $stmt->bind_param("sssi", $nombreLibro, $autor, $genero, $idLibro);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al actualizar el libro.";
    }

    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM Libros WHERE idLibro = ?");
$stmt->bind_param("i", $idLibro);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/crud.css">
    <link rel="stylesheet" href="../../../styles/main.css">
    <link rel="stylesheet" href="../../../styles/buttons.css">
    <title>Editar Libro</title>
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
            <h1>Editar libro</h1>
            <h3>Cambia los datos del libro.</h3>
            <hr>
            <section class="home-menu">
                <div class="container-crud">
                    <?php if (!empty($error)) : ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <label for="nombreLibro">Nombre del libro</label>
                        <input type="text" name="nombreLibro" value="<?php echo $book['nombreLibro']; ?>" required><br>
                        <label>Autor:</label>
        <input type="text" name="autor" value="<?php echo $book['autor']; ?>" required><br>

        <label>Género:</label>
        <input type="text" name="genero" value="<?php echo $book['genero']; ?>" required><br>
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
