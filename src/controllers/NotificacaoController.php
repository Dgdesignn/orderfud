<?php
require_once "../models/orderModels.php";

class NotificacaoController {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
    }
    
    public function getNovasNotificacoes() {
        try {
            $novosPedidos = $this->orderModel->getNewOrders();
            return [
                'success' => true,
                'notificacoes' => $novosPedidos
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function marcarComoLida($idPedido) {
        try {
            $this->orderModel->marcarPedidoComoNotificado($idPedido);
            return ['success' => true];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
?> 