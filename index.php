<?php
session_start();

// captura erro uma única vez
$erroLogin = false;
if (isset($_SESSION['login_erro'])) {
    $erroLogin = true;
    unset($_SESSION['login_erro']); // 🔥 LIMPA O ERRO
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>QR Restaurantes | Login</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        .erro-login {
            margin-top: 15px;
            color: #e60000;
            font-weight: 600;
            text-align: center;
            animation: piscar 0.9s ease-in-out infinite alternate;
        }

        @keyframes piscar {
            from { opacity: 1; }
            to   { opacity: 0.3; }
        }
    </style>
</head>
<body>

<header>
    <h1>QR RESTAURANTES</h1>
</header>

<div class="container">
    <h2>Login da Empresa</h2>

    <form action="api/login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>

        <?php if ($erroLogin): ?>
            <div class="erro-login">
                Usuário não encontrado
            </div>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
