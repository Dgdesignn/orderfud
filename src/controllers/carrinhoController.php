<?php
require_once "../models/carrinhoModels.php";
require_once "../config/database.php";

Class CarrinhoController{

    private $connection;
    private $model;
    private $ProdutoModel;


    public function __construct(){
        $this->connection = new Database();
        $this->model = new CarrinhoModel($this->connection->getConnection());
    }
    public function addIProduto($produto, $quantidade) {
        return $this->model->addproduto($produto, $quantidade);
    }
    public function  buscarCarrinho(){
        return $this->model->buscarCarrinho();
    }
    public function editarQuantidade($produto, $quantidade){
        return $this->model->editarQuantidade($produto, $quantidade);
    }
    public function removerProduto($produto){
        return $this->model->removerProduto($produto);
    }
    public function mostrarCarrinho($usuario_id){
        $produtoCarrinho = $this->model->mostrarCarrinho($usuario_id);
        $detalhesProduto = [];
        foreach ($produtoCarrinho as $produto){
            $detalhesProduto[] = array_merge($produto, $this->model->buscar($produto['produto_id']));
        }
      


    }



}
?>