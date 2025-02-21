<?php
session_start();
require "../../../config/config.php";

// Verifica que el usuario esté logueado
if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../../../login.php");
    exit;
}
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;

$books = $conn->prepare("SELECT * FROM Libros");
if (!$books) {
    die('Error al consultar libros');
}
$books->execute();
$booksResult = $books->get_result();
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo $_SESSION["email"]; ?></title>
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
            <?php if($isAdmin): ?>
            <ul>
                <li><a href="../admin/index.php">Home</a></li>
                <li class="stay-here"><a href="../books/index.php">Gestión de libros</a></li>
                <li><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
            <?php endif; ?>
            <?php if(!$isAdmin): ?>
            <ul>
                <li><a href="../user/index.php">Home</a></li>
                <li><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
            <?php endif; ?>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>,
            <?php echo $isAdmin ? 'eres administrador.' : 'eres usuario.'; ?>
        </p>
    </header>

    <section class="main-content">
        <aside>
            <?php if($isAdmin): ?>
            <ul>
                <li><a href="../admin/index.php">Home</a></li>
                <li class="stay-here"><a href="../books/index.php">Gestión de libros</a></li>
                <li><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
            <?php endif; ?>
            <?php if(!$isAdmin): ?>
            <ul>
                <li><a href="../user/index.php">Home</a></li>
                <li><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
            <?php endif; ?>
        </aside>
        <main>
            <h1>Biblioteca</h1>
            <h3>Solicita tus libros aqui.</h3>
            <hr>
            <section class="home-menu">
                <article class="cards-container">
                    <div class="card">
                        <h2>Libros disponibles</h2>
                        <hr>
                        <?php if($isAdmin): ?>
                        <a href="add.php" class="btn primary">Agregar libro</a>
                        <?php endif; ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del libro</th>
                                    <th>Autor</th>
                                    <th>Género</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($book = $booksResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $book['idLibro']; ?></td>
                                    <td><?php echo $book['nombreLibro']; ?></td>
                                    <td><?php echo $book['autor']; ?></td>
                                    <td><?php echo $book['genero']; ?></td>
                                    <td>
                                        <a href="solicitar.php?id=<?php echo $book['idLibro']; ?>"
                                            class="btn primary">Solicitar</a>
                                        <?php if ($isAdmin): ?>
                                        <a href="delete.php?id=<?php echo $book['idLibro']; ?>"
                                            class="btn danger">Borrar</a>
                                        <a href="edit.php?id=<?php echo $book['idLibro']; ?>"
                                            class="btn secondary">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
    </section>

    <script src="../../../styles/app.js"></script>
</body>

</html>