<?php
    
  // Rotas para notificações
  $router->post('/pedido/criar', 'PedidoController@finalizarPedido');
  $router->get('/notificacoes', 'NotificacaoController@listar');
  $router->post('/notificacao/{id}/visualizar', 'NotificacaoController@visualizar');
?> 
  
  
  
  
  
  
  
  
  
<div class="notificacoes-container">
  <h2>📢 Notificações</h2>
    
  <?php foreach ($notificacoes as $notificacao): ?>
    <div class="notificacao <?= $notificacao['lida'] ? 'lida' : 'nova' ?>">
        <a href="/pedido/detalhes/<?= $notificacao['pedido_id'] ?>?notificacao_id=<?= $notificacao['id'] ?>">
            <?= htmlspecialchars($notificacao['mensagem']) ?>
            <small><?= date('d/m H:i', strtotime($notificacao['data_pedido'])) ?></small>
        </a>
    </div>
  <?php endforeach; ?>
</div>

<body>
  <script src="notificacao.js"></script>
</body>