<?php include __DIR__ . '/layouts/header.php'; ?>

<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="/">
                <img src="/assets/img/logo.png" alt="OrderFüd">
            </a>
        </div>

        <div class="navbar-menu">
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/menu">Cardápio</a></li>
                <li><a href="/about">Sobre</a></li>
                <li><a href="/contact">Contato</a></li>
            </ul>
        </div>

        <!-- Adicionando ícones de usuário e carrinho -->
        <div class="navbar-actions">
            <!-- Ícone do Usuário com Dropdown -->
            <div class="user-dropdown">
                <button class="icon-btn" id="userDropdownBtn">
                    <i class='bx bx-user'></i>
                    <?php if (isset($_SESSION['user'])): ?>
                        <span class="user-name"><?= explode(' ', $_SESSION['user']['nome'])[0] ?></span>
                    <?php endif; ?>
                </button>
                
                <div class="dropdown-menu" id="userDropdown">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/client/dashboard">
                            <i class='bx bx-dashboard'></i>
                            Dashboard
                        </a>
                        <a href="/client/orders">
                            <i class='bx bx-package'></i>
                            Meus Pedidos
                        </a>
                        <a href="/client/profile">
                            <i class='bx bx-user-circle'></i>
                            Meu Perfil
                        </a>
                        <hr>
                        <a href="/logout" class="text-danger">
                            <i class='bx bx-log-out'></i>
                            Sair
                        </a>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#loginModal">
                            <i class='bx bx-log-in'></i>
                            Entrar
                        </a>
                        <a href="#" data-toggle="modal" data-target="#registerModal">
                            <i class='bx bx-user-plus'></i>
                            Cadastrar
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ícone do Carrinho com Badge -->
            <button class="icon-btn cart-toggle" id="cartBtn">
                <i class='bx bx-cart'></i>
                <span class="cart-count">0</span>
            </button>
        </div>

        <!-- Toggle Menu Mobile -->
        <button class="navbar-toggle">
            <i class='bx bx-menu'></i>
        </button>
    </div>
</nav>

<!-- Conteúdo da Página -->
<?= $content ?>

<!-- Carrinho Lateral -->
<div class="cart-container">
    <div class="cart-header">
        <h3>Seu Carrinho</h3>
        <button class="cart-close">
            <i class='bx bx-x'></i>
        </button>
    </div>
    
    <div class="cart-items">
        <!-- Items do carrinho serão inseridos via JavaScript -->
    </div>
    
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total:</span>
            <strong>0.00 Kz</strong>
        </div>
        <button class="btn btn-primary w-100" id="checkout-btn">
            Finalizar Pedido
        </button>
    </div>
</div>

<!-- Modal de Login -->
<div class="modal" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entrar</h5>
                <button class="modal-close" data-dismiss="modal">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="/login">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Registro -->
<div class="modal" id="registerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar</h5>
                <button class="modal-close" data-dismiss="modal">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="/register">
                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional -->
<style>
.navbar-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.icon-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    position: relative;
    color: var(--dark-color);
}

.icon-btn i {
    font-size: 1.5rem;
}

.cart-count {
    position: absolute;
    top: 0;
    right: 0;
    background: var(--primary-color);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 1rem;
    min-width: 1.5rem;
    text-align: center;
}

.user-dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 0.5rem;
    box-shadow: var(--shadow-md);
    min-width: 200px;
    padding: 0.5rem;
    display: none;
    z-index: 1000;
}

.dropdown-menu.active {
    display: block;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--dark-color);
    text-decoration: none;
    transition: background 0.3s ease;
}

.dropdown-menu a:hover {
    background: rgba(0,0,0,0.05);
}

.dropdown-menu i {
    margin-right: 0.75rem;
}

.dropdown-menu hr {
    margin: 0.5rem 0;
    border: none;
    border-top: 1px solid #eee;
}

.text-danger {
    color: var(--danger-color);
}

@media (max-width: 768px) {
    .navbar-actions {
        margin-left: auto;
    }
    
    .dropdown-menu {
        position: fixed;
        top: 60px;
        right: 1rem;
        left: 1rem;
    }
}
</style>

<!-- JavaScript Adicional -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Toggle do Dropdown do Usuário
    const userDropdownBtn = $('#userDropdownBtn');
    const userDropdown = $('#userDropdown');
    
    userDropdownBtn.addEventListener('click', () => {
        userDropdown.classList.toggle('active');
    });

    // Fecha o dropdown quando clicar fora
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.user-dropdown')) {
            userDropdown.classList.remove('active');
        }
    });

    // Validação dos formulários
    const validateForm = (form) => {
        let isValid = true;
        form.querySelectorAll('input[required]').forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('error');
                isValid = false;
            } else {
                input.classList.remove('error');
            }
        });
        return isValid;
    };

    // Login Form
    $('#loginForm').addEventListener('submit', (e) => {
        if (!validateForm(e.target)) {
            e.preventDefault();
            toast.show('Por favor, preencha todos os campos', 'error');
        }
    });

    // Register Form
    $('#registerForm').addEventListener('submit', (e) => {
        if (!validateForm(e.target)) {
            e.preventDefault();
            toast.show('Por favor, preencha todos os campos', 'error');
        }
    });
});
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?> 