<?php
$host = "localhost:3307";
$user = "root"; 
$pass = ""; 
$dbname = "bibliotecaumd";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
