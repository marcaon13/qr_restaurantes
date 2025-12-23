<?php
include 'api/db.php';
$token = $_GET['token'] ?? '';
$stmt = $conn->prepare('SELECT * FROM mesas WHERE token=?');
$stmt->bind_param('s',$token);
$stmt->execute();
$mesa = $stmt->get_result()->fetch_assoc();
if(!$mesa) die('Mesa inválida');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header><h1>Faça seu Pedido</h1></header>
        <div class="container">
        <form action="api/pedido.php" method="POST">
        <input name="nome" placeholder="Seu nome" required>
        <input type="hidden" name="mesa" value="<?php echo $mesa['numero_mesa']; ?>">
        <button>Enviar Pedido</button>
        </form>
        </div>
    </body>
</html>

<?php
include 'db.php';
$nome = trim($_POST['nome'] ?? '');
$mesa = intval($_POST['mesa'] ?? 0);


if(strlen($nome) < 2 || $mesa <= 0){
die('Pedido inválido');
}


$stmt = $conn->prepare('INSERT INTO pedidos (nome_cliente,mesa) VALUES (?,?)');
$stmt->bind_param('si',$nome,$mesa);
$stmt->execute();


echo 'Pedido enviado com sucesso';