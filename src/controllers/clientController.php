<?php

require_once "../models/clientModels.php";
require_once "../config/database.php";

class ClientController{

    
    private $connection;
    private $model;

    public function __construct(){
        $this->connection = new Database();
        $this->model = new ClientModel($this->connection->getConnection());
    }

    public function cadastro( $nome, $telefone, $senha, $imagem){
        $verifica=$this->model->verificarTelefone($telefone);
        if($verifica[0]["COUNT(*)"]>0){
            echo "<script>alert('Erro: Número ja cadastrado');</script>";
            return;
        }
        $novaImagem = $this->upload($imagem);
        return $this->model->cadastro( $nome, $telefone, $senha, $novaImagem);
    } 

    function upload($file){
        $arquivo =null;
        if (isset($file['imagem'])) {
            $erroUpload = $file['imagem']['error'];
            if ($erroUpload === UPLOAD_ERR_OK){
               
                $nomeArquivo = $file['imagem']['name'];
                $tmpArquivo = $file['imagem']['tmp_name'];
                $diretorioDestino = 'uploads/clientes/';
                
                if (!is_dir($diretorioDestino)) {
                    mkdir($diretorioDestino, 0777, true);
                }
        
                $nomeArquivoUnico = $diretorioDestino . uniqid() . '-' . basename($nomeArquivo);
                $arquivo=$nomeArquivoUnico;
               
                if (move_uploaded_file($tmpArquivo, $nomeArquivoUnico)) {
                    echo 'Imagem carregada com sucesso: <a href="' . $nomeArquivoUnico . '" target="_blank">Ver imagem</a>';
                } else {
                    echo 'Erro: Não foi possível enviar a imagem. Verifique as permissões do diretório.';
                }
            } else {
              
                echo 'Erro no upload. Código do erro: ' . $erroUpload;
            }
        } else {
            $arquivo = '';
        }
        return $arquivo;
    }   

    public function buscarClientes() {
        return $this->model->buscarClientesComTotalPedidos();
    }
    public function buscarCliente($coluna, $valor ){
        return $this->model->buscarCliente($coluna, $valor);
    }
    public function deletar($id){
        return $this->model->deletar($id);
    }
    public function editar($id, $nome, $telefone, $senha,){
        return $this->model->editar($id, $nome, $telefone, $senha,);
    }

    public function login($telefone, $senha){
        $user = $this->model->login($telefone, $senha);
        
        if($user){
            // Iniciar a sessão se ainda não estiver iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Armazenar dados do usuário na sessão
            $_SESSION['client'] = [
                'id' => $user['id'],
                'nome' => $user['nome'],
                'telefone' => $user['telefone']
            ];
            
            return true;
        }
        
        return false;
    }

    // Adicionar método para verificar se está logado
    public function isLoggedIn(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['client']);
    }

    // Adicionar método para logout
    public function logout(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['client']);
        session_destroy();
    }

    public function totalClientes(){
        return $this->model->totalClientes();

    }
    
    
    
    
    public function bloquearCliente($id){
        // Valida o ID
        if(!is_numeric($id) || $id <= 0) {
            return false;
        }
        
        try {
            return $this->model->bloquearCliente($id);
        } catch (Exception $e) {
            error_log('Erro no Controller ao bloquear cliente: ' . $e->getMessage());
            return false;
        }
    }
    
    // Remova o método bloquearClientes() pois não é necessário
   



}
?>