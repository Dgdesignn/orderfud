
<?php

$listaCategoria= $category->buscarCategoria();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['editarProduto'])){
       
        $nome=$_POST["nome"];
        $descricao=$_POST["descricao"];
        $preco=$_POST["preco"];
        $categoria=$_POST["categoria"];
        $id=$_POST["id"];
        $imagem =$_FILES['imagem'];

        $produto->updateProduto($nome, $descricao, $preco, $categoria, $id,$imagem);

    }else{
        
        $nome=$_POST["nome"];
        $descricao=$_POST["descricao"];
        $preco=$_POST["preco"];
        $categoria=$_POST["categoria"];
        $imagem =$_FILES['imagem'];
    
        if( empty($nome)|| empty($descricao) || empty($preco) || empty($categoria)){
            echo "<script>alert('Erro: Necessário preencher todos os campos')</script>";
        }else{
            
            $resultado=$produto->cadastrarProduto($nome, $descricao, $preco, $categoria, $imagem);
            var_dump($imagem);
            //print_r($resultado);
            echo'chegou aqui';
    
            if($resultado){
                echo '<script>
                    alert("Produto cadastrado com sucesso!");
                    window.location.href = document.referrer;
                  </script>';
            }else{
                echo "<script>alert('Erro: Não foi possível realizar o cadastro.')</script>";
            }
        }
    
    }
   
}
?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Produtos</title>
</head>
<body>
    <div>
        <button class="btn-cadastro" onclick="openModal('Cadastro de Produtos')">
            <i class='bx bx-plus'></i>
            Cadastrar
        </button>
    </div>
    <div id="produto-apge">
    <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Lista de Produtos</h3>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>NOME</th>
                    <th>DESCRIÇÃO</th>
                    <th>PREÇO</th> 
                    <th>CATEGORIA</th> 
                </tr>
            </thead>

            <tbody>   
                <?php
                   
                    $produtos = $produto->buscarCategoria();
                    foreach ($produtos as $produto){
                    $dadosjs = json_encode($produto);

                ?>
                    <tr>
                        <td><?=$produto['idProduto']?></td>
                        <td><img src=<?=$produto["imagem"]?>></td>
                        <td><?=$produto['nome']?></td>
                        <td><?=$produto['descricao']?></td>
                        <td><?=$produto['preco']?></td>
                        <td><?=$produto['Categoria']?></td>
                        <td class='actions'>
                            <a href="#"class='btn btn-edit' onclick='openModal(<?=$dadosjs?>)'><i class='bx bx-edit-alt'></i>Editar</a>
                            <a href= "dashboarbadmin.php?rota=produto&idEditarProduto=<?=$produto['idProduto']?>" class='btn btn-delete' onclick='return confirm(\"Tem certeza que deseja eliminar este produto?\")'><i class='bx bx-trash'></i>Eliminar</a>
                        </td>
                    </tr>

                <?php }
                    include "eliminarProduct.php";
                ?>
               
            </tbody>
        </table>
    </div>
</div>

       <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="form-container">
                    <div class="form-container">
                        <h2>Cadastrar Produtos</h2>
                        <form id="form-produto" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                            <label for="nome-produto">Nome do Produto:</label>
                            <input type="text" name="nome" placeholder="digite o nome do produto" required>
                            <input type='text' id="idProduto" name="id" value="" hidden>
                  
                            <div class="form-group">
                            <label for="categoria-produto">Categoria:</label>
                            <select name="categoria" id="categoria" required>
                                <?php foreach($listaCategoria as $categoria){ ?>
                                
                                    <option value=<?=$categoria['idCategoria']?>><?=$categoria['categoria']?></option>

                                <?php }?>
                            </select>
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
            </div>
        </div>  
    </div>

    </div>
    <script src="./asset/js/produto.js"></script>
    
</body>
</html>