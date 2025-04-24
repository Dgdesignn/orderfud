<?php
Class CarrinhoModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;

    } 
    public function addProduto($produto, $quantidade){
        try { 
            $query=$this->connection->prepare("INSERT INTO carrinho (produto, quantidade) VALUES (produto, quantidade)");
            $query->bindParam(':produto', $produto);
            $query->bindParam(':quantidade', $quantidade);  
            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
           }catch (PDOException $e) {
            echo "erro em adicionar". $e->getMessage();
                return false;
           }  
    }
    public function buscarCarrinho(){
        try {
         $sql = ("SELECT * FROM carrinho");
         $result=$this->connection->query($sql);
         $result->execute();
         return $result->fetchAll(PDO::FETCH_ASSOC);
 
 
        } catch (PDOException $e) {
         echo "erro ao selecionar cliente". $e->getMessage();
        }
         
 
    }
    public function editarQuantidade($produto, $quantidade){
        try {
            $sql = "UPDATE carrinho SET produto=:produto, quantidade=:quantidade WHERE id=:id";
            $query = $this->connection ->prepare($sql);
            $query->bindParam(':produto', $produto);
            $query->bindParam(':quantidade', $quantidade);
            return $query->execute();
            
        } catch (PDOException $e) {
           echo "erro".$e->getMessage();
        }
    }
    public function removerProduto($produto){
        try {
            $sql = " DELETE FROM cliente WHERE id =:id";
            $query=$this->connection->prepare($sql);
            $query->bindParam(':produto', $produto);
            if ($query->execute()) {
                return true;
            } else {
                return false;
            } 
        } catch (PDOException $e) {
            echo "erro".$e->getMessage();
        }       
    }
}
?>