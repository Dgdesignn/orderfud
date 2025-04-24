<?php
 require_once "../models/productModels.php";
 require_once "../config/database.php";
 if (!class_exists('ProductController')){
    class ProductController{
        private $connection;
        private $model;
    
        public function __construct(){
            $this->connection = new Database();
            $this->model = new ProductModel($this->connection->getConnection());
        }
        public function deletar($idProduto){
            return $this->model->deletar( $idProduto);
        }
        public function buscarCategoria(){
            return $this->model->listar();
    
        }
        public function updateProduto($nome, $descricao, $preco, $categoria, $id){
            return $this->model->updateProduto($nome, $descricao, $preco, $categoria, $id);
        }
        public function cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem){
            // Processar upload da imagem
            $novaImagem = $this->upload($imagem);
            
            // Se o upload falhou, retorne false
            if($novaImagem === null) {
                return false;
            }
            
            return $this->model->cadastrarProduto($nome, $descricao, $preco, $categoria, $novaImagem);
        }
        
        private function upload($file){
            // Verifica se houve algum erro no upload
            if($file['error'] !== UPLOAD_ERR_OK) {
                error_log("Erro no upload: " . $file['error']);
                return null;
            }
            
            // Configurações
            $diretorioDestino = 'uploads/Produtos/';
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
    
        public function totalProdutos(){
            return $this->model->totalProdutos();
        }
    
        
        
    }
 }

?>