<!-- Modal de Cadastro de Produto -->
<div class="modal-categoria" id="modalProduto">
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
                    placeholder="Ex: X-Burger, Coca-Cola..."
                    required
                >
            </div>

            <div class="form-row">
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

                <div class="form-group half">
                    <label for="categoriaProduto">Categoria</label>
                    <select 
                        id="categoriaProduto" 
                        name="categoria" 
                        class="form-control"
                        required
                    >
                        <option value="">Selecione uma categoria</option>
                        <?php
                        // Buscar categorias do banco
                        $categorias = $category->buscarCategoria();
                        foreach($categorias as $categoria) {
                            echo "<option value='{$categoria['idCategoria']}'>{$categoria['categoria']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="descricaoProduto">Descrição</label>
                <textarea 
                    id="descricaoProduto" 
                    name="descricao" 
                    class="form-control" 
                    placeholder="Descreva o produto..."
                    rows="3"
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="imagemProduto">Imagem do Produto</label>
                <div class="image-upload-container">
                    <div class="image-preview" id="imagePreview">
                        <img src="" alt="Preview" id="previewImg" style="display: none;">
                        <div class="upload-text">
                            <i class='bx bx-image-add'></i>
                            <span>Clique ou arraste uma imagem</span>
                        </div>
                    </div>
                    <input 
                        type="file" 
                        id="imagemProduto" 
                        name="imagem" 
                        accept="image/*"
                        class="image-input"
                        required
                    >
                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagePreview = document.getElementById('imagePreview');
    const imageInput = document.getElementById('imagemProduto');
    const previewImg = document.getElementById('previewImg');
    const uploadText = document.querySelector('.upload-text');
    const form = document.getElementById('formProduto');

    // Preview da imagem
    if (imageInput) {
        imageInput.onchange = function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    uploadText.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        };
    }

    // Formatação do campo de preço
    const precoInput = document.getElementById('precoProduto');
    precoInput.addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.replace(/[^0-9.]/g, '');
        if (value.includes('.')) {
            const parts = value.split('.');
            if (parts[1].length > 2) {
                parts[1] = parts[1].substring(0, 2);
                value = parts.join('.');
            }
        }
        e.target.value = value;
    });
});

function openModalProduto() {
    const modal = document.getElementById('modalProduto');
    modal.style.display = 'block';
}

function closeModalProduto() {
    const modal = document.getElementById('modalProduto');
    modal.style.display = 'none';
    document.getElementById('formProduto').reset();
    document.getElementById('previewImg').style.display = 'none';
    document.querySelector('.upload-text').style.display = 'block';
}

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const modal = document.getElementById('modalProduto');
    if (event.target == modal) {
        closeModalProduto();
    }
}
</script>

<style>
/* Seus estilos existentes */
.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.form-group.half {
    flex: 1;
    margin-bottom: 0;
}

.image-upload-container {
    width: 100%;
}

.image-preview {
    width: 100%;
    height: 200px;
    border: 2px dashed #ddd;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    cursor: pointer;
    overflow: hidden;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.upload-text {
    text-align: center;
}

.upload-text i {
    font-size: 48px;
    color: #ff7f00;
    margin-bottom: 10px;
}

.image-input {
    display: none;
}
</style> 