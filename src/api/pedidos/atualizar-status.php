<?php
require_once "../../controllers/orderController.php";

header('Content-Type: application/json');

try {
    // Obter e validar dados
    $dados = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($dados['pedido_id']) || !isset($dados['status'])) {
        throw new Exception('Dados incompletos');
    }

    if (!is_numeric($dados['pedido_id'])) {
        throw new Exception('ID do pedido inválido');
    }

    // Processar atualização
    $orderController = new OrderController();
    $resultado = $orderController->atualizarStatusPedido(
        intval($dados['pedido_id']), 
        $dados['status']
    );
    
    if ($resultado['success']) {
        echo json_encode([
            'success' => true,
            'message' => $resultado['message']
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
