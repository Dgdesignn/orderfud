class NotificacaoManager {
    constructor() {
        this.unreadCount = 0;
        this.notificacoes = [];
        this.initNotificacoes();
    }

    initNotificacoes() {
        // Verificar novas notificações a cada 5 segundos
        setInterval(() => this.checkNovasNotificacoes(), 5000);
        
        // Verificar imediatamente ao iniciar
        this.checkNovasNotificacoes();
        
        // Adicionar listeners
        document.querySelector('.notification').addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleNotificacaoPanel();
        });
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
        novasNotificacoes.forEach(notificacao => {
            if (!this.notificacoes.find(n => n.idPedido === notificacao.idPedido)) {
                this.notificacoes.unshift(notificacao);
                this.showNotificacao(notificacao);
                this.updateNotificacaoBadge(1);
                this.playNotificationSound();
            }
        });
        
        this.updateNotificacaoPanel();
    }

    showNotificacao(notificacao) {
        // Notificação desktop
        if (Notification.permission === "granted") {
            new Notification("Novo Pedido!", {
                body: `Cliente: ${notificacao.nome_cliente}\nTotal: ${this.formatMoney(notificacao.total)}`,
                icon: "/assets/img/logo.png"
            });
        }
    }

    updateNotificacaoBadge(increment) {
        this.unreadCount += increment;
        const badge = document.querySelector('.num');
        if (badge) {
            badge.textContent = this.unreadCount;
            badge.style.display = this.unreadCount > 0 ? '' : 'none';
        }
    }

    updateNotificacaoPanel() {
        const container = document.getElementById('notifications-container');
        if (!container) return;

        container.innerHTML = this.notificacoes.map(notificacao => `
            <div class="notification-item" data-id="${notificacao.idPedido}">
                <div class="notification-content">
                    <div class="notification-title">
                        Pedido #${notificacao.idPedido}
                    </div>
                    <div class="notification-info">
                        <p><strong>Cliente:</strong> ${notificacao.nome_cliente}</p>
                        <p><strong>Itens:</strong> ${notificacao.items}</p>
                        <p><strong>Total:</strong> ${this.formatMoney(notificacao.total)}</p>
                        <p><small>Data: ${this.formatDate(notificacao.data_pedido)}</small></p>
                    </div>
                </div>
                <div class="notification-actions">
                    <button onclick="viewOrder(${notificacao.idPedido})" class="btn-view">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        `).join('');
    }

    toggleNotificacaoPanel() {
        const panel = document.getElementById('notifications-panel');
        panel.classList.toggle('active');
    }

    playNotificationSound() {
        const audio = new Audio('/assets/sound/notification.mp3');
        audio.play();
    }

    formatMoney(value) {
        return parseFloat(value).toFixed(2).replace('.', ',') + ' Kz';
    }

    formatDate(date) {
        return new Date(date).toLocaleString('pt-BR');
    }
}