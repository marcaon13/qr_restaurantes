<?php
require_once 'api/auth.php';
require_once 'api/db.php';

$empresa_id = $_SESSION['empresa_id'];

$sql = "SELECT * FROM produtos WHERE empresa_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Produtos</title>

<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/produtos.css">

<style>
/* BOTÃO EXCLUIR PREMIUM */
.btn-delete {
    margin-top: 14px;
    width: 100%;
    background: linear-gradient(135deg, #ff3b3b, #e60000);
    color: #fff;
    border: none;
    padding: 11px;
    border-radius: 14px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.3px;
    box-shadow: 0 8px 20px rgba(230, 0, 0, 0.35);
    transition: all 0.25s ease;
}

.btn-delete:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(230, 0, 0, 0.45);
    filter: brightness(1.05);
}

.btn-delete:active {
    transform: scale(0.96);
    box-shadow: 0 5px 12px rgba(230, 0, 0, 0.3);
}

/* GRID E CARD */
.produtos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.produto-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.2s;
}

.produto-card:hover {
    transform: translateY(-5px);
}

.produto-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

.produto-card .info {
    width: 100%;
    text-align: center;
}

.produto-card h3 {
    margin: 5px 0;
    font-size: 16px;
}

.produto-card p {
    font-size: 14px;
    color: #555;
    margin: 5px 0;
}

.produto-card span {
    font-weight: 600;
    color: #222;
}

.produtos-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #fff;
    border-bottom: 1px solid #eee;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.produtos-header {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-text h1 {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
    color: #222;
}

.header-text p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.btn-back {
    background: #f5f5f5;
    border: none;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 500;
    color: #333;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.btn-back:hover {
    background: #ffebeb;
    color: #e60000;
    transform: translateX(-2px);
}

.btn-add {
    background: linear-gradient(135deg, #ff3b3b, #e60000);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 6px 16px rgba(230,0,0,0.35);
}

.btn-add:hover {
    transform: translateY(-2px);
    filter: brightness(1.05);
    box-shadow: 0 10px 22px rgba(230,0,0,0.45);
}

.estoque {
  display: block;
  margin-top: 5px;
  font-size: 13px;
  color: #777;
}


</style>

<script>
function excluirProduto(id) {
    if (!confirm("Deseja realmente excluir este produto?")) return;

    fetch("api/excluir_produto.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.sucesso) {
            const card = document.getElementById("produto-" + id);
            if (card) card.remove();
        } else {
            alert(data.erro || "Erro ao excluir produto");
        }
    })
    .catch(() => alert("Erro de conexão"));
}

function abrirModal() {
    document.getElementById('modal').style.display = 'flex';
}

function fecharModal() {
    document.getElementById('modal').style.display = 'none';
}
</script>

</head>

<script>
function abrirModal() {
    const modal = document.getElementById('modal');
    modal.classList.add('show');
    console.log('Modal aberto');
}

function fecharModal() {
    const modal = document.getElementById('modal');
    modal.classList.remove('show');
}
</script>

<body>

<section class="produtos-page">
<div class="produtos-top">
    <div class="produtos-header">
    <button class="btn-back" type="button" onclick="window.location.href='dashboard.php'">← Voltar</button>
        <div class="header-text">
            <h1>Produtos</h1>
            <p>Seu cardápio digital</p>
        </div>
    </div>
    <!-- <button class="btn-add" onclick="abrirModal()">+ Novo Produto</button> -->
     <!-- <button type="button" class="btn-add" onclick="abrirModal()">+ Novo Produto</button> -->
      <a href="#" class="btn-add" onclick="abrirModal(); return false;">+ Novo Produto</a>


</div>


    <div class="produtos-grid">
        <?php while ($p = $result->fetch_assoc()): ?>
            <div class="produto-card" id="produto-<?= (int)$p['id'] ?>">
                <img src="uploads/<?= htmlspecialchars($p['imagem']) ?>" alt="">
                <div class="info">
                    <h3><?= htmlspecialchars($p['nome']) ?></h3>
                    <p><?= htmlspecialchars($p['descricao']) ?></p>
                    <span>R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>

                    <button class="btn-delete" onclick="excluirProduto(<?= (int)$p['id'] ?>)">
                        🗑️ Excluir
                    </button>
                </div>
                <small class="estoque">
                    Estoque: <?= (int)$p['estoque'] ?>
                </small>

            </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-box">
        <button class="modal-close" onclick="fecharModal()">✕</button>

        <h2>Novo Produto</h2>

        <form action="api/criar_produto.php" method="POST" enctype="multipart/form-data">
            <input name="nome" placeholder="Nome do produto" required>
            <input type="file" name="imagem" accept="image/jpeg, image/jpg, image/png"required>
            <input name="preco" type="number" step="0.01" placeholder="Preço" required>
            <input type="number" name="estoque" placeholder="Quantidade em estoque" min="0" required>
            <textarea name="descricao" placeholder="Descrição"></textarea>

            <div class="actions">
                <button type="submit">Salvar</button>
                <button type="button" onclick="fecharModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>


</body>
</html>
