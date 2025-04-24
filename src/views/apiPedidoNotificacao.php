<?php
session_start();
require_once 'config.php';
require_once 'PedidoModel.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Processar pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $_SESSION['user_id'];
    $produtos = json_decode($_POST['produtos'], true);
    
    try {
        $model = new OrderModel($db);
        $idPedido = $model->criarPedido($idCliente, $idCarteira, $produtos);
        
        // Redirecionar com mensagem de sucesso
        $_SESSION['pedido_sucesso'] = "Pedido #$idPedido realizado com sucesso!";
        header('Location: confirmacao_pedido.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['pedido_erro'] = "Erro ao processar pedido: " . $e->getMessage();
        header('Location: carrinho.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}