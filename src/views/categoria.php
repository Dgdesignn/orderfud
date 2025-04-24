<?php
require "../controllers/productController.php";
require "../controllers/categoryController.php";

$categorias = new CategoryController();
$listaCategoria= $categorias->buscarCategoria();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome=$_POST["nome"];
    $descricao=$_POST["descricao"];
    $preco=$_POST["preco"];
    $categoria=$_POST["categoria"];
    $imagem =$_FILES;

    if( empty($nome)|| empty($descricao) || empty($preco) || empty($categoria)){
        echo "<pstyle='color: #f00;'>Erro: Necessário preencher todos os campos</p>";
    }else{
        $produto= new ProductController();
        
        $resultado=$produto->cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem);
        //print_r($resultado);
        echo'chegou aqui';

        if($resultado){
            echo '<script>
                alert("Produto cadastrado com sucesso!");
                window.location.href = document.referrer;
              </script>';
        }else{
            echo "Erro: Não foi possível realizar o cadastro.";
        }
    }

}
?>


<style>
    .cadastro-container {
        display: flex;
        gap: 24px;
        padding: 24px;
    }

    .form-container {
        background: var(--light);
        border-radius: 20px;
        padding: 24px;
        flex: 1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        font-size: 24px;
        margin-bottom: 16px;
        color: var(--dark);
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--grey);
        border-radius: 8px;
        font-size: 14px;
        background: var(--light);
        color: var(--dark);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .btn-submit {
        background: var(--blue);
        color: var(--light);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        background: #FD7238;
    }

    .btn-submit:hover {
        background: #2a7dc5;
    }
</style>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Produtos</title>
</head>
<body>

<div class="form-container">
<div class="form-container">
<h2>Cadastrar Produto</h2>
<form id="form-produto" action="cadastroProduct.php" method="POST" enctype="multipart/form-data">
<div class="form-group">
        <label for="nome-produto">Nome do Produto:</label>
        <input type="text" name="nome" placeholder="digite o nome do produto" required>
    </div>
    <div class="form-group">
        
        <label for="categoria-produto">Categoria:</label>
        <select name="categoria" id="categoria" required>
            <?php foreach($listaCategoria as $categoria){ ?>
            
                <option value=<?=$categoria['idCategoria']?>><?=$categoria['categoria']?></option>

            <?php }?>
        </select >
            </div>
            <div class="form-group">
                <label for="preco-produto">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="descricao-produto">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagem-produto">Imagem:</label>
                <input type="file" name="imagem" id="imagem"> 
            </div>
            <button type="submit" name="submit-produto" class="btn-submit">Salvar Produto</button>
</form>
</div>
</div>
    
</body>
</html>