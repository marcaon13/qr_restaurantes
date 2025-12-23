<?php
require_once 'auth.php';
require_once 'db.php';

$empresa_id = $_SESSION['empresa_id'];

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = floatval($_POST['preco']);
$estoque = intval($_POST['estoque']);

/* IMAGEM */
$imagem = $_FILES['imagem'];

$ext = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
$permitidas = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $permitidas)) {
    die('Formato inválido');
}

$nomeImagem = uniqid() . '.' . $ext;
$caminho = __DIR__ . '/../uploads/' . $nomeImagem;

if (!move_uploaded_file($imagem['tmp_name'], $caminho)) {
    die('Erro ao salvar imagem');
}

/* SALVA NO BANCO (SÓ O NOME) */
$sql = "INSERT INTO produtos 
(nome, descricao, preco, estoque, imagem, empresa_id)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssdisi",
    $nome,
    $descricao,
    $preco,
    $estoque,
    $nomeImagem,
    $empresa_id
);

$stmt->execute();

header("Location: ../produtos.php");
exit;
