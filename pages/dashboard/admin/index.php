<?php
session_start();
if (!isset($_SESSION["idUsuario"]) || $_SESSION["isAdmin"] != 1) {
    header("Location: ../../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
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
                <li><a href="../books/index.php">Gestión de libros</a></li>
                <li><a href="../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>, eres administrador.</p>
    </header>
    <section class="main-content">
        <aside>
            <ul>
                <li class="stay-here"><a href="#">Home</a></li>
                <li><a href="../books/index.php">Gestión de libros</a></li>
                <li><a href="../books/mislibros.php?idUsuario=<?php echo $_SESSION['idUsuario']?>">Mis libros</a></li>
                <li><a href="../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Panel de Administrador</h1>
            <h3>Gestiona los libros y usuarios.</h3>
            <hr>
            <section class="home-menu">
                <article class="cards-container">
                    <a href="../books/index.php" class="card-btn">
                        <div class="card">
                            <img src="../../../styles/images/book.png" alt="book">
                            <h2>Administrar Libros</h2>
                        </div>
                    </a>
                    <a href="users/index.php" class="card-btn">
                        <div class="card">
                            <img src="../../../styles/images/icons8-user-100.png" alt="users">
                            <h2>Gestionar Usuarios</h2>
                        </div>
                    </a>
                </article>
            </section>
        </main>
    </section>

    <script src="../../../styles/app.js"></script>
</body>
</html>