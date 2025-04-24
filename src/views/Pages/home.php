<div class="head-title">
			<div class="left">
				<h1>Home</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a>
					</li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li>
						<a class="active" href="#">Início</a>
					</li>
				</ul>
			</div>
			<a href="#" class="btn-download">
				<i class='bx bxs-cloud-download'></i>
				<span class="text">Baixar Relatório</span>
			</a>
		</div>

		<ul class="box-info">
		    <li>
			    <i class='bx bxs-user-plus'></i>
                <span class="text">
                    <h3><?php echo $total_funcionarios; ?></h3>
                    <p>Funcionários</p>
                </span>
            </li>
			<li>
				<i class='bx bxs-receipt'></i>
				<span class="text">
					<h3><?php echo $total_pedidos; ?></h3>
					<p> Pedidos</p>
				</span>
			</li>
			<li>
			    <i class='bx bxs-user'></i>
				<span class="text">
					<h3><?php echo $total_clientes; ?></h3>
					<p>Clientes</p>
				</span>
			</li>
			<li>
			    <i class='bx bxs-credit-card'></i>
				<span class="text">
					<h3><?php echo $total_produtos; ?></h3>
					<p>Produtos</p>
				</span>
			</li>
			
		</ul>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Pedidos Recentes</h3>
					<i class='bx bx-search'></i>
					<i class='bx bx-filter'></i>
				</div>
				<table>
					<thead>
						<tr>
							<th>Clientes</th>
							<th>Data do Pedido</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<img src="pessoa3.jpg">
								<p>Domingos Richarlison</p>
							</td>
							<td>20-02-2025</td>
							<td><span class="status completed">Entregue</span></td>
						</tr>
						<tr>
							<td>
								<img src="pessoa2.webp">
								<p>Tese Cafala</p>
							</td>
							<td>20-02-2025</td>
							<td><span class="status pending">Pendente</span></td>
						</tr>
						<tr>
							<td>
								<img src="p diddy.jpg">
								<p>P diddy</p>
							</td>
							<td>20-02-2025</td>
							<td><span class="status pending">entregue</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="todo">
				<div class="head">
					<h3>Tarefas</h3>
					<i class='bx bx-plus'></i>
					<i class='bx bx-filter'></i>
				</div>
				<ul class="todo-list">
					<li class="completed">
						<p>Atualizar cardápio</p>
						<i class='bx bx-dots-vertical-rounded'></i>
					</li>
					<li class="not-completed">
						<p>Revisar pedidos pendentes</p>
						<i class='bx bx-dots-vertical-rounded'></i>
					</li>
				</ul>
			</div>
		</div>