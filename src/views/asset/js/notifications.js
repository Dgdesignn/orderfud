class NotificationManager {
    constructor(userType, userId) {
        this.userType = userType; // 'admin' ou 'employee'
        this.userId = userId;
        this.notifications = [];
        this.unreadCount = 0;
        this.initWebSocket();
        this.initNotifications();
    }

    initWebSocket() {
        this.ws = new WebSocket(`ws://localhost:8080?type=${this.userType}&id=${this.userId}`);
        
        this.ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            this.handleNotification(data);
        };

        this.ws.onerror = (error) => {
            console.error('WebSocket Error:', error);
        };
    }

    handleNotification(data) {
        switch(data.type) {
            case 'NEW_ORDER':
                this.showOrderNotification(data.order);
                this.updateOrdersList(data.order);
                this.playNotificationSound();
                break;
            
            case 'ORDER_STATUS':
                this.updateOrderStatus(data.order);
                break;
        }
    }

    showOrderNotification(order) {
        const notification = `
            <div class="notification-item new" data-id="${order.id}">
                <div class="notification-icon">
                    <i class='bx bx-receipt'></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Novo Pedido #${order.id}</div>
                    <div class="notification-info">
                        Cliente: ${order.clientName}<br>
                        Total: ${this.formatMoney(order.total)} Kz
                    </div>
                    <div class="notification-time">${this.formatTime(new Date())}</div>
                </div>
                <div class="notification-actions">
                    <button class="btn-view" onclick="viewOrder(${order.id})">
                        <i class='bx bx-show'></i>
                    </button>
                </div>
            </div>
        `;

        const container = document.getElementById('notifications-container');
        container.insertAdjacentHTML('afterbegin', notification);
        this.updateNotificationCount(1);
    }

    updateOrdersList(order) {
        const orderHtml = `
            <tr class="new-order" id="order-${order.id}">
                <td>#${order.id}</td>
                <td>${order.clientName}</td>
                <td>${this.formatMoney(order.total)} Kz</td>
                <td>
                    <span class="status pending">Pendente</span>
                </td>
                <td>
                    <div class="order-actions">
                        <button onclick="viewOrder(${order.id})" class="btn-action">
                            <i class='bx bx-show'></i>
                        </button>
                        <button onclick="updateStatus(${order.id}, 'preparing')" class="btn-action">
                            <i class='bx bx-dish'></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        const ordersList = document.querySelector('#orders-table tbody');
        ordersList.insertAdjacentHTML('afterbegin', orderHtml);
    }

    updateOrderStatus(order) {
        const orderRow = document.getElementById(`order-${order.id}`);
        if (orderRow) {
            const statusCell = orderRow.querySelector('.status');
            statusCell.className = `status ${order.status}`;
            statusCell.textContent = this.getStatusText(order.status);
        }
    }

    playNotificationSound() {
        const audio = new Audio('/assets/sound/notification.mp3');
        audio.play();
    }

    formatMoney(value) {
        return parseFloat(value).toFixed(2).replace('.', ',');
    }

    formatTime(date) {
        return date.toLocaleTimeString('pt-BR', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    }

    getStatusText(status) {
        const statusMap = {
            'pending': 'Pendente',
            'preparing': 'Preparando',
            'ready': 'Pronto',
            'delivered': 'Entregue',
            'cancelled': 'Cancelado'
        };
        return statusMap[status] || status;
    }

    updateNotificationCount(increment) {
        this.unreadCount += increment;
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = this.unreadCount;
            badge.style.display = this.unreadCount > 0 ? 'block' : 'none';
        }
    }
} 