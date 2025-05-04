<!-- Modal de Cadastro de Produto -->
<div class="modal-produto" id="modalProduto">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Novo Produto</h2>
            <button class="close-modal" onclick="closeModalProduto()">&times;</button>
        </div>
        
        <form class="modal-form" id="formProduto" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomeProduto">Nome do Produto</label>
                <input 
                    type="text" 
                    id="nomeProduto" 
                    name="nome" 
                    class="form-control" 
                    placeholder="Nome do produto"
                    required
                >
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="categoriaProduto">Categoria</label>
                    <select 
                        id="categoriaProduto" 
                        name="categoria" 
                        class="form-control"
                        required
                    >
                        <option value="">Selecione...</option>
                        <?php foreach($listaCategoria as $categoria): ?>
                            <option value="<?= $categoria['idCategoria'] ?>">
                                <?= $categoria['categoria'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group half">
                    <label for="precoProduto">Preço</label>
                    <input 
                        type="number" 
                        id="precoProduto" 
                        name="preco" 
                        class="form-control" 
                        step="0.01" 
                        min="0"
                        placeholder="0.00"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="descricaoProduto">Descrição</label>
                <textarea 
                    id="descricaoProduto" 
                    name="descricao" 
                    class="form-control" 
                    rows="3"
                    placeholder="Descrição do produto"
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="imagemProduto">Imagem</label>
                <input 
                    type="file" 
                    id="imagemProduto" 
                    name="imagem" 
                    class="form-control" 
                    accept="image/*"
                    required
                >
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalProduto()">
                    <i class='bx bx-x'></i>
                    Cancelar
                </button>
                <button type="submit" class="btn-save">
                    <i class='bx bx-check'></i>
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-produto {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 500px;
        margin: 50px auto;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .modal-form {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-group.half {
        flex: 1;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel, .btn-save {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-cancel {
        background: #eee;
        color: #666;
    }

    .btn-save {
        background: #ff7f00;
        color: white;
    }

    .btn-save:hover {
        background: #e67300;
    }
</style>

<script>
function openModalProduto() {
    document.getElementById('modalProduto').style.display = 'block';
}

function closeModalProduto() {
    document.getElementById('modalProduto').style.display = 'none';
    document.getElementById('formProduto').reset();
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('modalProduto');
    if (event.target == modal) {
        closeModalProduto();
    }
}
</script> 