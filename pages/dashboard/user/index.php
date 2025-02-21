<?php
session_start();
require "../../../config/config.php";

if (!isset($_SESSION["idUsuario"]) || $_SESSION["isAdmin"] != 0) {
    header("Location: ../../../login.php");
    exit;
}

$books = $conn->prepare("SELECT b.idLibro, b.nombreLibro, b.autor, b.genero 
          FROM libros b
          JOIN prestamos p ON b.idLibro = p.idLibro
          WHERE p.idUsuario = ?");
if(!$books){
    echo 'Error al consultar libros';
}
$books->bind_param('s', $_SESSION['idUsuario']);
$books->execute();
$booksResult = $books->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Usuario</title>
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
                <li class="stay-here"><a href="#">Home</a></li>
                <li><a href="../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span> eres usuario.</p>
    </header>
    <section class="main-content">
        <aside>
            <ul>
                <li class="stay-here"><a href="#">Home</a></li>
                <li><a href="../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Dashboard</h1>
            <h3>Solicita libros, o mira los que has adquirido.</h3>
            <hr>
            <section class="home-menu">
                <article class="cards-container">

                    <a href="../books/index.php" class="card-btn">
                        <div class="card">
                            <img src="../../../styles/images/book.png" alt="book">
                            <h2>Solicitar libros</h2>
                        </div>
                    </a>
                    <div class="card">
                        <h2>Libros adquiridos</h2>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del libro</th>
                                    <th>Autor</th>
                                    <th>Genero</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($booksResult as $book): ?>
                                <tr>
                                    <td><?php echo $book['idLibro'] ?></td>
                                    <td><?php echo $book['nombreLibro'] ?></td>
                                    <td><?php echo $book['autor'] ?></td>
                                    <td><?php echo $book['genero'] ?></td>
                                </tr>
                                <?php endforeach; ?>
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