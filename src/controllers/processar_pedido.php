<?php
session_start();
require_once "orderController.php";

// Verificar se usuário está logado
if (!isset($_SESSION["client"])) {
    header("location: ../views/loginClient.php");
    exit; 
}

// Verificar se é uma requisição POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: ../views/shopping.php");
    exit;
}

try {
    // Verificar se todos os dados necessários foram enviados
    if (!isset($_POST['produtos']) || !isset($_POST['total'])) {
        throw new Exception("Dados do pedido incompletos");
    }

    $orderController = new OrderController();
    
    $clienteId = $_SESSION['client']['id'];
    $produtos = json_decode($_POST['produtos'], true);
    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';
    $total = floatval($_POST['total']);

    // Validar produtos
    if (!is_array($produtos) || empty($produtos)) {
        throw new Exception("Lista de produtos inválida");
    }

    // Criar o pedido
    $resultado = $orderController->criarPedido($clienteId, $produtos, $observacoes, $total);
    echo"<pre>";
    var_dump($produtos);
    echo"<br/>";
    echo"<br/>";
    //var_dump($resultado);
    echo"<br/>";
    echo"<br/>";


    if ($resultado['success']) {
        // Limpar carrinho e redirecionar para dashboard
        echo "
        <script>
            localStorage.removeItem('cartProducts');
            window.location.href = '../views/dashboard-client.php?success=true';
        </script>";
    } else {
        $_SESSION['erro'] = $resultado['message'];
        header("Location: ../views/checkout.php");
    }

} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao processar pedido: " . $e->getMessage();
    header("Location: ../views/checkout.php");
}
exit;
?> 