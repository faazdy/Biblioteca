<?php
session_start();
require "../../../config/config.php";

// Verifica si el usuario es admin
if (!isset($_SESSION["idUsuario"]) || $_SESSION["isAdmin"] != 1) {
    header("Location: ../../../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $idLibro = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM Libros WHERE idLibro = ?");
    $stmt->bind_param("i", $idLibro);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=Libro eliminado correctamente");
        exit;
    } else {
        echo "Error al eliminar el libro.";
    }

    $stmt->close();
} else {
    echo "ID de libro no válido.";
}

$conn->close();
?>
