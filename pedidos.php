<?php
// Página do cliente via QR
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Cliente</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Página do Cliente</h1>
</body>
</html>

<?php
include 'api/db.php';
$token = $_GET['token'];
$mesa = $conn->query("SELECT * FROM mesas WHERE token='$token'")->fetch_assoc();
$empresa = $mesa['empresa_id'];
$produtos = $conn->query("SELECT * FROM produtos WHERE empresa_id=$empresa");
?>
<h2>Faça seu pedido</h2>
<form action="api/salvar_pedido.php" method="POST">
<input name="cliente" placeholder="Seu nome" required>
<input type="hidden" name="mesa" value="<?=$mesa['numero_mesa']?>">
<input type="hidden" name="empresa" value="<?=$empresa?>">
<select name="produto">
    <?php while($p=$produtos->fetch_assoc()){ ?>
        <option value="<?=$p['nome']?>"><?=$p['nome']?> - R$ <?=$p['preco']?></option>
    <?php } ?>
</select>
<button>Enviar pedido</button>
</form>

<?php
include 'api/db.php';
include 'api/auth.php';
$empresa = $_SESSION['empresa_id'];
$res = $conn->query("SELECT * FROM pedidos WHERE empresa_id=$empresa ORDER BY id DESC");
?>
<h2>Pedidos</h2>
<?php while($p=$res->fetch_assoc()){ ?>
<p>Mesa <?=$p['mesa']?> | <?=$p['nome_cliente']?></p>
<?php } ?>