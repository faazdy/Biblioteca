<?php
session_start();
require_once '../../../config/config.php';
if (!isset($_SESSION["email"])) {
    header("Location: login.php"); 
    exit();
}

$idUsuario = $_SESSION['idUsuario']; 
$idLibro = $_GET['id']; 

// Conexión a la base de datos


// Registrar el préstamo en la tabla 'Prestamos'
$query = "INSERT INTO Prestamos (idLibro, idUsuario) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $idLibro, $idUsuario);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: mislibros.php"); // Redirigir a la página de mis libros
} else {
    echo "Hubo un error al solicitar el libro. Intenta nuevamente.";
}

$stmt->close();
$conn->close();
?>
