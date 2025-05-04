<?php
  
  require "../controllers/employeeController.php";
  require "../controllers/productController.php";
  require "../controllers/clientController.php";
  require "../controllers/categoryController.php";
  require "../controllers/orderController.php";


  
  
  $funcionario = new EmployeeController();
  $clientes = new ClientController();
  $produto = new ProductController();
  $category = new CategoryController();
  $pedido = new OrderController();


  session_start();
  if(!isset($_SESSION["user"])){
	header("location:entrar.php");
  }
  $total_funcionarios = $funcionario->totalFuncionarios();
  $total_produtos = $produto->totalProdutos();
  $total_clientes = $clientes->totalClientes();
  $total_pedidos= $pedido->totalPedidos();


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" href="asset/css/tablestyle.css">
	<!-- My CSS -->
	 <link rel="stylesheet" href="asset/css/main.css">
	 <link rel="stylesheet" href="asset/css/tablestyle.css?=123">
	 <link rel="stylesheet" href="asset/css/categorystyle.css?=123">
	 <link rel="stylesheet" href="asset/css/productstyle.css?=123">
	 <link rel="stylesheet" href="asset/css/funcionario.css?=123">


	<title>OrderFud</title>





</head>
<body>


<!-- SIDEBAR -->
	<?php include "./pages/sideBar.php"?>
<!-- SIDEBAR -->

<!-- CONTENT -->
<section id="content">
	<!-- NAVBAR -->
	<?php include "./pages/navBar.php"?>

	<!-- NAVBAR -->

	<!-- MAIN -->
	<main>
		<?php 
			
			$rota = $_GET["rota"];
			switch($rota){
				case "home":
				case "/":
					$_SESSION['user']['tipo']=='Funcionária'?include "./pages/pedidos.php":include "./pages/home.php";
					
					break;
				case "funcionario":
					include "./pages/funcionario.php";
					break;
				case "cliente":
					include "./pages/cliente.php";
					break;
				case "produto":
					include "./pages/produto.php";
					break;
				case "categoria":
					include "./pages/categoria.php";
					break;
				case "pedidos":
					include "./pages/pedidos.php";
				    break;
				case "editar":
					include "./pages/editar.php";
					break;
				default :
					$_SESSION['user']['tipo']=='Funcionária'?include "./pages/pedidos.php":include "./pages/home.php";


			}
		?>
	</main>
	<!-- MAIN -->
</section>
<!-- CONTENT -->





	

	<script src="./asset/js/main.js"></script>
</body>
</html>