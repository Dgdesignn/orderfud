<?php
class CategoryModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;
    }

    public function adicionarCategoria( $nome){
        try {
            $query=$this->connection->prepare("INSERT INTO Categoria(categoria) VALUES ( :categoria)");
          
            $query->bindParam(':categoria', $nome);
            return $query->execute();
        } catch (PDOException $e) {
           echo "erro". $e->getMessage();
        }
    }
    public function buscarCategoria(){
        try {
            $sql = ("SELECT * FROM Categoria");
            $result=$this->connection->query($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
           echo "wrong".$e->getMessage();
        }
    }
    public function deletar($idCategoria){
        try {
            $sql = ("DELETE FROM categoria WHERE idCategoria=:idCategoria ");
            $query=$this->connection->prepare($sql);
            $query->bindParam(':idCategoria', $idCategoria);
            return $query->execute();

        } catch (PDOException $e) {
           echo "erro",$e->getMessage();
        }
    }
    public function update($categoria, $idCategoria){
       try {
        $sql = "UPDATE categoria SET categoria=:categoria WHERE idCategoria=:idCategoria";
        $query = $this->connection-> prepare($sql);
        $query->bindParam(':categoria', $categoria);
        $query->bindParam(':idCategoria', $idCategoria);
        return $query->execute();
       } catch (PDOException $e) {
         echo "erro". $e->getMessage();
       }
    }
    public function cadastrarCategoria($categoria, $imagem){
        try {
            $query=$this->connection->prepare("INSERT INTO Categoria (categoria, imagem) VALUES ( :categoria, :imagem)");
            $query->bindParam(':categoria', $categoria);
            $query->bindParam(':imagem', $imagem); 
            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
           echo "erro". $e->getMessage();

           return false;
        }
    }
    public function listar(){
        try {
            $sql = "SELECT * FROM Categoria";
            $query = $this->connection->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return [];
        }
    }
}
?>