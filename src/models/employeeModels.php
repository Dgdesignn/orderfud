<?php 

class EmployeeModel{
    private $connection;

    public function __construct($connection){
        $this->connection=$connection;
    }
    public function inserirFuncionario($nome, $telefone, $senha, $tipo){
        try {
            $query=$this->connection ->prepare("INSERT INTO funcionario (nome, telefone, senha, tipo) VALUES (:nome, :telefone, :senha, :tipo)");
            $query->bindParam(':nome', $nome);
            $query->bindParam(':telefone', $telefone);
            $query->bindParam(':senha', $senha);
            $query->bindParam(':tipo', $tipo);

            return $query->execute();

        } catch (PDOException $e) {
          echo "erro".$e->getMessage();
        }
    }
    
    public function buscarFuncionarios(){
        try {
            $sql = ("SELECT * FROM funcionario ");
            $result=$this->connection ->prepare($sql);
            $result->execute();
            return $result->FetchALL(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
           echo "erro".$e->getMessage();
        }
    }

    public function buscarFuncionario($valor, $coluna){
        try {
            $sql = ("SELECT * FROM Funcionario WHERE $coluna Like :valor") ;
            $response =$this->connection->prepare($sql);
            $response->bindParam(':valor', $valor);
            $response->execute();
            return $response->FetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "erro".$e->getMessage();
        }
    }

    public function editarFuncionario($idFuncionario, $nome, $telefone, $senha, $imagem, $tipo){
        try {
           $sql = ("UPDATE  funcionario SET nome=:nome, telefone=:telefone, senha=:senha, imagem =:imagem, tipo=:tipo WHERE idFuncionario=:idFuncionario");
           $query = $this->connection->prepare($sql);
           $query->bindParam(':idFuncionario', $idFuncionario);
           $query->bindParam(':nome', $nome);
           $query->bindParam(':telefone', $telefone);
           $query->bindParam(':senha', $senha);
           $query->bindParam(':imagem', $imagem);
           $query->bindParam(':tipo', $tipo);

           return $query->execute();
        } catch (PDOException $e) {
          echo "erro".$e->getMessage();
        }
    }
    public function deletarFuncionario($idFuncionario){
       try {
        $sql= ("DELETE FROM funcionario WHERE idFuncionario=:idFuncionario");
        $query=$this->connection->prepare($sql);
        $query->bindParam(':idFuncionario', $idFuncionario);
        return $query->execute();
       } catch (PDOException $e) {
        echo "erro".$e->getMessage();
       }
    }
    public function login($telefone, $senha){
        try {
           $sql = "SELECT * FROM funcionario WHERE telefone=:telefone ";
           $query=$this->connection->prepare($sql);
           $query->bindParam(':telefone', $telefone);
           $query->execute();
           $user = $query->Fetch(PDO::FETCH_ASSOC);
           if($user && password_verify( $senha, $user['senha']) ){
            return $user;
           }else{
            return false;
           }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function cadastrar($nome, $telefone, $senha, $imagem, $tipo) {
        $novaSenha= password_hash($senha, PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO funcionario (nome, telefone, senha, imagem, tipo) VALUES (:nome, :telefone, :senha, :imagem, :tipo)";
            $query = $this->connection->prepare($sql);
            $query->bindParam(':nome', $nome);
            $query->bindParam(':telefone', $telefone);
            $query->bindParam(':senha', $novaSenha); 
            $query->bindParam(':imagem', $imagem);
            $query->bindParam(':tipo', $tipo);  
            //return $query->execute();
            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
         } catch (PDOException $e) {
            echo "erro ao cadastrar". $e->getMessage();
            return false;
         }
    }
    public function verificarTelefone($telefone){
        try {
            $sql = ("SELECT COUNT(*) FROM Funcionario WHERE telefone = :telefone") ;
            $response =$this->connection->prepare($sql);
            $response->bindParam(':telefone', $telefone);
            $response->execute();
            return $response->FetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo "erro".$e->getMessage();
        }
       
    }
    public function totalFuncionarios() {
        try {
            $sql = "SELECT COUNT(*) AS total_funcionarios FROM funcionario";
            $query = $this->connection->prepare($sql);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['total_funcionarios']; // Retorna o número total de funcionários
            } else {
                echo"nao encontrado";
                return 0; // Se não houver funcionários
            }
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage(); 
            return 0; // Retorna 0 caso ocorra erro
        }
    }
    
}
    


    

?>