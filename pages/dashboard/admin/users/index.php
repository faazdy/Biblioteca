<?php
require "../../../../config/config.php";
session_start();

if (!isset($_SESSION["idUsuario"])) {
    header("Location: ../../../../login.php");
    exit;
}

$query = "SELECT * FROM Usuarios";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../styles/main.css">
    <link rel="stylesheet" href="../../../../styles/buttons.css">
    <title>Lista de usuarios</title>
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="../../books/index.php">Gestión de libros</a></li>
                <li><a href="../../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
        <p>Bienvenido <span class="user"><?php echo $_SESSION["email"]; ?></span>, eres administrador.</p>
    </header>

    <section class="main-content">
        <aside>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../../books/index.php">Gestión de libros</a></li>
                <li><a href="../../books/mislibros.php?idUsuario=">Mis libros</a></li>
                <li><a href="../../../../logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>
        <main>
            <h1>Usuarios</h1>
            <h3>Ten el control sobre usuarios de la plataforma.</h3>
            <hr>
            <section class="home-menu">
                <article class="cards-container">
                    <div class="card">
                        <a href="create.php" class="btn primary">Agregar</a>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result as $user): ?>
                                <tr>
                                    <td><?= $user['idUsuario']; ?></td>
                                    <td><?= $user['email']; ?></td>
                                    <td><?= $user['isAdmin'] === 1 ? 'Admin': 'Usuario'; ?></td>
                                    <td>
                                        <a href="update.php?idUsuario=<?php echo $user['idUsuario']; ?>"
                                            class="btn primary">Editar</a>
                                        <a href="delete.php?idUsuario=<?php echo $user['idUsuario']; ?>"
                                            class="btn danger">Borrar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>
        </main>
    </section>

    <script src="../../../../styles/app.js"></script>
</body>

</html>