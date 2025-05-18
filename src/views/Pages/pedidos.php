
<?php
$pedidosController = new OrderController();
$pedidos = $pedidosController->buscarTodosPedidos();
?>

<div class="pedidos-container">
    <div class="pedidos-header">
        <h1>Gestão de Pedidos</h1>
    </div>

    <div class="pedidos-filters">
        <div class="filter-group">
            <label>Filtrar por Status:</label>
            <select id="status-filter">
                <option value="todos">Todos</option>
                <option value="pendente">Pendente</option>
                <option value="em_preparo">Em Preparo</option>
                <option value="pronto">Pronto</option>
                <option value="entregue">Entregue</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
    </div>

    <div class="pedidos-grid" id="pedidos-grid">
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-card" data-pedido-id="<?= $pedido['idPedido'] ?>" data-status="<?= $pedido['status'] ?>">
                    <div class="pedido-header">
                        <h3>Pedido #<?= $pedido['idPedido'] ?></h3>
                        <span class="pedido-data"><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></span>
                    </div>

                    <div class="pedido-cliente">
                        <strong>Cliente:</strong> <?= htmlspecialchars($pedido['nome_cliente']) ?>
                    </div>

                    <div class="pedido-items">
                        <strong>Produtos:</strong><br>
                        <?php 
                        $items = explode(', ', $pedido['items']);
                        foreach ($items as $item): ?>
                            <div class="item"><?= htmlspecialchars($item) ?></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pedido-info">
                        <div class="pedido-total">
                            <strong>Total:</strong> <?= number_format($pedido['total'], 2, ',', '.') ?> Kz
                        </div>
                        
                        <div class="pedido-status">
                            <strong>Status:</strong>
                            <select class="status-select" data-pedido-id="<?= $pedido['idPedido'] ?>" data-status-atual="<?= $pedido['status'] ?>">
                                <option value="pendente" <?= $pedido['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                <option value="em_preparo" <?= $pedido['status'] == 'em_preparo' ? 'selected' : '' ?>>Em Preparo</option>
                                <option value="pronto" <?= $pedido['status'] == 'pronto' ? 'selected' : '' ?>>Pronto</option>
                                <option value="entregue" <?= $pedido['status'] == 'entregue' ? 'selected' : '' ?>>Entregue</option>
                                <option value="cancelado" <?= $pedido['status'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <?php if (!empty($pedido['observacoes'])): ?>
                        <div class="pedido-observacoes">
                            <strong>Observações:</strong>
                            <p><?= htmlspecialchars($pedido['observacoes']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-pedidos">
                <p>Nenhum pedido encontrado.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .pedidos-container {
        padding: 20px;
    }

    .pedidos-header {
        margin-bottom: 20px;
    }

    .pedidos-filters {
        margin-bottom: 20px;
        padding: 15px;
        background: #f5f5f5;
        border-radius: 8px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pedidos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .pedido-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: opacity 0.3s ease;
    }

    .pedido-card.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .pedido-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .pedido-cliente {
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .pedido-items {
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .pedido-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .status-select {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
        background-color: white;
        cursor: pointer;
    }

    .status-select:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .pedido-observacoes {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
    }

    .notificacao {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 4px;
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    }

    .notificacao.success {
        background-color: #4CAF50;
    }

    .notificacao.error {
        background-color: #f44336;
    }

    .notificacao.warning {
        background-color: #ff9800;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .pedido-card[data-status="pendente"] {
        border-left: 4px solid #FACC15;
    }

    .pedido-card[data-status="em_preparo"] {
        border-left: 4px solid #3B82F6;
    }

    .pedido-card[data-status="pronto"] {
        border-left: 4px solid #22C55E;
    }

    .pedido-card[data-status="entregue"] {
        border-left: 4px solid #16A34A;
    }

    .pedido-card[data-status="cancelado"] {
        border-left: 4px solid #EF4444;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pedidosGrid = document.getElementById('pedidos-grid');
    let atualizacaoEmAndamento = false;

    async function atualizarStatusPedido(select) {
        if (atualizacaoEmAndamento) {
            mostrarNotificacao('Uma atualização já está em andamento', 'warning');
            return;
        }

        const pedidoCard = select.closest('.pedido-card');
        const pedidoId = select.dataset.pedidoId;
        const novoStatus = select.value;
        const statusAtual = select.dataset.statusAtual;

        if (novoStatus === statusAtual) {
            return;
        }

        try {
            atualizacaoEmAndamento = true;
            pedidoCard.classList.add('loading');
            select.disabled = true;

            const response = await fetch('../../api/pedidos/atualizar-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pedido_id: pedidoId,
                    status: novoStatus
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Erro ao atualizar status');
            }

            if (data.success) {
                pedidoCard.setAttribute('data-status', novoStatus);
                select.dataset.statusAtual = novoStatus;
                mostrarNotificacao('Status atualizado com sucesso!', 'success');
            } else {
                throw new Error(data.message || 'Erro ao atualizar status');
            }
        } catch (error) {
            console.error('Erro:', error);
            select.value = statusAtual;
            mostrarNotificacao(error.message, 'error');
        } finally {
            pedidoCard.classList.remove('loading');
            select.disabled = false;
            atualizacaoEmAndamento = false;
        }
    }

    function mostrarNotificacao(mensagem, tipo) {
        const notificacao = document.createElement('div');
        notificacao.className = `notificacao ${tipo}`;
        notificacao.textContent = mensagem;
        
        document.body.appendChild(notificacao);
        
        setTimeout(() => {
            notificacao.remove();
        }, 3000);
    }

    // Event Listeners
    pedidosGrid.addEventListener('change', function(event) {
        if (event.target.classList.contains('status-select')) {
            atualizarStatusPedido(event.target);
        }
    });

    // Filtro de status
    document.getElementById('status-filter').addEventListener('change', function() {
        const statusSelecionado = this.value;
        const pedidos = document.querySelectorAll('.pedido-card');

        pedidos.forEach(pedido => {
            if (statusSelecionado === 'todos' || pedido.getAttribute('data-status') === statusSelecionado) {
                pedido.style.display = 'block';
            } else {
                pedido.style.display = 'none';
            }
        });
    });
});
</script>
