// ===== MODAL NOVO PRODUTO =====

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");

    // Fecha ao clicar fora
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            fecharModal();
        }
    });
});

function abrirModal() {
    const modal = document.getElementById("modal");
    modal.style.display = "flex";

    // força reflow para animação funcionar
    modal.offsetHeight;

    modal.classList.add("show");
}

function fecharModal() {
    const modal = document.getElementById("modal");
    modal.classList.remove("show");

    setTimeout(() => {
        modal.style.display = "none";
    }, 250);
}

// ===== EXCLUIR PRODUTO =====
function excluirProduto(id) {
    if (!confirm("Tem certeza que deseja excluir este produto?")) return;

    fetch(`api/excluir_produto.php?id=${id}`)
        .then(res => {
            if (res.ok) {
                document.getElementById(`produto-${id}`).remove();
            } else {
                alert("Erro ao excluir produto");
            }
        });
}
