<!-- Modal Base Structure -->
<div class="modal" id="modalCadastro">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Cadastrar <span class="modal-type">Produto</span></h2>
            <button class="close-modal">&times;</button>
        </div>
        
        <form class="modal-form" id="formCadastro" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <!-- Campos dinâmicos serão inseridos aqui -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    animation: fadeIn 0.3s ease;
}

.modal-content {
    position: relative;
    background: white;
    width: 90%;
    max-width: 500px;
    margin: 50px auto;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease;
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    color: #333;
    font-size: 1.5rem;
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

.form-grid {
    display: grid;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: 500;
    color: #555;
}

.form-control {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #ff7f00;
    outline: none;
}

.image-preview {
    width: 100%;
    height: 150px;
    border: 2px dashed #ddd;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    overflow: hidden;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #ff7f00;
    color: white;
}

.btn-primary:hover {
    background: #e67300;
}

.btn-secondary {
    background: #f0f0f0;
    color: #333;
}

.btn-secondary:hover {
    background: #e0e0e0;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
// Funções base para o modal
function openModal(type) {
    const modal = document.getElementById('modalCadastro');
    const modalType = modal.querySelector('.modal-type');
    const formGrid = modal.querySelector('.form-grid');
    
    modalType.textContent = type;
    formGrid.innerHTML = getFormFields(type);
    modal.style.display = 'block';
    
    setupImagePreview();
}

function closeModal() {
    document.getElementById('modalCadastro').style.display = 'none';
}

function getFormFields(type) {
    switch(type) {
        case 'Produto':
            return `
                <div class="form-group">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Preço</label>
                    <input type="number" name="preco" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria" class="form-control" required>
                        <!-- Opções serão preenchidas dinamicamente -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Imagem</label>
                    <div class="image-preview" id="imagePreview">
                        <span>Clique para selecionar uma imagem</span>
                    </div>
                    <input type="file" name="imagem" id="imageInput" accept="image/*" hidden>
                </div>
            `;
        
        case 'Categoria':
            return `
                <div class="form-group">
                    <label>Nome da Categoria</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"></textarea>
                </div>
            `;
        
        // Adicione outros casos conforme necessário
    }
}

function setupImagePreview() {
    const imagePreview = document.getElementById('imagePreview');
    const imageInput = document.getElementById('imageInput');
    
    if (imagePreview && imageInput) {
        imagePreview.onclick = () => imageInput.click();
        
        imageInput.onchange = (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        };
    }
}

// Fechar modal quando clicar fora
window.onclick = (event) => {
    const modal = document.getElementById('modalCadastro');
    if (event.target === modal) {
        closeModal();
    }
};
</script> 