<?php
class ProductModel{
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function inserirProduto($nome, $descricao, $preco, $categoria){
        try {
         $query=$this->connection->prepare("INSERT INTO produto ( nome, descricao, preco, idCategoria ) VALUES ( :nome, :descricao, :preco, :idCategoria)"); 
        
         $query->bindParam(':nome', $nome);
         $query->bindParam(':descricao', $descricao);
         $query->bindParam(':preco', $preco);
         $query->bindParam(':idCategoria', $categoria);
         return $query->execute();
       
        } catch (PDOException $e) {
           echo "erro". $e->getMessage();
        }

    }
    

    /*public function buscar(){
        try {
        $sql= ("SELECT p.idProduto, p.nome, p.descricao, p.preco, c.categoria 
        FROM `produto` as p 
        JOIN categoria as c WHERE p.idCategoria = c.idCategoria");
        $query=$this->connection->prepare($sql);
        $query->execute();
        return $query->FetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "erro".$e->getMessage();
        }
    }*/




    public function buscarCategoria(){
        try {
           
            $sql = "SELECT p.idProduto, p.nome, p.descricao, p.preco, c.categoria AS Categoria  FROM produto AS p  JOIN categoria AS c ON p.idCategoria = c.idCategoria";
            $query = $this->connection->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function deletar($idProduto){
        try {
         $sql = ("DELETE FROM produto WHERE idProduto=:idProduto");
         $query= $this->connection->prepare($sql);
         $query->bindParam(':idProduto',$idProduto);
         return $query->execute();
        } catch (PDOException $e) {
            echo "erro".$e->getMessage();
        }
    }
     public function updateProduto($nome, $descricao, $preco, $categoria, $id,$imagem){
        try {
            $uploadDir = 'uploads/Produtos/'; 
            $uploadFile = $uploadDir . basename($imagem['name']);
            $sql = "UPDATE produto SET nome=:nome, descricao=:descricao, preco=:preco, idCategoria=:idCategoria,imagem=:imagem  WHERE idProduto=:idProduto";
            $query = $this->connection ->prepare($sql);
            $query->bindParam(':nome', $nome);
            $query->bindParam(':descricao', $descricao);
            $query->bindParam(':preco', $preco);
            $query->bindParam(':idCategoria', $categoria);
            $query->bindParam(':idProduto', $id);
            $query->bindParam(':imagem',$uploadFile);

            return $query->execute();
        } catch (PDOException $e) {
            echo "erro". $e->getMessage();
        }
    }
    public function cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem){
        try {
            // Verifica se o caminho da imagem é válido
            if($imagem === null || !file_exists($imagem)) {
                throw new Exception("Caminho da imagem inválido ou arquivo não existe");
            }
            
            $query = $this->connection->prepare("INSERT INTO produto (nome, descricao, preco, idCategoria, imagem) 
                                               VALUES (:nome, :descricao, :preco, :idCategoria, :imagem)"); 
            
            $query->bindParam(':nome', $nome);
            $query->bindParam(':descricao', $descricao);
            $query->bindParam(':preco', $preco);
            $query->bindParam(':idCategoria', $categoria);
            $query->bindParam(':imagem', $imagem);
            
            if ($query->execute()) {
                return true;
            } else {
                // Se falhar, remove o arquivo de imagem que foi enviado
                if(file_exists($imagem)) {
                    unlink($imagem);
                }
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro no banco: " . $e->getMessage());
            // Remove o arquivo em caso de erro
            if(isset($imagem) && file_exists($imagem)) {
                unlink($imagem);
            }
            return false;
        } catch (Exception $e) {
            error_log("Erro geral: " . $e->getMessage());
            return false;
        }
    }
    public function listar(){
        try {
            $sql = "SELECT p.idProduto, p.nome, p.descricao, p.preco,p.imagem, c.categoria AS Categoria  FROM produto AS p  JOIN categoria AS c ON p.idCategoria = c.idCategoria";
            $query = $this->connection->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return [];
        }
    }
    public function totalProdutos(){
        try {
            $sql = "SELECT COUNT(*) AS total_produtos FROM produto";
            $query = $this->connection->prepare($sql);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['total_produtos'];
            } else {
                echo"nao encontrado";
                return 0;  
            }
        } catch (PDOException $e) {
            echo "Erro" .$e->getMessage();
            return 0;
        }
    }
    


}
?>
