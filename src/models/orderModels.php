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
   }
}

?>
   