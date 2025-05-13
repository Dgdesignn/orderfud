const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8080 });

// Armazenar conexões ativas
const clients = new Map();
const admins = new Map();

wss.on('connection', (ws, req) => {
    const userType = req.url.split('?')[1]; // admin ou client
    const userId = req.headers['user-id'];

    if (userType === 'admin') {
        admins.set(userId, ws);
    } else {
        clients.set(userId, ws);
    }

    ws.on('message', (message) => {
        const data = JSON.parse(message);
        
        switch(data.type) {
            case 'NEW_ORDER':
                // Notificar todos os admins
                admins.forEach((adminWs) => {
                    adminWs.send(JSON.stringify({
                        type: 'NEW_ORDER',
                        order: data.order
                    }));
                });
                break;

            case 'ORDER_STATUS_CHANGE':
                // Notificar cliente específico
                const clientWs = clients.get(data.clientId);
                if (clientWs) {
                    clientWs.send(JSON.stringify({
                        type: 'ORDER_STATUS_UPDATE',
                        order: data.order
                    }));
                }
                break;
        }
    });

    ws.on('close', () => {
        if (userType === 'admin') {
            admins.delete(userId);
        } else {
            clients.delete(userId);
        }
    });
}); 