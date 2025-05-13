<?php

    $tipoUsuario = $_SESSION["user"]["tipo"];

?>
<nav>
	<i class='bx bx-menu'></i>
	<?php
        if ($tipoUsuario == "administrador") {
            echo '<a href="#" class="nav-link">Administrador</a>';
		} else {
            echo '<a href="#" class="nav-link"> Área do Funcionário</a>';
		}
    ?>
	<form action="#">
		<div class="form-input">
			<input type="search" placeholder="Buscar no sistema...">
			<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
		</div>
	</form>
	<input type="checkbox" id="switch-mode" hidden>
	<label for="switch-mode" class="switch-mode"></label>
	
	<!-- Área de Notificações Atualizada -->
	<div class="notification-area">
		<a href="#" class="notification" id="notification-toggle">
			<i class='bx bxs-bell'></i>
			<span class="num" id="notification-count">0</span>
		</a>
		<div class="notification-dropdown" id="notification-dropdown">
			<div class="notification-header">
				<h3>Notificações</h3>
				<button id="mark-all-read">Marcar todas como lidas</button>
			</div>
			<div class="notification-list" id="notification-list">
				<!-- As notificações serão inseridas aqui via JavaScript -->
			</div>
		</div>
	</div>

	<a href="userPerfil.php" class="profile">
		<img src="user1.jpg">
	</a>
</nav>

<style>
	.notification-area {
		position: relative;
	}

	.notification-dropdown {
		position: absolute;
		top: 100%;
		right: 0;
		width: 300px;
		background: white;
		border-radius: 8px;
		box-shadow: 0 5px 15px rgba(0,0,0,0.2);
		display: none;
		z-index: 1000;
		max-height: 400px;
		overflow-y: auto;
	}

	.notification-header {
		padding: 15px;
		border-bottom: 1px solid #eee;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.notification-header h3 {
		margin: 0;
		font-size: 16px;
	}

	#mark-all-read {
		background: none;
		border: none;
		color: #4a90e2;
		cursor: pointer;
		font-size: 12px;
	}

	.notification-item {
		padding: 12px 15px;
		border-bottom: 1px solid #eee;
		cursor: pointer;
		transition: background-color 0.3s;
	}

	.notification-item:hover {
		background-color: #f5f5f5;
	}

	.notification-item.unread {
		background-color: #f0f7ff;
	}

	.notification-item .title {
		font-weight: bold;
		font-size: 14px;
		margin-bottom: 5px;
	}

	.notification-item .message {
		font-size: 13px;
		color: #666;
	}

	.notification-item .time {
		font-size: 11px;
		color: #999;
		margin-top: 5px;
	}

	.show {
		display: block !important;
	}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationToggle = document.getElementById('notification-toggle');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationList = document.getElementById('notification-list');
    const notificationCount = document.getElementById('notification-count');
    const markAllRead = document.getElementById('mark-all-read');

    // Esconder botão "Marcar todas como lidas" inicialmente
    markAllRead.style.display = 'none';

    // Toggle dropdown
    notificationToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        notificationDropdown.classList.toggle('show');
    });

    // Fechar dropdown quando clicar fora
    document.addEventListener('click', function(e) {
        if (!notificationDropdown.contains(e.target) && 
            !notificationToggle.contains(e.target)) {
            notificationDropdown.classList.remove('show');
        }
    });

    // Marcar todas como lidas
    markAllRead.addEventListener('click', function() {
        fetch('/api/notificacoes/marcar-lidas.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const unreadItems = notificationList.querySelectorAll('.unread');
                unreadItems.forEach(item => {
                    item.classList.remove('unread');
                });
                notificationCount.textContent = '0';
                notificationCount.style.display = 'none';
                markAllRead.style.display = 'none';
            }
        })
        .catch(error => console.error('Erro ao marcar notificações:', error));
    });

    // Função para tocar som de notificação
    function playNotificationSound() {
        const audio = new Audio('/asset/sound/notification.mp3');
        audio.play();
    }

    // Função para atualizar notificações
    function atualizarNotificacoes() {
        fetch('/api/notificacoes.php')
            .then(response => response.json())
            .then(data => {
                const notificacoesAnteriores = notificationList.children.length;
                notificationList.innerHTML = '';
                let unreadCount = 0;

                data.forEach(notif => {
                    if (!notif.lida) unreadCount++;
                    
                    const notifElement = document.createElement('div');
                    notifElement.className = `notification-item ${notif.lida ? '' : 'unread'}`;
                    
                    notifElement.innerHTML = `
                        <div class="title">${notif.titulo}</div>
                        <div class="message">${notif.mensagem}</div>
                        <div class="time">${new Date(notif.data).toLocaleString()}</div>
                    `;
                    
                    // Adicionar evento de clique para marcar como lida
                    notifElement.addEventListener('click', () => {
                        if (!notif.lida) {
                            marcarComoLida(notif.id, notifElement);
                        }
                        
                        // Se for notificação de pedido, redirecionar para página do pedido
                        if (notif.tipo === 'novo_pedido') {
                            window.location.href = `pedidos.php?id=${notif.pedido_id}`;
                        }
                    });
                    
                    notificationList.appendChild(notifElement);
                });

                // Mostrar/esconder botão "Marcar todas como lidas"
                markAllRead.style.display = unreadCount > 0 ? 'block' : 'none';

                // Atualizar contador
                notificationCount.textContent = unreadCount;
                notificationCount.style.display = unreadCount > 0 ? 'block' : 'none';

                // Tocar som se houver novas notificações
                if (data.length > notificacoesAnteriores) {
                    playNotificationSound();
                }
            })
            .catch(error => console.error('Erro ao buscar notificações:', error));
    }

    // Função para marcar notificação individual como lida
    function marcarComoLida(notificacaoId, elemento) {
        fetch('/api/notificacoes/marcar-lida.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: notificacaoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                elemento.classList.remove('unread');
                const unreadCount = parseInt(notificationCount.textContent) - 1;
                notificationCount.textContent = unreadCount;
                notificationCount.style.display = unreadCount > 0 ? 'block' : 'none';
                markAllRead.style.display = unreadCount > 0 ? 'block' : 'none';
            }
        })
        .catch(error => console.error('Erro ao marcar notificação:', error));
    }

    // Atualizar notificações a cada 10 segundos
    setInterval(atualizarNotificacoes, 10000);
    
    // Primeira atualização
    atualizarNotificacoes();
});
</script>