<?php

require_once "../models/categoryModels.php";
require_once "../config/database.php";
if (!class_exists('CategoryController')){
    class CategoryController{
        private $connection;
        private $model; 
    
        public function __construct(){
            $this->connection= new Database();
            $this->model = new CategoryModel($this->connection->getConnection());
        }
    
        public function adicionarCategoria( $nome){
            return $this->model->adicionarCategoria( $nome);
    
        }
        public function buscarCategoria(){
            return $this->model->listar();
        }   
        public function deletar($idCategoria){
            return $this->model->deletar($idCategoria);
        }
        public function update($categoria, $idCategoria){
            return $this->model->update($categoria, $idCategoria);
        }
        public function cadastrarCategoria($nome, $imagem){       
            $novaImagem = $this->upload($imagem);
            return $this->model->cadastrarCategoria($nome, $novaImagem);
        }
        function upload($file){
    
            $arquivo =null;
            if (isset($file['imagem'])) {
                $erroUpload = $file['imagem']['error'];
                if ($erroUpload === UPLOAD_ERR_OK) {
                   
                    $nomeArquivo = $file['imagem']['name'];
                    $tmpArquivo = $file['imagem']['tmp_name'];
                    $diretorioDestino = 'uploads/Categorias/';
                    
                    if (!is_dir($diretorioDestino)) {
                        mkdir($diretorioDestino, 0777, true);
                    }
            
                    $nomeArquivoUnico = $diretorioDestino . uniqid() . '-' . basename($nomeArquivo);
                    $arquivo=$nomeArquivoUnico;
                   
                    if (move_uploaded_file($tmpArquivo, $nomeArquivoUnico)) {
                       // echo 'Imagem carregada com sucesso: <a href="' . $nomeArquivoUnico . '" target="_blank">Ver imagem</a>';
                    } else {
                        echo 'Erro: Não foi possível enviar a imagem. Verifique as permissões do diretório.';
                    }
                } else {
                  
                    echo 'Erro no upload. Código do erro: ' . $erroUpload;
                }
            } else {
                echo 'Erro: Nenhum arquivo foi enviado ou ocorreu um erro no upload.';
            }
            return $arquivo;
        }   
    
    }
}

?>