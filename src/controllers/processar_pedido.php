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
    // Debug
    error_log("Dados recebidos: " . print_r($_POST, true));

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

    // Validar estrutura dos produtos
    foreach ($produtos as $produto) {
        if (!isset($produto['idProduto']) || !isset($produto['quantidade'])) {
            throw new Exception("Formato de produto inválido");
        }
    }
 
    // Debug
    error_log("Produtos formatados: " . print_r($produtos, true));

    // Criar o pedido
    $resultado = $orderController->criarPedido($clienteId, $produtos, $observacoes, $total);

    if ($resultado['success']) {
        echo "
        <script>
            localStorage.removeItem('cartProducts');
            window.location.href = '../views/dashboard-client.php?success=true';
        </script>";
    } else {
        throw new Exception($resultado['message']);
    }

} catch (Exception $e) {
    error_log("Erro no processamento do pedido: " . $e->getMessage());
    $_SESSION['erro'] = "Erro ao processar pedido: " . $e->getMessage();
    header("Location: ../views/checkout.php");
}
exit;
?> 