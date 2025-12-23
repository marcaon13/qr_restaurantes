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
    const modal = document.getElementById('modal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}
// function abrirModal() {
//     alert("CLIQUE FUNCIONOU");
//     const modal = document.getElementById('modal');
//     modal.style.display = 'flex';
//     setTimeout(() => modal.classList.add('show'), 10);
// }


function fecharModal() {
    const modal = document.getElementById('modal');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 250);
}


