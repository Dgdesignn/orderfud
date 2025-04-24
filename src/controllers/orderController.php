<?php
require_once "../models/orderModels.php";
require_once "../config/database.php";
   
class OrderController{
    private $connection;
    private $model;
    private $NotificationsModel;

    public function __construct(){
        $this->connection = new Database();
        $this->model = new OrderModel($this->connection->getConnection());
    }
    public function totalPedidos(){
      return $this->model->totalPedidos();
    }

    public function finalizarPedido($idCliente, $idCarteira, $produtos) {
      try {
          $idPedido = $this->model->criarPedido($idCliente, $idCarteira, $produtos);
          
          // Aqui você pode adicionar lógica para notificar o funcionário
          $this->notificarFuncionario($idPedido);
          
          return ['success' => true, 'pedido_id' => $idPedido];
      } catch (Exception $e) {
          return ['success' => false, 'error' => $e->getMessage()];
      }
  }
  
  public function listarPedidos() {
      return $this->model->getPedidosParaFuncionario();
  }
  
  public function processarPedido($idPedido) {
      return $this->model->marcarPedidoComoProcessado($idPedido);
  }
  
  private function notificarFuncionario($idPedido) {
      // Implementação da notificação (veremos abaixo)
  }
  
}
    
?>