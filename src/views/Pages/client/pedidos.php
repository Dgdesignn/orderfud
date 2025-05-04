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

<div class="pedidos-container">
    <?php if(!empty($pedidos)): ?>
        <?php foreach($pedidos as $pedido): ?>
            <div class="pedido-box">
                <div class="pedido-header">
                    <span class="pedido-numero">
                        <i class='bx bxs-receipt'></i>
                        Pedido #<?php echo $pedido['idPedido']; ?>
                    </span>
                    <span class="pedido-data">
                        <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?>
                    </span>
                </div>
                
                <div class="pedido-status <?php echo $pedido['status']; ?>">
                    <i class='bx bxs-circle'></i>
                    <?php echo ucfirst($pedido['status']); ?>
                </div>

                <div class="pedido-total">
                    <span>Total:</span>
                    <span class="price"><?php echo number_format($pedido['total'], 2, ',', '.'); ?> Kz</span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-pedidos">
            <i class='bx bx-shopping-bag'></i>
            <p>Você ainda não fez nenhum pedido</p>
            <a href="shopping.php" class="btn-primary">Fazer Primeiro Pedido</a>
        </div>
    <?php endif; ?>
</div> 