<?php
session_start();
if(!isset($_SESSION["client"])){
    header("location: loginClient.php");
    exit;
}

require "../controllers/orderController.php";
$orderController = new OrderController();
$pedidos = $orderController->buscarPedidosCliente($_SESSION['client']['id']);

// Definir página atual
$pagina = isset($_GET['rota']) ? $_GET['rota'] : 'pedidos';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OrderFüd</title>
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="asset/css/main.css">
    <link rel="stylesheet" href="asset/css/dashboard-client.css">
</head>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">OrderFüd</span>
        </a>
        <ul class="side-menu top">
            <li class="<?php echo $pagina == 'pedidos' ? 'active' : ''; ?>">
                <a href="?rota=pedidos">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">Meus Pedidos</span>
                </a>
            </li>
            <li class="<?php echo $pagina == 'perfil' ? 'active' : ''; ?>">
                <a href="?rota=perfil">
                    <i class='bx bxs-user'></i>
                    <span class="text">Meu Perfil</span>
                </a>
            </li>
            <li>
                <a href="website.php?rota=produtos">
                    <i class='bx bxs-cart-add'></i>
                    <span class="text">Novo Pedido</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="?rota=logout" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Sair</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Buscar...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <a href="#" class="profile">
                <i class='bx bxs-user'></i>
                <span><?php echo $_SESSION['client']['nome']; ?></span>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Pedido realizado com sucesso! Acompanhe o status abaixo.
                </div>
            <?php endif; ?>

            <?php 
            switch($pagina){
                case 'pedidos':
                    include "./pages/client/pedidos.php";
                    break;
                case 'perfil':
                    include "./pages/client/perfil.php";
                    break;
                case 'logout':
                    include "./pages/client/logutcliente.php";
                    break;
                default:
                    include "./pages/client/pedidos.php";
            }
            ?>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="./asset/js/main.js"></script>
</body>
</html> 