<?php

$host = "localhost";
$user = "root";
$pass = ""; // padrão do XAMPP
$db   = "qr_restaurantes";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");
