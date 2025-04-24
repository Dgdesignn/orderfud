<?php
require_once "../models/employeeModels.php";
require_once "../config/database.php";
   
class EmployeeController{
    private $connection;
    private $model; 

    public function __construct(){
        $this->connection = new Database();
        $this->model = new EmployeeModel($this->connection->getConnection());
    }
    public function inserirFuncionario($nome, $telefone, $senha, $tipo){
        echo" Senha controller ",$telefone;
        return $this->model->inserirFuncionario($nome, $telefone, $senha, $tipo);
    }
    public function buscarFuncionarios(){
        return $this->model->buscarFuncionarios(null);
    }
    public function buscarFuncionario($valor, $coluna){
        return $this->model->buscarFuncionario($valor, $coluna);
    }
    public function editarFuncionario($idFuncionario, $nome, $telefone, $senha, $imagem, $tipo){
        return $this->model->editarFuncionario($idFuncionario, $nome, $telefone, $senha, $imagem, $tipo);
    }
    public function deletarFuncionario($idFuncionario){
        return $this->model->deletarFuncionario($idFuncionario);
    }
    
    public function login($telefone, $senha){
       $user= $this->model->login($telefone, $senha);
      
       if($user){
        $_SESSION['user']=$user;
        var_dump($user);
        if($user['tipo'] == 'Funcionária'){
            header("location:../views/dashboarbadmin.php?rota=pedidos");

        }else{
            header("location:../views/dashboarbadmin.php?rota=home");
        }

        
        exit();
       }else{
            return false;
       }
    
    }

    public function logged(){
        
       if(isset($_SESSION["user"])){
           header("location:../views/dashboarbadmin.php?rota=home");
            exit();
       }else{
            header('location:../views/entrar.php');
       }
    }
    
    public function cadastrar($nome, $telefone, $senhaCriptografada, $imagem, $tipo){
        $verifica = $this->model->verificarTelefone($telefone);
       print_r($verifica[0]['COUNT(*)']);
    
        if($verifica[0]['COUNT(*)']>0){
            echo '<script>alert("Numero ja cadastrado, tente novamente")</script>';
                
           return;
        }
        $novaImagem = $this->upload($imagem);
        return $this->model->cadastrar($nome, $telefone, $senhaCriptografada, $novaImagem, $tipo);
       
      
    }
    private function upload($file){
        // Verifica se houve algum erro no upload
        if($file['error'] !== UPLOAD_ERR_OK) {
            error_log("Erro no upload: " . $file['error']);
            return null;
        }
        
        // Configurações
        $diretorioDestino = 'uploads/funcionaros/';
        $nomeArquivoUnico = $diretorioDestino . uniqid() . '-' . basename($file['name']);
        
        // Cria diretório se não existir
        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }
        
        // Move o arquivo
        if (move_uploaded_file($file['tmp_name'], $nomeArquivoUnico)) {
            return $nomeArquivoUnico;
        } else {
            error_log("Falha ao mover arquivo para: " . $nomeArquivoUnico);
            return null;
        }
    } 
    public function totalFuncionarios(){
        return  $this->model->totalFuncionarios();
    }

}
?>