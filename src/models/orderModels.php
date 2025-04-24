<?php 
class OrderModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;
    }
   public function totalPedidos(){
    try {
        $sql = "SELECT COUNT(*) AS total_pedidos FROM pedido";
        $query = $this->connection->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['total_pedidos'];
        } else {
            echo"nao encontrado";
            return 0; 
        }
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage(); 
        return 0; 
    }
   }public function criarPedido($idCliente, $produtos) {
    $this->connection->beginTransaction();
    
    try {
        // 1. Criar o pedido
        $stmt = $this->connection->prepare("INSERT INTO pedido (data, fk_Cliente_Carteira_id, status) 
                                   VALUES (NOW(), ?, 'pendente')");
        $stmt->execute([$idCliente]);
        $idPedido = $this->connection->lastInsertId();
        
        // 2. Adicionar produtos ao pedido
        foreach ($produtos as $produto) {
            $stmt = $this->connection->prepare("INSERT INTO Pedido_Produto 
                                      (fk_Pedido_idPedido, fk_Produto_idProduto, quantidade, preco_unitario) 
                                      VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $idPedido, 
                $produto['id'], 
                $produto['quantity'], 
                $produto['price']
            ]);
        }
        
        $this->connection->commit();
        return $idPedido;
        
    } catch (Exception $e) {
        $this->connection->rollBack();
        throw $e;
    }
}
}

?>
   