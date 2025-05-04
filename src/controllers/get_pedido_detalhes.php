<?php
require_once "orderController.php";

if (isset($_GET['id'])) {
    $orderController = new OrderController();
    $resultado = $orderController->buscarDetalhesPedido($_GET['id']);
    
    header('Content-Type: application/json');
    echo json_encode($resultado);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'ID do pedido não fornecido'
    ]);
} 