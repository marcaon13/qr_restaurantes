<?php
$conn = new mysqli("localhost", "root", "", "qr_restaurantes");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
