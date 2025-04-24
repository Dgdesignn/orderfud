
<link rel="stylesheet" href="historicoDePedidos.css">

<section class="historico-pedidos">
  <h1>Histórico de Pedidos</h1>
  <div class="pedido" id="pedido-1">
    <div class="pedido-info">
      <span class="pedido-data">Data: 08/04/2025</span>
      <span class="pedido-status">Status: Concluído</span>
      <span class="pedido-total">Total: R$ 25,00</span>
      <button class="repetir-pedido" onclick="repetirPedido(1)">Repetir Pedido</button>
    </div>
    <div class="pedido-itens">
      <h3>Itens do Pedido</h3>
      <ul>
        <li>Arroz com Feijão - Quantidade: 2</li>
        <li>Fruta - Quantidade: 1</li>
      </ul>
    </div>
  </div>
  
  <div class="pedido" id="pedido-2">
    <div class="pedido-info">
      <span class="pedido-data">Data: 09/04/2025</span>
      <span class="pedido-status">Status: Pendente</span>
      <span class="pedido-total">Total: R$ 15,00</span>
      <button class="repetir-pedido" onclick="repetirPedido(2)">Repetir Pedido</button>
    </div>
    <div class="pedido-itens">
      <h3>Itens do Pedido</h3>
      <ul>
        <li>Sanduíche - Quantidade: 1</li>
        <li>Suco - Quantidade: 1</li>
      </ul>
    </div>
  </div>
  <ul class="side-menu">
		<li>
			<a href="userperfil.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
</section>


<body>
    <script src="historicoDePedidos.js"></script>
</body>
