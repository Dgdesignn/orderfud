class NotificacaoManager {
    constructor() {
        this.unreadCount = 0;
        this.notificacoes = [];
        this.initNotificacoes();
    }

    initNotificacoes() {
        // Elementos do DOM
        this.notificationToggle = document.getElementById('notification-toggle');
        this.notificationDropdown = document.getElementById('notification-dropdown');
        this.notificationList = document.getElementById('notification-list');
        this.notificationCount = document.getElementById('notification-count');
        this.markAllRead = document.getElementById('mark-all-read');

        // Inicializar eventos
        this.initEventListeners();
        
        // Verificar novas notificações a cada 10 segundos
        setInterval(() => this.checkNovasNotificacoes(), 10000);
        
        // Primeira verificação
        this.checkNovasNotificacoes();
    }

    initEventListeners() {
        // Toggle dropdown
        this.notificationToggle?.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.notificationDropdown?.classList.toggle('show');
        });

        // Fechar ao clicar fora
        document.addEventListener('click', (e) => {
            if (!this.notificationDropdown?.contains(e.target) && 
                !this.notificationToggle?.contains(e.target)) {
                this.notificationDropdown?.classList.remove('show');
            }
        });

        // Marcar todas como lidas
        this.markAllRead?.addEventListener('click', () => this.marcarTodasComoLidas());
    }

    async checkNovasNotificacoes() {
        try {
            const response = await fetch('../api/notificacoes.php');
            const data = await response.json();
            
            if (data.success && data.notificacoes.length > 0) {
                this.handleNovasNotificacoes(data.notificacoes);
            }
        } catch (error) {
            console.error('Erro ao verificar notificações:', error);
        }
    }

    handleNovasNotificacoes(novasNotificacoes) {
        const notificacoesAnteriores = this.notificationList?.children.length || 0;
        this.notificationList.innerHTML = '';
        let unreadCount = 0;

        novasNotificacoes.forEach(notif => {
            if (!notif.lida) unreadCount++;
            this.criarNotificacaoElement(notif);
        });

        // Atualizar contador e botão
        this.updateNotificationCount(unreadCount);
        this.markAllRead.style.display = unreadCount > 0 ? 'block' : 'none';

        // Tocar som se houver novas notificações
        if (novasNotificacoes.length > notificacoesAnteriores) {
            this.playNotificationSound();
        }
    }

    criarNotificacaoElement(notif) {
        const notifElement = document.createElement('div');
        notifElement.className = `notification-item ${notif.lida ? '' : 'unread'}`;
        
        notifElement.innerHTML = `
            <div class="title">Pedido #${notif.idPedido}</div>
            <div class="message">
                Cliente: ${notif.nome_cliente}<br>
                Total: ${this.formatMoney(notif.total)}<br>
                Itens: ${notif.items}
            </div>
            <div class="time">${this.formatDate(notif.data_pedido)}</div>
        `;
        
        notifElement.addEventListener('click', () => {
            if (!notif.lida) {
                this.marcarComoLida(notif.idPedido, notifElement);
            }
            window.location.href = `?rota=pedidos&id=${notif.idPedido}`;
        });
        
        this.notificationList?.appendChild(notifElement);
    }

    async marcarComoLida(notificacaoId, elemento) {
        try {
            const response = await fetch('../api/notificacoes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ idPedido: notificacaoId })
            });
            
            const data = await response.json();
            if (data.success) {
                elemento.classList.remove('unread');
                this.updateNotificationCount(-1);
            }
        } catch (error) {
            console.error('Erro ao marcar notificação:', error);
        }
    }

    async marcarTodasComoLidas() {
        const unreadItems = this.notificationList?.querySelectorAll('.unread');
        if (!unreadItems?.length) return;

        try {
            for (const item of unreadItems) {
                const notificacaoId = item.dataset.id;
                await this.marcarComoLida(notificacaoId, item);
            }
            this.markAllRead.style.display = 'none';
        } catch (error) {
            console.error('Erro ao marcar todas como lidas:', error);
        }
    }

    updateNotificationCount(count) {
        if (typeof count === 'number') {
            this.unreadCount = count;
        }
        if (this.notificationCount) {
            this.notificationCount.textContent = this.unreadCount;
            this.notificationCount.style.display = this.unreadCount > 0 ? 'block' : 'none';
        }
    }

    playNotificationSound() {
        const audio = new Audio('/asset/sound/notification.mp3');
        audio.play();
    }

    formatMoney(value) {
        return parseFloat(value).toFixed(2).replace('.', ',') + ' Kz';
    }

    formatDate(date) {
        return new Date(date).toLocaleString('pt-BR');
    }
}

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    const notificacaoManager = new NotificacaoManager();
    
    // Solicitar permissão para notificações desktop
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }
}); 