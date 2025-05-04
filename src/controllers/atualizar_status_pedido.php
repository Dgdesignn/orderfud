<?php
require_once "clientController.php";

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['cliente_id']) || !isset($data['status'])) {
        throw new Exception("Dados incompletos");
    }

    $clientController = new ClientController();
    $resultado = $clientController->atualizarStatus($data['cliente_id'], $data['status']);

    echo json_encode(['success' => $resultado]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 