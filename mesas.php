<?php
include 'api/db.php';
include 'api/auth.php';
?>
<h2>Gerar QR Code</h2>
<form action="api/salvar_mesa.php" method="POST">
    <input name="mesa" placeholder="Número da mesa" required>
    <button>Gerar QR Code</button>
</form>