<?php
session_start();
if(!isset($_SESSION["client"])){
    header("location: login-client.php");
    exit;
}

require "../controllers/orderController.php";
$pedido = new OrderController();
$pedidos = $pedido->buscarPedidosCliente($_SESSION['client']['id']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos - OrderFüd</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="asset/css/meus-pedidos.css">
</head>
<body>
    <div class="container">
        <h1>Meus Pedidos</h1>
        
        <div class="orders-container">
            <?php if(!empty($pedidos)): ?>
                <?php foreach($pedidos as $pedido): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-number">Pedido #<?php echo $pedido['id']; ?></span>
                            <span class="order-date"><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></span>
                        </div>
                        
                        <div class="order-items">
                            <?php 
                            $items = json_decode($pedido['items'], true);
                            foreach($items as $item): 
                            ?>
                                <div class="order-item">
                                    <span><?php echo $item['name']; ?> x <?php echo $item['quantity']; ?></span>
                                    <span><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?> Kz</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-footer">
                            <div class="order-total">
                                Total: <?php echo number_format($pedido['total'], 2, ',', '.'); ?> Kz
                            </div>
                            <div class="order-status <?php echo strtolower($pedido['status']); ?>">
                                <?php echo $pedido['status']; ?>
                            </div>
                        </div>
                        
                        <?php if(!empty($pedido['observacoes'])): ?>
                            <div class="order-notes">
                                <strong>Observações:</strong> <?php echo $pedido['observacoes']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <p>Você ainda não fez nenhum pedido</p>
                    <a href="?rota=produtos" class="btn-primary">Fazer Pedido</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 