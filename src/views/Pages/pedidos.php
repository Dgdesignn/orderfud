<?php
$pedidosController = new OrderController();
$pedidos = $pedidosController->buscarTodosPedidos();

// Processar alteração de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id']) && isset($_POST['novo_status'])) {

 
$resultado = $pedidosController->atualizarStatusPedido(
        intval($_POST['pedido_id']), 
        $_POST['novo_status']
    );

    //var_dump($resultado);

       /* 

    if ($resultado['success']) {
        $_SESSION['mensagem'] = 'Status atualizado com sucesso!';
    } else {
        $_SESSION['erro'] = $resultado['message'] ?? 'Erro ao atualizar status';
    }

    header('Location: ' . $_SERVER['PHP_SELF'] . '?rota=pedidos');
    exit;*/
}
?>

<div class="pedidos-container">
    <div class="pedidos-header">
        <h1>Gestão de Pedidos</h1>
    </div>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['mensagem'];
            unset($_SESSION['mensagem']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['erro'];
            unset($_SESSION['erro']);
            ?>
        </div>
    <?php endif; ?>

    <div class="pedidos-filters">
        <div class="filter-group">
            <label>Filtrar por Status:</label>
            <select id="status-filter" onchange="filtrarPedidos(this.value)">
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
                            <div class="item"><?= htmlspecialchars($item) ?></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pedido-info">
                        <div class="pedido-total">
                            <strong>Total:</strong> <?= number_format($pedido['total'], 2, ',', '.') ?> Kz
                        </div>

                        <div class="pedido-status">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="pedido_id" value="<?= $pedido['idPedido'] ?>">
                                <select name="novo_status" onchange="if(confirm('Confirma a alteração do status?')) this.form.submit();">
                                    <option value="pendente" <?= $pedido['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                    <option value="em_preparo" <?= $pedido['status'] == 'em_preparo' ? 'selected' : '' ?>>Em Preparo</option>
                                    <option value="pronto" <?= $pedido['status'] == 'pronto' ? 'selected' : '' ?>>Pronto</option>
                                    <option value="entregue" <?= $pedido['status'] == 'entregue' ? 'selected' : '' ?>>Entregue</option>
                                    <option value="cancelado" <?= $pedido['status'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </form>
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
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

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

    select {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .pedido-card[data-status="pendente"] { border-left: 4px solid #FACC15; }
    .pedido-card[data-status="em_preparo"] { border-left: 4px solid #3B82F6; }
    .pedido-card[data-status="pronto"] { border-left: 4px solid #22C55E; }
    .pedido-card[data-status="entregue"] { border-left: 4px solid #16A34A; }
    .pedido-card[data-status="cancelado"] { border-left: 4px solid #EF4444; }
</style>

<script>
function filtrarPedidos(status) {
    const pedidos = document.querySelectorAll('.pedido-card');
    pedidos.forEach(pedido => {
        if (status === 'todos' || pedido.getAttribute('data-status') === status) {
            pedido.style.display = 'block';
        } else {
            pedido.style.display = 'none';
        }
    });
}
</script>