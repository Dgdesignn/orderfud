
<?php
require_once "../../controllers/orderController.php";

header('Content-Type: application/json');

try {
    // Validar dados recebidos
    $dados = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($dados['pedido_id']) || !isset($dados['status'])) {
        throw new Exception('Dados incompletos: pedido_id e status são obrigatórios');
    }

    // Validar pedido_id
    if (!is_numeric($dados['pedido_id'])) {
        throw new Exception('ID do pedido inválido');
    }
    
    $orderController = new OrderController();
    $resultado = $orderController->atualizarStatusPedido($dados['pedido_id'], $dados['status']);
    
    if ($resultado['success']) {
        http_response_code(200);
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
