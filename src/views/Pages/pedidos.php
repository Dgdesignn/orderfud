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

    /* Adicionar estilos para as notificações */
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

    /* Estilos para diferentes status */
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
    // Função para atualizar status do pedido
    function atualizarStatusPedido(select) {
        const pedidoId = select.getAttribute('data-pedido-id');
        const novoStatus = select.value;
        const pedidoCard = select.closest('.pedido-card');
        
        // Desabilitar select durante a atualização
        select.disabled = true;
        
        fetch('../dashboardadmin.php?rota=pedidos', {  // URL atualizada
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                pedido_id: pedidoId,
                status: novoStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar o card com o novo status
                pedidoCard.setAttribute('data-status', novoStatus);
                alert('Status atualizado com sucesso!');
            } else {
                // Reverter para o status anterior em caso de erro
                select.value = select.getAttribute('data-status-atual');
                alert('Erro ao atualizar status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            // Reverter para o status anterior em caso de erro
            select.value = select.getAttribute('data-status-atual');
            alert('Erro ao atualizar status');
        })
        .finally(() => {
            // Reabilitar select após a atualização
            select.disabled = false;
        });
    }

    // Adicionar listeners aos selects de status
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            if (confirm('Confirma a alteração do status do pedido?')) {
                atualizarStatusPedido(this);
            } else {
                // Reverter para o status anterior se cancelar
                this.value = this.getAttribute('data-status-atual');
            }
        });
    });

    // Configurar filtro de status
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
