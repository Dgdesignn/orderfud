<!-- Modal de Cadastro de Categoria -->
<div class="modal-categoria" id="modalCategoria">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nova Categoria</h2>
            <button class="close-modal" onclick="closeModalCategoria()">&times;</button>
        </div>
        
        <form class="modal-form" id="formCategoria" method="POST" action="../controllers/processar_categoria.php">
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
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-categoria.active {
    opacity: 1;
}

.modal-content {
    position: relative;
    background: white;
    width: 90%;
    max-width: 400px;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.modal-categoria.active .modal-content {
    transform: translateY(0);
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
    font-weight: 600;
}

.close-modal {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    transition: color 0.3s ease;
}

.close-modal:hover {
    color: #ff7f00;
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
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #ff7f00;
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
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
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.btn-cancel {
    background: #f0f0f0;
    color: #666;
}

.btn-save {
    background: #ff7f00;
    color: white;
}

.btn-cancel:hover {
    background: #e0e0e0;
}

.btn-save:hover {
    background: #e67300;
}

/* Animação de shake para validação */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.form-control.error {
    border-color: #dc3545;
    animation: shake 0.3s ease-in-out;
}
</style>

<script>
function openModalCategoria() {
    const modal = document.getElementById('modalCategoria');
    modal.style.display = 'block';
    setTimeout(() => modal.classList.add('active'), 10);
}

function closeModalCategoria() {
    const modal = document.getElementById('modalCategoria');
    modal.classList.remove('active');
    setTimeout(() => modal.style.display = 'none', 300);
}

// Validação do formulário
document.getElementById('formCategoria').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nomeCategoria = document.getElementById('nomeCategoria');
    if (!nomeCategoria.value.trim()) {
        nomeCategoria.classList.add('error');
        setTimeout(() => nomeCategoria.classList.remove('error'), 1000);
        return;
    }
    
    // Se passou na validação, envia o formulário
    this.submit();
});

// Fechar modal ao clicar fora
document.getElementById('modalCategoria').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModalCategoria();
    }
});

// Remover classe de erro ao digitar
document.getElementById('nomeCategoria').addEventListener('input', function() {
    this.classList.remove('error');
});
</script> 