<?php
require_once 'api/db.php';

$empresa_id = $_GET['empresa'];
$mesa = $_GET['mesa'];

$produtos = $pdo->prepare("SELECT * FROM produtos WHERE empresa_id = ?");
$produtos->execute([$empresa_id]);
?>

<h1>Cardápio – Mesa <?= $mesa ?></h1>

<?php foreach ($produtos as $p): ?>
  <div>
    <img src="uploads/<?= $p['imagem'] ?>" width="150">
    <h3><?= $p['nome'] ?></h3>
    <p><?= $p['descricao'] ?></p>
    <strong>R$ <?= $p['preco'] ?></strong>
    <button>Adicionar</button>
  </div>
<?php endforeach ?>
