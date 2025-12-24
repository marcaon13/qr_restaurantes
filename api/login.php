<?php
session_start();
require_once __DIR__ . '/db.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $conn->prepare("SELECT * FROM empresas WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($empresa = $result->fetch_assoc()) {

    if (password_verify($senha, $empresa['senha'])) {
        $_SESSION['empresa_id']   = $empresa['id'];
        $_SESSION['empresa_nome'] = $empresa['nome'];

        header("Location: ../dashboard.php");
        exit;
    }
}

// ❌ LOGIN INVÁLIDO → cria erro temporário
$_SESSION['login_erro'] = true;

// volta para o login
header("Location: ../index.php");
exit;
