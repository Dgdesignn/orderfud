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
  
  public function criarPedido($clienteId, $produtos, $observacoes, $total) {
      try { 
          // Validações básicas
          if (empty($clienteId) || empty($produtos) || empty($total)) {
              throw new Exception("Dados incompletos para criar pedido");
          }

          if (!is_array($produtos) || empty($produtos)) {
              throw new Exception("Lista de produtos inválida");
          }

          $pedidoId = $this->model->criarPedido($clienteId, $produtos, $observacoes, $total);
          
          if ($pedidoId) {
              return [
                  'success' => true,
                  'pedido_id' => $pedidoId,
                  'message' => 'Pedido criado com sucesso!'
              ];
          }

          throw new Exception("Erro ao criar pedido");

      } catch (Exception $e) {
          error_log("Erro no controller ao criar pedido: " . $e->getMessage());
          return [
              'success' => false,
              'message' => $e->getMessage()
          ];
      }
  }

  public function buscarPedidosCliente($clienteId) {
      try {
          if (empty($clienteId)) {
              throw new Exception("ID do cliente não fornecido");
          }

          return $this->model->buscarPedidosCliente($clienteId);
      } catch (Exception $e) {
          error_log("Erro ao buscar pedidos do cliente: " . $e->getMessage());
          return [];
      }
  }

  public function atualizarStatusPedido($pedidoId, $novoStatus) {
      try {
          if (empty($pedidoId) || empty($novoStatus)) {
              throw new Exception("Dados incompletos para atualizar status");
          }

          $resultado = $this->model->atualizarStatusPedido($pedidoId, $novoStatus);
          
          if ($resultado) {
              return [
                  'success' => true,
                  'message' => 'Status atualizado com sucesso!'
              ];
          }

          throw new Exception("Erro ao atualizar status do pedido");

      } catch (Exception $e) {
          error_log("Erro ao atualizar status: " . $e->getMessage());
          return [
              'success' => false,
              'message' => $e->getMessage()
          ];
      }
  }

  public function buscarDetalhesPedido($pedidoId) {
      try {
          if (empty($pedidoId)) {
              throw new Exception("ID do pedido não fornecido");
          }

          $detalhes = $this->model->buscarDetalhesPedido($pedidoId);
          
          if ($detalhes) {
              return [
                  'success' => true,
                  'data' => $detalhes
              ];
          }

          return [
              'success' => false,
              'message' => 'Pedido não encontrado'
          ];

      } catch (Exception $e) {
          error_log("Erro ao buscar detalhes do pedido: " . $e->getMessage());
          return [
              'success' => false,
              'message' => $e->getMessage()
          ];
      }
  }

  public function obterEstatisticas() {
      try {
          $total = $this->model->totalPedidos();
          $porStatus = $this->model->pedidosPorStatus();

          return [
              'success' => true,
              'data' => [
                  'total_pedidos' => $total,
                  'pedidos_por_status' => $porStatus
              ]
          ];

      } catch (Exception $e) {
          error_log("Erro ao obter estatísticas: " . $e->getMessage());
          return [
              'success' => false,
              'message' => 'Erro ao obter estatísticas'
          ];
      }
  }

  // Método auxiliar para validar dados do pedido
  private function validarDadosPedido($dados) {
      $erros = [];

      if (empty($dados['cliente_id'])) {
          $erros[] = "ID do cliente não fornecido";
      }

      if (empty($dados['produtos']) || !is_array($dados['produtos'])) {
          $erros[] = "Lista de produtos inválida";
      }

      if (!isset($dados['total']) || $dados['total'] <= 0) {
          $erros[] = "Total do pedido inválido";
      }

      return $erros;
  }

  public function buscarTodosPedidos() {
      try {
          return $this->model->buscarTodosPedidos();
      } catch (Exception $e) {
          error_log("Erro ao buscar todos os pedidos: " . $e->getMessage());
          return [];
      }
  }
}
    
?>