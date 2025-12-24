<?php
session_start();

$erro = false;
if (isset($_GET['erro']) && $_GET['erro'] === '1') {
    $erro = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>QR Restaurantes | Login</title>

<link rel="stylesheet" href="css/style.css">

<style>
.erro {
    color: #e60000;
    margin-bottom: 15px;
    font-weight: 600;
    animation: piscar 0.8s infinite alternate;
}

@keyframes piscar {
    from { opacity: 1; }
    to { opacity: 0.4; }
}
</style>
</head>

<body>

<header>
    <h1>QR RESTAURANTES</h1>
</header>

<div class="container">
    <h2>Login da Empresa</h2>

    <?php if ($erro): ?>
        <div class="erro">Usuário não encontrado</div>
    <?php endif; ?>

    <form action="api/login.php" method="POST">
        <input name="email" type="email" placeholder="Email" required>
        <input name="senha" type="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>
