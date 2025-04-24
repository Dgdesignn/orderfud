<?php

    $tipoUsuario = $_SESSION["user"]["tipo"];

?>
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-school'></i>
		<span class="text">OrderFüd</span>
	</a>
	<ul class="side-menu top">
		<?php
			if($tipoUsuario == "administrador"){
		?>
			<li class="active">
				<a href="?rota=home">
					<i class='bx bxs-home-smile'></i>
					<span class="text">Home</span>
				</a>
		    </li>
		<?php } ?>
		
		<li>
			<a href="?rota=categoria">
			    <i class='bx bxs-category'></i>
				<span class="text"> Categorias</span>
			</a>
		</li>
		
		
		<li>
			<a href="?rota=produto">
				<i class='bx bxs-credit-card'></i>
				<span class="text">Produto </span>
			</a>
		</li>
		
		<?php
			if($tipoUsuario == "administrador"){
		?>
		<li>
			<a href="?rota=cliente">
				<i class='bx bxs-user'></i>
				<span class="text">Clientes</span>
			</a>
		</li>
		<?php } ?>
		
		<?php
			if($tipoUsuario == "administrador"){
		?>
		<li>
			<a href="?rota=funcionario">
				<i class='bx bxs-user-plus'></i>
				<span class="text">Funcionarios</span>
			</a>
		</li>
		<?php } ?>
		
		<li>
			<a href="?rota=pedidos">
				<i class='bx bxs-user-plus'></i>
				<span class="text">Pedidos</span>
			</a>
		</li>
		
		<?php
			if($tipoUsuario == "administrador"){
		?>
		<li>
			<a href="?rota=definicao">
			    <i class='bx bxs-cog'></i>
				<span class="text"> Definições</span>
			</a>
		</li>
		<?php } ?>
	</ul>                                                      
	<ul class="side-menu">
		<li>
			<a href="logout.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
</section>