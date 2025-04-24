<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Cantina Escolar</title>
    <link rel="stylesheet" href="userperfil.css?=123">
     <!-- FontAwesome Icons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<section id="sidebar">

  <?php
    include "./includes/clients/asidebar.php";
  ?>

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
            <img src="user1.jpg" alt="Foto de perfil">
          </a>
        </li>
      </ul>
    </nav>

    <main>
          
    <?php 
			
			$rota = $_GET["rota"];
			switch($rota){
				case "pedidosCliente":
				case "/":
					include "./includes/clients/pedidosCliente.php";
					break;
				case "saldo":
					include "./includes/clients/saldo.php";
					break;
				case "favoritos":
					include "./includes/clients/Favoritos.php";
					break;
				case "configuracoes":
					include "./includes/clients/configuracoes.php";
					break;
			
				default :
					echo "Pagina nao encontrada";

		}
    ?>

    </main>
   
</header>

  <script src="userperfil.js"></script>
</body>
</html>




