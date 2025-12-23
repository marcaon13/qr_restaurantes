<?php
include 'db.php';
include 'auth.php';


$mesa = $_POST['mesa'];
$empresa = $_SESSION['empresa_id'];
$token = uniqid();


$conn->query("INSERT INTO mesas (empresa_id,numero_mesa,token) VALUES ($empresa,$mesa,'$token')");


echo "QR Code gerado:<br>";
echo "<img src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http://localhost/qr-restaurantes/pedido.php?token=$token'>";