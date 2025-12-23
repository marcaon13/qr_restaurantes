<?php
include 'db.php';
include 'auth.php';


$nome = $_POST['nome'];
$preco = $_POST['preco'];
$empresa = $_SESSION['empresa_id'];


$stmt = $conn->prepare("INSERT INTO produtos (empresa_id,nome,preco) VALUES (?,?,?)");
$stmt->bind_param("isd", $empresa,$nome,$preco);
$stmt->execute();


header("Location: ../produtos.php");