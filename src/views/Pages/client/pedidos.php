<div class="head-title">
    <div class="left">
        <h1>Meus Pedidos</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Pedidos</a></li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <?php if(!empty($pedidos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Itens</th>
                        <th>Total</th>
                        <th>Data do Pedido</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pedidos as $pedido): ?>
                        <tr id="pedido-<?php echo $pedido['idPedido']; ?>">
                            <td>
                                <i class='bx bxs-receipt'></i>
                                #<?php echo $pedido['idPedido']; ?>
                            </td>
                            <td>
                                <span class="items-list">
                                    <?php echo $pedido['items']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="price">
                                    <?php echo number_format($pedido['total'], 2, ',', '.'); ?> Kz
                                </span>
                            </td>
                            <td>
                                <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?>
                            </td>
                            <td>
                                <span class="status <?php echo $pedido['status']; ?>">
                                    <?php 
                                        $statusLabels = [
                                            'pendente' => 'Pendente',
                                            'em_preparo' => 'Em Preparo',
                                            'pronto' => 'Pronto',
                                            'entregue' => 'Entregue',
                                            'cancelado' => 'Cancelado'
                                        ];
                                        echo $statusLabels[$pedido['status']] ?? $pedido['status'];
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php if($pedido['status'] === 'pendente'): ?>
                                    <button 
                                        class="btn-cancel"
                                        onclick="cancelarPedido(<?php echo $pedido['idPedido']; ?>)"
                                        data-pedido-id="<?php echo $pedido['idPedido']; ?>"
                                    >
                                        <i class='bx bx-x'></i>
                                        Cancelar
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-pedidos">
                <i class='bx bx-shopping-bag'></i>
                <p>Você ainda não fez nenhum pedido</p>
                <a href="website.php?rota=produtos" class="btn-primary">Fazer Primeiro Pedido</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.table-data {
    padding: 20px;
}

.order table {
    width: 100%;
    border-collapse: collapse;
}

.order table th,
.order table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.order table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.items-list {
    display: block;
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
}

.status.pendente {
    background-color: #FACC15 ;
    color: #fff;
}

.status.em_preparo {
    background-color: #3B82F6 ;
    color: #fff;
}

.status.pronto {
    background-color: #22C55E ;
    color: #fff;
}

.status.entregue {
    background-color: #16A34A;
    color: #fff;
}

.status.cancelado {
    background-color: #EF4444 ;
    color: #fff;
}

.btn-cancel {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
}

.btn-cancel:hover {
    background-color: #c82333;
}

.no-pedidos {
    text-align: center;
    padding: 40px;
}

.no-pedidos i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 20px;
}
</style>

<script>
function cancelarPedido(pedidoId) {
    if (!confirm('Tem certeza que deseja cancelar este pedido?')) {
        return;
    }

    fetch('/api/pedidos/cancelar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            pedido_id: pedidoId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Atualizar o status na tabela
            const row = document.getElementById(`pedido-${pedidoId}`);
            const statusCell = row.querySelector('.status');
            const actionCell = row.querySelector('td:last-child');
            
            statusCell.className = 'status cancelado';
            statusCell.textContent = 'Cancelado';
            actionCell.innerHTML = ''; // Remove o botão de cancelar
            
            // Mostrar mensagem de sucesso
            alert('Pedido cancelado com sucesso!');
        } else {
            alert(data.message || 'Erro ao cancelar pedido');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao cancelar pedido. Tente novamente.');
    });
}

// Atualização em tempo real dos status dos pedidos
function atualizarStatusPedidos() {
    const pedidosIds = Array.from(document.querySelectorAll('tr[id^="pedido-"]'))
        .map(row => row.id.replace('pedido-', ''));

    if (pedidosIds.length === 0) return;

    fetch('/api/pedidos/status.php?ids=' + pedidosIds.join(','))
        .then(response => response.json())
        .then(data => {
            data.forEach(pedido => {
                const row = document.getElementById(`pedido-${pedido.id}`);
                if (row) {
                    const statusCell = row.querySelector('.status');
                    if (statusCell.textContent !== pedido.status) {
                        statusCell.className = `status ${pedido.status}`;
                        statusCell.textContent = pedido.status;
                        
                        // Atualizar botão de cancelar
                        const actionCell = row.querySelector('td:last-child');
                        if (pedido.status !== 'pendente') {
                            actionCell.innerHTML = '';
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Erro ao atualizar status:', error));
}

// Atualizar status a cada 30 segundos
setInterval(atualizarStatusPedidos, 30000);

// Primeira atualização
atualizarStatusPedidos();
</script> 