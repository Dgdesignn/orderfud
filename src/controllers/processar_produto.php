<?php
require_once __DIR__ . "/../models/productModels.php";
require_once __DIR__ . "/productController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = ['success' => false, 'message' => ''];
    
    try {
        // Validar dados recebidos
        if (empty($_POST['nome']) || empty($_POST['preco']) || 
            empty($_POST['categoria']) || empty($_POST['descricao']) || 
            empty($_FILES['imagem'])) {
            throw new Exception('Todos os campos são obrigatórios');
        }

        $produto = new ProductController();
        
        $nome = trim($_POST['nome']);
        $descricao = trim($_POST['descricao']);
        $preco = floatval($_POST['preco']);
        $categoria = intval($_POST['categoria']);
        $imagem = $_FILES['imagem'];

        // Cadastrar produto
        $resultado = $produto->cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem);

        if ($resultado) {
            $response['success'] = true;
            $response['message'] = 'Produto cadastrado com sucesso!';
        } else {
            throw new Exception('Erro ao cadastrar produto '+nome);
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    // Retorna resposta em JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} 