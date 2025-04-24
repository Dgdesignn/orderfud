<?php
class NotificationsModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;

    } public function criarNotificacao($funcionarioId, $pedidoId, $mensagem) {
       try {
        $sql= "INSERT INTO notificacoes 
        (funcionario_id, pedido_id, mensagem) 
        VALUES (?, ?, ?)";

        $query= $this->connection->prepare($sql);
        return $query->execute([$funcionarioId, $pedidoId, $mensagem]);
       } catch (PDOException $e) {
        echo "erro".$e->getMessage();
     }xcvb
    }

    public function listarPorFuncionario($funcionarioId) {
       try {
        $sql = "SELECT n.*, p.data as data_pedido 
        FROM notificacoes n
        JOIN Pedido p ON n.pedido_id = p.idPedido
        WHERE n.funcionario_id = ? 
        ORDER BY n.data_criacao DESC";

        $query= $this->connection->prepare($sql);
        $query->execute([$funcionarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }catch (PDOException $e) {
        echo "erro".$e->getMessage();
     }
    }

    public function marcarComoLida($notificacaoId) {
      try {
        $sql = "UPDATE notificacoes SET lida = TRUE WHERE id = ?";
        $query= $this->connection->prepare($sql);
        return $sql->execute([$notificacaoId]);
      } catch (PDOException $e) {
        echo "erro".$e->getMessage();
     }
    }
}

?> 