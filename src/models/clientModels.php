<?php
class ClientModel{

    private $connection;

    public function __construct($connection){
        $this->connection=$connection;

    } 
    public function cadastro($nome, $telefone, $senha, $imagem){
        $novaSenha= password_hash($senha, PASSWORD_DEFAULT);
       try { 
        $query=$this->connection->prepare("INSERT INTO cliente ( nome, telefone, senha, imagem) VALUES ( :nome, :telefone, :senha, :imagem)");
     
        $query->bindParam(':nome', $nome);
        $query->bindParam(':telefone', $telefone);
        $query->bindParam(':senha', $novaSenha);
        $query->bindParam(':imagem', $imagem);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
       }catch (PDOException $e) {
        echo "erro ao cadastrar cliente". $e->getMessage();
            return false;
       }  

    }
    public function buscarClientes(){
       try {
        $sql = ("SELECT * FROM cliente");
        $result=$this->connection->query($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);


       } catch (PDOException $e) {
        echo "erro ao selecionar cliente". $e->getMessage();
       }
        

    }

    public function buscarCliente($coluna, $valor){
        try {
            $sql = "SELECT * FROM cliente WHERE  $coluna LIKE :valor";
            $valor = "%$valor%";
            $resp = $this->connection->prepare($sql);
            $resp->bindParam(':valor',$valor);
            $resp->execute();

            return $resp->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "erro". $e->getMessage();
        }

    }

    public function editar($id, $nome, $telefone, $senha,  ){
        try {
            $sql = "UPDATE cliente SET nome = :nome, telefone = :telefone, senha = :senha, WHERE id=:id";
            $query = $this->connection ->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':nome', $nome);
            $query->bindParam(':telefone', $telefone);
            $query->bindParam(':senha', $senha);
            return $query->execute();
            

        } catch (PDOException $e) {
         echo "erro".$e->getMessage();
        }

    }
    

    public function deletar($id){
        try {
            $sql = " DELETE FROM cliente WHERE id =:id";
            $query=$this->connection->prepare($sql);
            $query->bindParam(':id', $id);
            return $query->execute();
        } catch (PDOException $e) {
           echo "erro".$e->getMessage();
        }
    }
    public function login($telefone, $senha){
       try {
        $sql = "SELECT * FROM cliente WHERE telefone=:telefone";
        $query=$this->connection->prepare($sql);
        $query->bindParam(':telefone', $telefone);
        $query->execute();
       $user = $query->fetchAll(PDO::FETCH_ASSOC);
       if($user && password_verify($senha, $user['senha']) ){
        return $user;
       }else{
        return false;
       }
     }catch (PDOException $e) {
          return false;
     }

      
    }
    public function verificarTelefone($telefone){
        try {
            $sql = ("SELECT COUNT(*) FROM cliente WHERE telefone = :telefone") ;
            $response =$this->connection->prepare($sql);
            $response->bindParam(':telefone', $telefone);
            $response->execute();
            return $response->FetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "erro".$e->getMessage();
        } 
       
    }
    public function totalClientes() {
        try {
            $sql = "SELECT COUNT(*) AS total_clientes FROM cliente";
            $query = $this->connection->prepare($sql);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['total_clientes']; // Retorna o número total de funcionários
            } else {
                echo"nao encontrado";
                return 0; // Se não houver funcionários
            }
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage(); 
            return 0; // Retorna 0 caso ocorra erro
        }
    }



    
    public function bloquearCliente($id){
        try {
            // 1. Primeiro busca o status atual
            $sqlSelect = "SELECT bloqueado FROM cliente WHERE id = ?";
            $querySelect = $this->connection->prepare($sqlSelect);
            $querySelect->execute([$id]);
            $result = $querySelect->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return false; // Cliente não encontrado
            }
            
            // 2. Inverte o status (0 vira 1, 1 vira 0)
            $novoStatus = $result['bloqueado'] ? 0 : 1;
            
            // 3. Atualiza o status
            $sqlUpdate = "UPDATE cliente SET bloqueado = ? WHERE id = ?";
            $queryUpdate = $this->connection->prepare($sqlUpdate);
            return $queryUpdate->execute([$novoStatus, $id]);
            
        } catch (PDOException $e) {
            error_log('Erro ao bloquear cliente: ' . $e->getMessage());
            return false;
        }
    }

   
    
}
?>