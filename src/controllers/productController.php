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
        public function cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem) {
            try {
                // Validações
                if (empty($nome) || empty($descricao) || $preco <= 0 || empty($categoria)) {
                    throw new Exception("Todos os campos são obrigatórios");
           
                }
                // Processar upload da imagem
                $caminhoImagem = $this->processarUploadImagem($imagem);
               
                // Cadastrar no banco
                $r =  $this->model->cadastrarProduto($nome, $descricao, $preco, $categoria, $caminhoImagem);
         
                return $r;
            } catch (Exception $e) {
                error_log('Erro ao cadastrar produto: ' . $e->getMessage());
                return false;
            }
        }
        
        private function processarUploadImagem($imagem) {
            if ($imagem['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Erro no upload da imagem');
            }

            // Ajusta o caminho para a pasta uploads/produto dentro de views
            $diretorioUpload = __DIR__ . '/../views/uploads/produto/';
            error_log("Tentando salvar em: " . $diretorioUpload); // Debug

            // Garante que o diretório existe
            if (!is_dir($diretorioUpload)) {
                if (!mkdir($diretorioUpload, 0777, true)) {
                    throw new Exception('Não foi possível criar o diretório de upload');
                }
            }

            // Verifica permissões
            if (!is_writable($diretorioUpload)) {
                throw new Exception('Diretório sem permissão de escrita: ' . $diretorioUpload);
            }

            // Gera nome único para o arquivo
            $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
            $nomeArquivo = uniqid() . '.' . $extensao;
            $caminhoCompleto = $diretorioUpload . $nomeArquivo;

            // Tenta mover o arquivo
            if (!move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
                error_log("Falha ao mover arquivo para: " . $caminhoCompleto);
                throw new Exception('Falha ao salvar imagem');
            }

            // Retorna o caminho relativo para salvar no banco
            return 'uploads/produto/' . $nomeArquivo;
        }
    
        public function totalProdutos(){
            return $this->model->totalProdutos();
        }
    
        public function buscarPorCategoria($idCategoria) {
            return $this->model->buscarPorCategoria($idCategoria);
        }
        
        public function alterarStatusProduto($idProduto, $estado) {
            try {
                if (empty($idProduto)) {
                    throw new Exception("ID do produto não informado");
                }
                
                // Converte para inteiro para garantir tipo correto
                $idProduto = intval($idProduto);
                $estado = intval($estado);
                
                return $this->model->alterarStatus($idProduto, $estado);
            } catch (Exception $e) {
                error_log('Erro ao alterar estado do produto: ' . $e->getMessage());
                return false;
            }
        }
    }
 }

?>