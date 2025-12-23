<?php
include 'db.php';
if(!isset($_SESSION['empresa_id'])) exit;
$mesa = intval($_GET['mesa']);
$token = bin2hex(random_bytes(16));


$stmt = $conn->prepare('INSERT INTO mesas (empresa_id,numero_mesa,token) VALUES (?,?,?)');
$stmt->bind_param('iis',$_SESSION['empresa_id'],$mesa,$token);
$stmt->execute();


$link = "http://localhost/qr-restaurantes/pedido.php?token=$token";


echo "<h2>Mesa $mesa</h2>";
echo "<img src='https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=$link'>";