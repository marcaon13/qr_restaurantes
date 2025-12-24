<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit;
}

$produto_id = (int) $_GET['id'];
$empresa_id = $_SESSION['empresa_id'];

/*
  Primeiro pegamos a imagem
  para apagar o arquivo físico depois
*/
$stmt = $conn->prepare(
    "SELECT imagem FROM produtos 
     WHERE id = ? AND empresa_id = ?"
);
$stmt->bind_param("ii", $produto_id, $empresa_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$produto = $result->fetch_assoc()) {
    http_response_code(404);
    exit;
}

/* Apaga do banco */
$stmt = $conn->prepare(
    "DELETE FROM produtos 
     WHERE id = ? AND empresa_id = ?"
);
$stmt->bind_param("ii", $produto_id, $empresa_id);
$stmt->execute();

/* Apaga a imagem do servidor */
$imagem = __DIR__ . '/../uploads/' . $produto['imagem'];
if (file_exists($imagem)) {
    unlink($imagem);
}

http_response_code(200);
exit;
