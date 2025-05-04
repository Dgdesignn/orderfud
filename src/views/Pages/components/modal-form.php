<!-- Modal Reutilizável -->
<div class="modal-form-container" id="modalForm">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Novo Item</h2>
            <button class="close-modal" onclick="closeFormModal()">&times;</button>
        </div>
        
        <form class="modal-form" id="formDinamico" method="POST" action="" enctype="multipart/form-data">
            <div id="formFields">
                <!-- Campos dinâmicos serão inseridos aqui -->
            </div>

            <div class="modal-footer" >
                <button type="button" class="btn-cancel" onclick="closeFormModal()">
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
    .modal-form-container {
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
        position: relative;
        background: white;
        width: 90%;
        max-width: 450px;
        margin: 30px auto;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        color: #333;
        font-size: 1.1rem;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .modal-form {
        padding: 16px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        margin-bottom: 4px;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 8px;
        font-size: 0.9rem;
    }

    textarea.form-control {
        min-height: 60px;
        max-height: 120px;
    }

    .image-upload-container {
        width: 100%;
    }

    .image-preview {
        width: 100%;
        height: 150px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .upload-text {
        text-align: center;
        color: #666;
    }

    .upload-text i {
        font-size: 32px;
        color: #ff7f00;
        margin-bottom: 6px;
        display: block;
    }

    .upload-text span {
        font-size: 0.85rem;
    }

    .modal-footer {
        padding: 12px 16px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel, .btn-save {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-cancel {
        background: #f0f0f0;
        color: #666;
    }

    .btn-save {
        background: #ff7f00;
        color: white;
    }

    .error {
        border-color: #dc3545 !important;
        animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Ajuste para o layout em duas colunas */
    .form-row {
        gap: 12px;
        margin-bottom: 12px;
    }

    /* Ajuste para o select de categorias */
    select.form-control {
        padding-right: 28px;
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
        gap: 30px;
    }

    .step {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-weight: 500;
        position: relative;
    }

    .step::after {
        content: '';
        position: absolute;
        width: 30px;
        height: 2px;
        background: #eee;
        right: -30px;
        top: 50%;
        transform: translateY(-50%);
    }

    .step:last-child::after {
        display: none;
    }

    .step.active {
        background: #ff7f00;
        color: white;
    }

    .step.active::after {
        background: #ff7f00;
    }

    .step-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        gap: 10px;
    }

    .btn-prev, .btn-next {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-next {
        background: #ff7f00;
        color: white;
        margin-left: auto;
    }

    .btn-prev {
        background: #f0f0f0;
        color: #666;
    }

    .btn-next:hover {
        background: #e67300;
    }

    .btn-prev:hover {
        background: #e0e0e0;
    }
</style>

<script>
const modalConfig = {
    categoria: {
        title: 'Nova Categoria',
        fields: `
            <div class="form-group">
                <label for="nomeCategoria">Nome da Categoria</label>
                <input 
                    type="text" 
                    id="nomeCategoria" 
                    name="categoria" 
                    class="form-control" 
                    placeholder="Ex: Bebidas, Lanches..."
                    required
                >
            </div>
            <div class="form-group">
                <label for="imagemCategoria">Imagem da Categoria</label>
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
                        id="imagemUpload" 
                        name="imagem" 
                        accept="image/*"
                        class="image-input"
                        required
                    >
                </div>
            </div>
        `
    },
    produto: {
        title: 'Novo Produto',
        fields: {
            step1: `
                <div class="step-indicator">
                    <span class="step active">1</span>
                    <span class="step">2</span>
                </div>
                <div class="form-row">
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
                            <?php 
                            $categorias = $category->buscarCategoria();
                            foreach($categorias as $categoria) {
                                echo "<option value='{$categoria['idCategoria']}'>{$categoria['categoria']}</option>";
                            }
                            ?>
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
                <div class="step-buttons">
                    <button type="button" class="btn-next" onclick="nextStep()">
                        Próximo <i class='bx bx-right-arrow-alt'></i>
                    </button>
                </div>
            `,
            step2: `
                <div class="step-indicator">
                    <span class="step">1</span>
                    <span class="step active">2</span>
                </div>
                <div class="form-group">
                    <label for="descricaoProduto">Descrição</label>
                    <textarea 
                        id="descricaoProduto" 
                        name="descricao" 
                        class="form-control" 
                        rows="3"
                        placeholder="Descreva o produto..."
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
                            id="imagemUpload" 
                            name="imagem" 
                            accept="image/*"
                            class="image-input"
                            required
                        >
                    </div>
                </div>
                <div class="step-buttons">
                    <button type="button" class="btn-prev" onclick="prevStep()">
                        <i class='bx bx-left-arrow-alt'></i> Voltar
                    </button>
                    <button type="submit" class="btn-save">
                        <i class='bx bx-check'></i> Finalizar
                    </button>
                </div>
            `
        }
    }
};

function getCategorias() {
    // Esta função deve retornar as opções de categoria do PHP
    return `<?php 
        $categorias = $category->buscarCategoria();
        foreach($categorias as $categoria) {
            echo "<option value='{$categoria['idCategoria']}'>{$categoria['categoria']}</option>";
        }
    ?>`;
}

function openFormModal(type) {
    
    const modal = document.getElementById('modalForm');
    const config = modalConfig[type];
    
    if (!modal || !config) {
        console.error('Modal ou configuração não encontrada:', {modal, config});
        return;
    }
    
    document.getElementById('modalTitle').textContent = config.title;
    
    if (type === 'produto') {
        // Configura o formulário para produtos
        const form = document.getElementById('formDinamico');
        form.action = 'produto.php'; // Envia para a própria página
        form.innerHTML = `
            <div id="formFields">
                ${config.fields.step1}
            </div>
            <div id="hiddenFields" style="display:none;">
                <textarea name="descricao" id="hiddenDescricao"></textarea>
                <input type="file" name="imagem" id="hiddenImagem">
            </div>
        `;
        document.querySelector('.modal-footer').style.display = 'none';
    } else {
        document.getElementById('formFields').innerHTML = config.fields;
        document.querySelector('.modal-footer').style.display = 'flex';
    }
    
    document.getElementById('formDinamico').setAttribute('data-type', type);
    setupImagePreview();
    modal.style.display = 'block';
}

function nextStep() {
    const form = document.getElementById('formDinamico');
    
    // Valida campos da primeira etapa
    if (!form.nome.value || !form.categoria.value || !form.preco.value) {
        alert('Por favor, preencha todos os campos');
        return;
    }

    // Mostra segunda etapa
    document.getElementById('formFields').innerHTML = modalConfig.produto.fields.step2;
    setupImagePreview();

    // Configura o envio do formulário
    const descricaoInput = document.getElementById('descricaoProduto');
    const imagemInput = document.getElementById('imagemUpload');
    
    if (descricaoInput && imagemInput) {
        descricaoInput.form.onsubmit = function(e) {
            e.preventDefault();
            document.getElementById('hiddenDescricao').value = descricaoInput.value;
            document.getElementById('hiddenImagem').files = imagemInput.files;
            this.submit();
        };
    }
}

function prevStep() {
    const config = modalConfig.produto;
    const formFields = document.getElementById('formFields');
    formFields.innerHTML = config.fields.step1;
    
    // Restaura valores da primeira etapa
    const form = document.getElementById('formDinamico');
    const nome = form.querySelector('[name="nome"]');
    const categoria = form.querySelector('[name="categoria"]');
    const preco = form.querySelector('[name="preco"]');
    
    if (nome && categoria && preco) {
        nome.value = form.nome.value || '';
        categoria.value = form.categoria.value || '';
        preco.value = form.preco.value || '';
    }
}

function setupImagePreview() {
    const imagePreview = document.getElementById('imagePreview');
    const imageInput = document.getElementById('imagemUpload');
    const previewImg = document.getElementById('previewImg');
    const uploadText = document.querySelector('.upload-text');

    if (imagePreview && imageInput) {
        imagePreview.onclick = () => imageInput.click();
        
        imageInput.onchange = (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    uploadText.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        };
    }
}

function closeFormModal() {
    const modal = document.getElementById('modalForm');
    modal.style.display = 'none';
}

// Fechar modal ao clicar fora
window.onclick = (event) => {
    const modal = document.getElementById('modalForm');
    if (event.target === modal) {
        closeFormModal();
    }
};
</script> 