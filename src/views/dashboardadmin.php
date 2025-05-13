<!-- No head, adicionar os estilos -->
<link rel="stylesheet" href="asset/css/notifications.css">

<!-- NAVBAR - Atualizar a seção de navegação -->
<nav>
    <i class='bx bx-menu'></i>
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Buscar...">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode"></label>
    <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">0</span>
        <div class="notifications-panel" id="notifications-panel">
            <div class="notifications-header">
                <h3>Notificações</h3>
            </div>
            <div class="notifications-container" id="notifications-container"></div>
        </div>
    </a>
    <a href="#" class="profile">
        <img src="img/people.png">
    </a>
</nav>

<!-- No final do body, adicionar os scripts -->
<script src="asset/js/notificacao.js"></script>
<script>
    // Inicializar gerenciador de notificações
    const notificacaoManager = new NotificacaoManager();

    // Solicitar permissão para notificações desktop
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    function viewOrder(orderId) {
        window.location.href = `?rota=pedidos&id=${orderId}`;
    }

    // Atualizar CSS para se adequar ao estilo existente
    document.head.insertAdjacentHTML('beforeend', `
    <style>
    .notifications-panel {
        position: absolute;
        top: 60px;
        right: 10px;
        width: 350px;
        background: var(--light);
        border-radius: 10px;
        box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
        display: none;
        z-index: 1000;
    }

    .notifications-panel.active {
        display: block;
    }

    .notification-item {
        padding: 15px;
        border-bottom: 1px solid var(--grey);
    }

    .notification-item.new {
        background: var(--light-blue);
    }
    </style>
    `);
</script> 