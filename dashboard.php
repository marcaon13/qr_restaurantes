<?php
require_once 'api/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard | QR Restaurantes</title>

<link rel="stylesheet" href="css/dashboard.css">
<script defer src="js/dashboard.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h2><span>QR</span> Restaurantes</h2>

    <nav>
      <a href="dashboard.php" class="active">🏠 Dashboard</a>
      <a href="produtos.php">🍔 Produtos</a>
      <a href="qrcodes.php">🔳 QR Codes</a>
      <a href="pedidos.php">🧾 Pedidos</a>
      <a href="logout.php" class="logout">🚪 Sair</a>
    </nav>
  </aside>

  <!-- CONTEÚDO -->
  <main class="content">

    <header>
      <h1>Bem-vindo 👋</h1>
      <p>Gerencie seu restaurante com QR Codes</p>
    </header>

    <section class="cards">

      <div class="card red">
        <h3>Produtos</h3>
        <p>Gerencie seu cardápio</p>
        <a href="produtos.php">Acessar</a>
      </div>

      <div class="card yellow">
        <h3>QR Codes</h3>
        <p>Mesas e acessos</p>
        <a href="qrcodes.php">Acessar</a>
      </div>

      <div class="card dark">
        <h3>Pedidos</h3>
        <p>Pedidos em tempo real</p>
        <a href="pedidos.php">Acessar</a>
      </div>

    </section>

  </main>
</div>

</body>
</html>
