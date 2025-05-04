<?php
class ProductModel{
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
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
    public function cadastrarProduto($nome, $descricao, $preco, $categoria, $caminhoImagem) {
        try {
            $query = $this->connection->prepare(
                "INSERT INTO produto (nome, descricao, preco, idCategoria, imagem) 
                 VALUES (:nome, :descricao, :preco, :idCategoria, :imagem)"
            );

            $params = [
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':preco' => $preco,
                ':idCategoria' => $categoria,
                ':imagem' => $caminhoImagem
            ];

            var_dump($params);

            return $query->execute($params);

        } catch (PDOException $e) {
            error_log("Erro no banco: " . $e->getMessage());
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
    
    public function buscarPorCategoria($idCategoria) {
        try {
            $sql = "SELECT p.*, c.categoria AS Categoria 
                    FROM produto p 
                    JOIN categoria c ON p.idCategoria = c.idCategoria 
                    WHERE p.idCategoria = :idCategoria";
            $query = $this->connection->prepare($sql);
            $query->bindParam(':idCategoria', $idCategoria);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar produtos por categoria: " . $e->getMessage();
            return [];
        }
    }

    private function processarUploadImagem($imagem) {
        if ($imagem['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload da imagem');
        }

        $diretorioUpload = __DIR__ . '/../public/uploads/produtos/';
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0777, true);
        }

        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoCompleto = $diretorioUpload . $nomeArquivo;

        if (!move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
            throw new Exception('Falha ao mover arquivo');
        }

        return '/public/uploads/produtos/' . $nomeArquivo;
    }

    public function alterarStatus($idProduto, $estado) {
        try {
            $query = $this->connection->prepare(
                "UPDATE produto SET estado = :estado WHERE idProduto = :idProduto"
            );

            $params = [
                ':estado' => $estado,
                ':idProduto' => $idProduto
            ];
            $resultado = $query->execute($params);
            echo"<script>alert('Estado do produto alterado com sucesso!');</script>";
            if (!$resultado) {
                error_log("Erro ao executar query: " . print_r($query->errorInfo(), true));
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Erro ao alterar estado: " . $e->getMessage());
            return false;
        }
    }

}
?>
