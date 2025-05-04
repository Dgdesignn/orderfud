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

    <div class="pedidos-grid">
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-card" data-status="<?= $pedido['status'] ?>">
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
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pedido-info">
                        <div class="pedido-total">
                            <strong>Total:</strong> <?= number_format($pedido['total'], 2, ',', '.') ?> Kz
                        </div>
                        
                        <div class="pedido-status">
                            <strong>Status:</strong>
                            <select class="status-select" data-pedido-id="<?= $pedido['idPedido'] ?>">
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
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .pedido-observacoes {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar status do pedido
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const pedidoId = this.getAttribute('data-pedido-id');
            const novoStatus = this.value;
            
            fetch('../controllers/atualizar_status_pedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pedido_id: pedidoId,
                    status: novoStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status atualizado com sucesso!');
                    // Atualizar a cor ou classe do card conforme o novo status
                    const pedidoCard = this.closest('.pedido-card');
                    pedidoCard.setAttribute('data-status', novoStatus);
                } else {
                    alert('Erro ao atualizar status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao atualizar status');
            });
        });
    });

    // Filtrar pedidos por status
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
