<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Administrador - Cantina Escolar</title>
    <link rel="stylesheet" href="adminPerfil.css">
     <!-- FontAwesome Icons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-school'></i>
		<span class="text">OrderFüd</span>
	</a>
	<ul class="side-menu top">
		<li class="active">
			<a href="historicoDePedidos.php">
                <i class='bx bxs-cart'></i>
				<span class="text">Histórico de pedidos</span>
			</a>
		</li>
		<li>
   
			<a href="saldoCarteira.php">
                <i class='bx bxs-wallet'></i>
				<span class="text">Saldo da Carteira</span>
			</a>
		</li>
		<li>
			<a href="?rota=produto">
                <i class='bx bxs-star'></i>
				<span class="text">Favoritos</span>
			</a>
		</li>
		<li>
			<a href="notificacao.php">
                <i class='bx bxs-bell'></i>
				<span class="text">Notificação</span>
			</a>
		</li>
		<li>
			<a href="?rota=funcionario">
                <i class='bx bxs-shield'></i>
				<span class="text">Segurança</span>
			</a>
		</li>
		
		<li>
			<a href="configuracoes.php">
			    <i class='bx bxs-cog'></i>
				<span class="text"> Definições</span>
			</a>
		</li>
	</ul>                                                      
	<ul class="side-menu">
		<li>
			<a href="dashboarbadmin.php?rota=home" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
</section>


<header>
  <nav>
    <i class='bx bx-menu' id="menu-toggle"></i>
    <ul class="nav-list">
      <li>
        <a href="#" class="notificacao">
          <i class='bx bxs-bell'></i>
          <span class="num">10</span>
        </a>
      </li>
      <li>
        <a href="#" class="profile">
          <img src="user2.jpg" alt="Foto de perfil">
        </a>
      </li>
    </ul>
  </nav>
  <div class="profile-section">
    <h1>Editar Perfil</h1>

    <!-- Formulário de Edição de Perfil -->
    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="profile-form">
            <div class="img-box">
                <figure class="profile-photo">
                    <img src="user2.jpg" class="imgpreview" alt="Imagem de perfil" />
                    <input type="file" class="imgprofile" name="profileImg" required hidden>
                </figure>
            </div>

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" placeholder="Digite seu nome" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" id="phone" placeholder="Digite seu telefone" required>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" placeholder="Digite sua senha" required>
            </div>
                <div class="select-container">
    <select name="tipo">
        <option value="administrador">Administrador</option>
        <option value="Funcionária">Funcionária</option>
    </select>
</div>


            <button id="save-btn" type="submit">Salvar Edição</button>
        </div>
    </form>
</div>

</header>
    



  <!-- Área de conteúdo principal -->
       

    <script src="adminPerfil.js"></script>
</body>
</html>

