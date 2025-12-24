<?php
session_start();
require_once 'db.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $conn->prepare("SELECT * FROM empresas WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($empresa = $result->fetch_assoc()) {

    if (password_verify($senha, $empresa['senha'])) {

        $_SESSION['empresa_id'] = $empresa['id'];
        $_SESSION['empresa_nome'] = $empresa['nome'];

        header("Location: ../dashboard.php");
        exit;
    }
}

// ❌ LOGIN INVÁLIDO → volta para o login com erro
header("Location: ../index.php?erro=1");
exit;
