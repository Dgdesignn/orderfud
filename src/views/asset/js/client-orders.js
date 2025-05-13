class ClientOrderNotification {
    constructor() {
        this.ws = new WebSocket(`ws://localhost:8080?client`);
        this.initWebSocket();
    }

    initWebSocket() {
        this.ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            
            if (data.type === 'ORDER_STATUS_UPDATE') {
                this.showNotification(data.order);
                this.updateOrderStatus(data.order);
            }
        };
    }

    showNotification(order) {
        const statusMessages = {
            'preparing': 'Seu pedido está sendo preparado',
            'ready': 'Seu pedido está pronto para retirada',
            'delivered': 'Seu pedido foi entregue',
            'cancelled': 'Seu pedido foi cancelado'
        };

        const notification = new Notification('Atualização do Pedido', {
            body: statusMessages[order.status],
            icon: '/assets/img/logo.png'
        });

        // Som de notificação
        const audio = new Audio('/assets/sound/notification.mp3');
        audio.play();
    }

    updateOrderStatus(order) {
        const orderElement = document.querySelector(`#order-${order.id}`);
        if (orderElement) {
            orderElement.querySelector('.order-status').textContent = order.status;
            orderElement.className = `order-item status-${order.status}`;
        }
    }
}

// Inicializar
const clientNotification = new ClientOrderNotification(); 