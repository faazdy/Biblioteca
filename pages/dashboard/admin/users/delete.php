<?php
session_start();
require "../../../../config/config.php";

if(!isset($_SESSION["idUsuario"]) || $_SESSION['isAdmin'] != 1){
    header('Location: ../../../../login.php');
    exit();
}

if(isset($_GET['idUsuario'])){
    $idUsuario = $_GET['idUsuario'];

    $stmt = $conn->prepare("DELETE FROM Usuarios WHERE idUsuario = ?");
    $stmt->bind_param("i", $idUsuario);

    if($stmt->execute()){
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar usuario.";
    }

    $stmt->close();
} else {
    echo "ID NO VALIDO";
}

$conn->close();
?>