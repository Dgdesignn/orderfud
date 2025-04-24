<?php

echo"pedidos";

?>

<h1>Pedidos Pendentes</h1>
    
    <div id="pedidos-container">
        <?php
         $pedido = new OrderController();
         $pedidos->criarPedido($idCliente, $produtos);
         foreach ($pedidos as $pedido): ?>
        <div class="pedido <?= $pedido['notificado'] ? '' : 'novo' ?>">
            <h3>Pedido #<?= $pedido['idPedido'] ?></h3>
            <p>Cliente: <?= htmlspecialchars($pedido['nome_cliente']) ?></p>
            <p>Data: <?= $pedido['data'] ?></p>
            
            <h4>Produtos:</h4>
            <ul>
                <?php foreach (json_decode($pedido['produtos'], true) as $produto): ?>
                <li><?= $produto['nome'] ?> (<?= $produto['quantidade'] ?> x <?= $produto['preco'] ?> Kz)</li>
                <?php endforeach; ?>
            </ul>
            
            <p>Total: <?= $pedido['total'] ?> Kz</p>
            
            <form method="post" action="processar_pedido_funcionario.php">
                <input type="hidden" name="id_pedido" value="<?= $pedido['idPedido'] ?>">
                <button type="submit">Marcar como Processado</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
