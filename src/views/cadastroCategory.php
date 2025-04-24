<?php
require "../controllers/categoryController.php";


if($_SERVER["REQUEST_METHOD"]== "POST"){
    $categoria=$_POST["categoria"];
    $imagem =$_FILES;

    if( empty($categoria)){
        echo "<pstyle='color: #f00;'>Erro: Necessário preencher todos os campos</p>";
    }else{
        $categorias= new CategoryController();
        $resultado=$categorias->cadastrarCategoria($categoria, $imagem);
        print_r($resultado);

        if($resultado){
           echo '<script>
                alert("carrinho criado com sucesso!");
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
        transition: background 0.3s ease;
    }

    .btn-submit:hover {
        background: #2a7dc5;
    }
</style>

</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categorias</title>
</head>
<body>

<div class="form-container">
<div class="form-container">
        <h2>Cadastrar Categoria</h2>
        <form id="form-categoria" action="cadastroCategory.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <label for="nome-categoria">Nome da Categoria:</label>
        <input type="text" id="nome-categoria" name="categoria" required>
        </div>
        <div class="form-group">
        <label for="imagem-categoria">Imagem:</label>
        <input type="file" id="imagem-categoria" name="imagem" required>
        </div>
        <button type="submit" name="submit-categoria" class="btn-submit">Salvar Categoria</button>
        </form>
    </div>
</div>
    
</body>
</html>