<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

session_start();
require_once "orderController.php";

$orderController = new OrderController();

// Verificar tipo de usuário e ID
$userType = $_GET['type'] ?? '';
$userId = $_GET['id'] ?? '';

while (true) {
    // Buscar novos pedidos ou atualizações
    $updates = $orderController->checkForUpdates($userType, $userId);
    
    if (!empty($updates)) {
        foreach ($updates as $update) {
            echo "data: " . json_encode($update) . "\n\n";
        }
    }
    
    ob_flush();
    flush();
    sleep(2); // Aguarda 2 segundos antes de verificar novamente
} 