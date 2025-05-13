<?php
require_once "../../controllers/orderController.php";

header('Content-Type: application/json');

try {
    // Pegar dados do POST
    $dados = json_decode(file_get_contents('php://input'), true);
   // echo json_encode($dados);
   
    if (!isset($dados['pedido_id']) || !isset($dados['status'])) {
        throw new Exception('Dados incompletos');
    }
    
    $orderController = new OrderController();
    $resultado = $orderController->atualizarStatusPedido($dados['pedido_id'], $dados['status']);
    
    if ($resultado['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Status atualizado com sucesso'
        ]);
    } else {
        throw new Exception($resultado['message']);
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 