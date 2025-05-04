<?php

    $tipoUsuario = $_SESSION["user"]["tipo"];

// Pegar a rota atual
$rotaAtual = isset($_GET['rota']) ? $_GET['rota'] : 'home';

?>
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-school'></i>
		<span class="text">OrderFüd</span>
	</a>
	<ul class="side-menu top">
		<?php if($tipoUsuario == "administrador"): ?>
			<li class="<?= $rotaAtual == 'home' ? 'active' : '' ?>">
				<a href="?rota=home">
					<i class='bx bxs-home-smile'></i>
					<span class="text">Home</span>
				</a>
			</li>
		<?php endif; ?>
		
		<li class="<?= $rotaAtual == 'categoria' ? 'active' : '' ?>">
			<a href="?rota=categoria">
				<i class='bx bxs-category'></i>
				<span class="text">Categorias</span>
			</a>
		</li>
		
		<li class="<?= $rotaAtual == 'produto' ? 'active' : '' ?>">
			<a href="?rota=produto">
				<i class='bx bxs-credit-card'></i>
				<span class="text">Produto</span>
			</a>
		</li>
		
		<?php if($tipoUsuario == "administrador"): ?>
			<li class="<?= $rotaAtual == 'cliente' ? 'active' : '' ?>">
				<a href="?rota=cliente">
					<i class='bx bxs-user'></i>
					<span class="text">Clientes</span>
				</a>
			</li>
		<?php endif; ?>
		
		<?php if($tipoUsuario == "administrador"): ?>
			<li class="<?= $rotaAtual == 'funcionario' ? 'active' : '' ?>">
				<a href="?rota=funcionario">
					<i class='bx bxs-user-plus'></i>
					<span class="text">Funcionarios</span>
				</a>
			</li>
		<?php endif; ?>
		
		<li class="<?= $rotaAtual == 'pedidos' ? 'active' : '' ?>">
			<a href="?rota=pedidos">
				<i class='bx bxs-cart'></i>
				<span class="text">Pedidos</span>
			</a>
		</li>
		
		<?php if($tipoUsuario == "administrador"): ?>
			<li class="<?= $rotaAtual == 'definicao' ? 'active' : '' ?>">
				<a href="?rota=definicao">
					<i class='bx bxs-cog'></i>
					<span class="text">Definições</span>
				</a>
			</li>
		<?php endif; ?>
	</ul>                                                      
	<ul class="side-menu">
		<li>
			<a href="logout.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
</section>

<style>
/* Estilos para o item ativo */
.side-menu li.active {
    background: #ff7f00;
    position: relative;
}

.side-menu li.active::before {
    content: '';
    position: absolute;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    top: -40px;
    right: 0;
    box-shadow: 20px 20px 0 #ff7f00;
    z-index: -1;
}

.side-menu li.active::after {
    content: '';
    position: absolute;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    bottom: -40px;
    right: 0;
    box-shadow: 20px -20px 0 #ff7f00;
    z-index: -1;
}

.side-menu li.active a {
    color: #fff;
}

/* Hover effect para itens não ativos */
.side-menu li:not(.active):hover {
    background: #f8f8f8;
}

.side-menu li:not(.active):hover a {
    color: #ff7f00;
}

/* Transições suaves */
.side-menu li {
    transition: all 0.3s ease;
}

.side-menu li a {
    transition: color 0.3s ease;
}

/* Estilo especial para o botão de logout */
.side-menu li a.logout:hover {
    background: #dc3545;
    color: #fff;
}

/* Indicador visual para submenus (se houver) */
.side-menu li.has-submenu > a::after {
    content: '\f107';
    font-family: 'BoxIcons';
    margin-left: auto;
    transition: transform 0.3s ease;
}

.side-menu li.has-submenu.open > a::after {
    transform: rotate(180deg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar efeito de ripple aos itens do menu
    const menuItems = document.querySelectorAll('.side-menu li a');
    
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const ripple = document.createElement('div');
            
            ripple.className = 'ripple';
            ripple.style.left = `${e.clientX - rect.left}px`;
            ripple.style.top = `${e.clientY - rect.top}px`;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
</script>