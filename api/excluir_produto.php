<?php
require_once 'auth.php';
require_once 'db.php';

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'ID não enviado']);
    exit;
}

$produto_id = intval($_POST['id']);
$empresa_id = $_SESSION['empresa_id'];

$sql = "DELETE FROM produtos WHERE id = ? AND empresa_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $produto_id, $empresa_id);

if ($stmt->execute()) {
    echo json_encode(['sucesso' => true]);
} else {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao excluir']);
}
