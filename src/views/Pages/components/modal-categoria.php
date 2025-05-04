<!-- Modal de Cadastro de Categoria -->
<div class="modal-categoria" id="modalCategoria">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nova Categoria</h2>
            <button class="close-modal" onclick="closeModalCategoria()">&times;</button>
        </div>
        
        <form class="modal-form" id="formCategoria" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nomeCategoria">Nome da Categoria</label>
                <input 
                    type="text" 
                    id="nomeCategoria" 
                    name="categoria" 
                    class="form-control" 
                    placeholder="Ex: Bebidas, Lanches, Sobremesas..."
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
                        id="imagemCategoria" 
                        name="imagem" 
                        accept="image/*"
                        class="image-input"
                        required
                    >
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalCategoria()">
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
.modal-categoria {
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
    max-width: 500px;
    margin: 50px auto;
    border-radius: 10px;
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
    color: #333;
    font-size: 1.2rem;
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
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 2px solid #eee;
    border-radius: 8px;
    font-size: 14px;
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
    cursor: pointer;
    overflow: hidden;
    position: relative;
    background: #f8f8f8;
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
    font-size: 48px;
    color: #ff7f00;
    margin-bottom: 10px;
    display: block;
}

.image-input {
    display: none;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel, .btn-save {
    padding: 8px 16px;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagePreview = document.getElementById('imagePreview');
    const imageInput = document.getElementById('imagemCategoria');
    const previewImg = document.getElementById('previewImg');
    const uploadText = document.querySelector('.upload-text');
    const form = document.getElementById('formCategoria');

    // Configurar preview de imagem
    function setupImagePreview() {
        imagePreview.onclick = () => imageInput.click();

        imageInput.onchange = function(e) {
            const file = this.files[0];
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

    // Drag and drop
    imagePreview.addEventListener('dragover', (e) => {
        e.preventDefault();
        imagePreview.style.borderColor = '#ff7f00';
        imagePreview.style.backgroundColor = 'rgba(255, 127, 0, 0.1)';
    });

    imagePreview.addEventListener('dragleave', (e) => {
        e.preventDefault();
        imagePreview.style.borderColor = '#ddd';
        imagePreview.style.backgroundColor = '#f8f8f8';
    });

    imagePreview.addEventListener('drop', (e) => {
        e.preventDefault();
        imagePreview.style.borderColor = '#ddd';
        imagePreview.style.backgroundColor = '#f8f8f8';
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            imageInput.files = e.dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                uploadText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    // Validação e envio do formulário
    form.onsubmit = function(e) {
        e.preventDefault();
        
        const nomeCategoria = document.getElementById('nomeCategoria');
        
        if (!nomeCategoria.value.trim()) {
            nomeCategoria.classList.add('error');
            setTimeout(() => nomeCategoria.classList.remove('error'), 1000);
            return;
        }

        if (!imageInput.files[0]) {
            imagePreview.classList.add('error');
            setTimeout(() => imagePreview.classList.remove('error'), 1000);
            return;
        }

        // Se tudo estiver ok, envia o formulário
        this.submit();
    };

    setupImagePreview();
});

function openModalCategoria() {
    const modal = document.getElementById('modalCategoria');
    modal.style.display = 'block';
}

function closeModalCategoria() {
    const modal = document.getElementById('modalCategoria');
    modal.style.display = 'none';
    
    // Resetar o formulário
    document.getElementById('formCategoria').reset();
    document.getElementById('previewImg').style.display = 'none';
    document.querySelector('.upload-text').style.display = 'block';
}
</script> 