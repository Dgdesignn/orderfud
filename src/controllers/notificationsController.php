<?php

require_once "../models/notificationsModels.php";
require_once "../config/database.php";

class NotificationsController{

    
    private $connection;
    private $model;

    public function __construct(){
        $this->connection = new Database();
        $this->model = new  NotificationsModel($this->connection->getConnection());
    }
    public function criar($funcionarioId, $pedidoId) {
        $mensagem = "Novo pedido #$pedidoId recebido";
        return $this->model->criarNotificacao($funcionarioId, $pedidoId, $mensagem);
    }

    public function listar($funcionarioId) {
        return $this->model->listarPorFuncionario($funcionarioId);
    }

    public function visualizar($notificacaoId) {
        return $this->model->marcarComoLida($notificacaoId);
        // Lógica para mostrar detalhes do pedido
    }
}
?>