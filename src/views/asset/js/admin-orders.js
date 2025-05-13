class OrderNotification {
    constructor() {
        this.ws = new WebSocket(`ws://localhost:8080?admin`);
        this.initWebSocket();
        this.initEventListeners();
    }

    initWebSocket() {
        this.ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            
            if (data.type === 'NEW_ORDER') {
                this.showNotification('Novo Pedido', data.order);
                this.updateOrdersList(data.order);
            }
        };
    }

    showNotification(title, order) {
        const notification = new Notification(title, {
            body: `Novo pedido #${order.id} - Cliente: ${order.clientName}`,
            icon: '/assets/img/logo.png'
        });

        // Som de notificação
        const audio = new Audio('/assets/sound/notification.mp3');
        audio.play();
    }

    updateOrdersList(order) {
        const ordersList = document.querySelector('#orders-list');
        const orderHtml = this.createOrderHtml(order);
        ordersList.insertAdjacentHTML('afterbegin', orderHtml);
    }

    updateOrderStatus(orderId, newStatus) {
        this.ws.send(JSON.stringify({
            type: 'ORDER_STATUS_CHANGE',
            clientId: orderId,
            order: {
                id: orderId,
                status: newStatus
            }
        }));
    }

    initEventListeners() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.status-btn')) {
                const orderId = e.target.dataset.orderId;
                const newStatus = e.target.dataset.status;
                this.updateOrderStatus(orderId, newStatus);
            }
        });
    }
}

// Inicializar
const orderNotification = new OrderNotification(); 