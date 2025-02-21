<?php
require_once '../../../config/config.php';
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php"); 
    exit();
}

$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
$idUsuario = $_SESSION['idUsuario']; 

$query = "SELECT b.idLibro, b.nombreLibro, b.autor, b.genero 
          FROM libros b
          JOIN prestamos p ON b.idLibro = p.idLibro
          WHERE p.idUsuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$booksResult = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Libros</title>
    <link rel="stylesheet" href="../../../styles/main.css">
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
                <li><a href="<?php echo $isAdmin ? '../admin/index.php': '../user/index.php' ?>">Home</a></li>
                <?php if($isAdmin): ?>
                <li><a href="../books/index.php">Gestión de libros</a></li>
                <?php endif; ?>
                <li class="stay-here"><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>,
            <?php echo $isAdmin ? 'eres administrador.' : 'eres usuario.'; ?>
        </p>
    </header>

    <section class="main-content">
        <aside>
            <ul>
                <li><a href="<?php echo $isAdmin ? '../admin/index.php': '../user/index.php' ?>">Home</a></li>
                <?php if($isAdmin): ?>
                <li><a href="../books/index.php">Gestión de libros</a></li>
                <?php endif; ?>
                <li class="stay-here"><a href="../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Mis Libros Solicitados</h1>
            <h3>Mira tus libros adquiridos.</h3>
            <hr>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del libro</th>
                            <th>Autor</th>
                            <th>Género</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($book = $booksResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $book['idLibro']; ?></td>
                            <td><?php echo $book['nombreLibro']; ?></td>
                            <td><?php echo $book['autor']; ?></td>
                            <td><?php echo $book['genero']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </section>

    <script src="../../../styles/app.js"></script>
</body>

</html>