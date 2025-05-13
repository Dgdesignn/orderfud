<?php
header('Content-Type: application/json');
require_once "../controllers/NotificacaoController.php";

$notificacaoController = new NotificacaoController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($notificacaoController->getNovasNotificacoes());
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['idPedido'])) {
            echo json_encode($notificacaoController->marcarComoLida($data['idPedido']));
        }
        break;
}
?> 