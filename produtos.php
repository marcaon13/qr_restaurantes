<?php
require_once __DIR__ . '/api/auth.php';
require_once __DIR__ . '/api/db.php';

$empresa_id = $_SESSION['empresa_id'];

$stmt = $conn->prepare("SELECT * FROM produtos WHERE empresa_id = ?");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Produtos | QR Restaurantes</title>

<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/produtos.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
/* ===== MODAL BASE ===== */
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal.show { display:flex; }

.modal-box {
    background:#fff;
    width:420px;
    padding:28px;
    border-radius:18px;
    animation:zoom .25s ease;
    position:relative;
}
@keyframes zoom {
    from { transform:scale(.92); opacity:0 }
    to { transform:scale(1); opacity:1 }
}

.modal-close {
    position:absolute;
    top:14px;
    right:16px;
    border:none;
    background:none;
    font-size:20px;
    cursor:pointer;
}

/* ===== FORM ===== */
.modal-box h2 {
    margin-bottom:18px;
}

.modal-box form {
    display:flex;
    flex-direction:column;
    gap:14px;
}

/* REMOVE TRACEJADO / LINHAS */
.modal-box input,
.modal-box textarea {
    width:100%;
    padding:12px 14px;
    border-radius:10px;
    border:1px solid #ddd;
    outline:none;
    font-size:14px;
    transition:.2s;
}

.modal-box input:focus,
.modal-box textarea:focus {
    border-color:#e60000;
    box-shadow:0 0 0 2px rgba(230,0,0,.1);
}

/* ===== UPLOAD ===== */
.upload-box {
    border:2px dashed #ccc;
    border-radius:14px;
    padding:20px;
    text-align:center;
    cursor:pointer;
    transition:.3s;
}
.upload-box:hover {
    border-color:#e60000;
    background:#fff5f5;
}
.upload-box input { display:none; }

.upload-icon { font-size:34px; }
.upload-text { font-size:14px; color:#666; }

.upload-preview {
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:12px;
    margin-top:12px;
    display:none;
}

/* ===== AÇÕES IMAGEM ===== */
.image-actions {
    display:none;
    gap:10px;
}
.image-actions button {
    flex:1;
    padding:8px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}
.btn-substituir {
    background:#eee;
}
.btn-excluir {
    background:#ff3b3b;
    color:#fff;
}

/* ===== AÇÕES FORM ===== */
.actions {
    display:flex;
    gap:10px;
    margin-top:10px;
}
.actions button {
    flex:1;
    padding:12px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-weight:600;
}
.actions button[type="submit"] {
    background:linear-gradient(135deg,#e60000,#ff4d4d);
    color:#fff;
}
.actions button[type="button"] {
    background:#eee;
}

/* ===== CONFIRM EXCLUSÃO ===== */
.modal-confirm-box {
    background:#fff;
    padding:25px;
    border-radius:16px;
    width:320px;
    text-align:center;
}
.modal-confirm-actions {
    display:flex;
    gap:10px;
    margin-top:20px;
}
.modal-confirm-actions button {
    flex:1;
    padding:10px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}
.btn-confirm {
    background:linear-gradient(135deg,#ff3b3b,#e60000);
    color:#fff;
}
.btn-cancel {
    background:#eee;
}
</style>
</head>

<body>

<div class="layout">

<aside class="sidebar">
  <h2><span>QR</span> Restaurantes</h2>
  <nav>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="produtos.php" class="active">🍔 Produtos</a>
    <a href="qrcodes.php">🔳 QR Codes</a>
    <a href="pedidos.php">🧾 Pedidos</a>
    <a href="logout.php" class="logout">🚪 Sair</a>
  </nav>
</aside>

<main class="content">

<section class="produtos-page">

<div class="produtos-top">
  <div style="display:flex;align-items:center;gap:10px;">
    <button class="btn-back" onclick="history.back()">←</button>
    <div>
      <h1>Produtos</h1>
      <p>Seu cardápio digital</p>
    </div>
  </div>
  <button class="btn-add" onclick="abrirModal()">+ Novo Produto</button>
</div>

<div class="produtos-grid">
<?php while ($p = $result->fetch_assoc()): ?>
  <div class="produto-card">
    <img src="uploads/<?= htmlspecialchars($p['imagem']) ?>">
    <div class="info">
      <h3><?= htmlspecialchars($p['nome']) ?></h3>
      <p><?= htmlspecialchars($p['descricao']) ?></p>
      <span>R$ <?= number_format($p['preco'],2,',','.') ?></span>
      <button class="btn-delete" onclick="confirmarExclusao(<?= (int)$p['id'] ?>)">🗑️ Excluir</button>
    </div>
  </div>
<?php endwhile; ?>
</div>

</section>
</main>
</div>

<!-- MODAL NOVO PRODUTO -->
<div class="modal" id="modalProduto">
<div class="modal-box">
<button class="modal-close" onclick="fecharModal()">✕</button>
<h2>Novo Produto</h2>

<form action="api/criar_produto.php" method="POST" enctype="multipart/form-data">

<!-- ✅ PRIMEIRO CAMPO -->
<input name="nome" placeholder="Nome do produto" required>

<label class="upload-box">
  <div id="uploadPlaceholder">
    <div class="upload-icon">⬆️</div>
    <div class="upload-text">Clique para enviar a imagem</div>
  </div>

  <img id="previewImagem" class="upload-preview">

  <input type="file" name="imagem" id="inputImagem"
         accept=".jpg,.jpeg,.png"
         required
         onchange="mostrarPreview(this)">
</label>

<div class="image-actions" id="imageActions">
  <button type="button" class="btn-substituir" onclick="substituirImagem()">Substituir</button>
  <button type="button" class="btn-excluir" onclick="removerImagem()">Excluir</button>
</div>

<input name="estoque" type="number" min="0" placeholder="Estoque disponível" required>
<input name="preco" type="number" step="0.01" placeholder="Preço" required>

<textarea name="descricao" rows="4" placeholder="Descrição" style="resize:none"></textarea>

<div class="actions">
  <button type="submit">Salvar</button>
  <button type="button" onclick="fecharModal()">Cancelar</button>
</div>

</form>
</div>
</div>

<!-- MODAL CONFIRMAR EXCLUSÃO -->
<div class="modal" id="modalConfirm">
<div class="modal-confirm-box">
<h3>Excluir produto?</h3>
<p>Essa ação não pode ser desfeita.</p>
<div class="modal-confirm-actions">
  <button class="btn-cancel" onclick="fecharConfirm()">Cancelar</button>
  <button class="btn-confirm" onclick="excluirProduto()">Excluir</button>
</div>
</div>
</div>

<script>
let produtoExcluir = null;

function abrirModal() {
  document.getElementById('modalProduto').classList.add('show');
}
function fecharModal() {
  document.getElementById('modalProduto').classList.remove('show');
  removerImagem();
}

function confirmarExclusao(id) {
  produtoExcluir = id;
  document.getElementById('modalConfirm').classList.add('show');
}
function fecharConfirm() {
  produtoExcluir = null;
  document.getElementById('modalConfirm').classList.remove('show');
}
function excluirProduto() {
  fetch('api/excluir_produto.php?id=' + produtoExcluir)
    .then(() => location.reload());
}

/* IMAGEM */
function mostrarPreview(input) {
  const file = input.files[0];
  if (!file) return;

  document.getElementById('previewImagem').src = URL.createObjectURL(file);
  document.getElementById('previewImagem').style.display = 'block';
  document.getElementById('uploadPlaceholder').style.display = 'none';
  document.getElementById('imageActions').style.display = 'flex';
}
function substituirImagem() {
  document.getElementById('inputImagem').click();
}
function removerImagem() {
  document.getElementById('inputImagem').value = '';
  document.getElementById('previewImagem').style.display = 'none';
  document.getElementById('uploadPlaceholder').style.display = 'block';
  document.getElementById('imageActions').style.display = 'none';
}
</script>

</body>
</html>
