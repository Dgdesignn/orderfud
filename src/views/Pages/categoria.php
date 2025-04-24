<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editarCategoria'])) {
        $categoria = $_POST['categoria'];
        $idCategoria = $_POST['idCategoria'];
        $category->update($categoria, $idCategoria);
    } else {
        $categoria = trim($_POST["categoria"]);
        $imagem = $_FILES;

        if (empty($categoria)) {
            echo "<p style='color: #f00;'>Erro: Necessário preencher todos os campos</p>";
        } else {
            // Verificar se já existe uma categoria com o mesmo nome
            $categoriaExistente = $category->buscarCategoriaPorNome($categoria);

            if ($categoriaExistente) {
                echo "<script>alert('Erro: Já existe uma categoria com esse nome!'); window.history.back();</script>";
            } else {
                $resultado = $category->cadastrarCategoria($categoria, $imagem);
                if ($resultado) {
                    echo '<script>
                            alert("Categoria cadastrada com sucesso!");
                            window.location.href = document.referrer;
                          </script>';
                } else {
                    echo "Erro: Não foi possível realizar o cadastro.";
                }
            }
        }
    }
}

?>
  
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>

</head>
    <body>
        <div>
            <button class="btn-cadastro" onclick="openModal('Cadastro de Categorias')">
                <i class='bx bx-plus'></i>
                Cadastrar
            </button>
        </div>
        <div class="head1">
          <h3>Lista e Cadastros de Categorias </h3>
        </div>
        <div id="categoria-apge">
            <div class="table-data">
                <div class="order">
                   
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IMAGEM</th>
                                <th>NOME</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                
                            <?php
                            $categorias = $category->buscarCategoria();
                            foreach ($categorias as $category){
                            $dadosjs = json_encode($category);
                            ?>
                                <tr>
                                    <td><?=$category['idCategoria']?></td>
                                    <td><a href='#' class='profile'><img src='<?=$category["imagem"]?>'></a></td>
                                    <td><?=$category['categoria']?></td>
                                    <td class='actions'>
                                    <a href='#' class="btn btn-edit" onclick='openModal(<?=$dadosjs?>)' ><i class='bx bx-edit-alt'></i>Editar</a>
                                    <a href="dashboarbadmin.php?rota=categoria&idEditarCategoria=<?=$category['idCategoria']?>" class='btn btn-delete'><i class='bx bx-trash'></i>Eliminar</a>
                                </tr>
                            <?php }   
                                include "eliminarCategory.php";
                            ?>
                                 
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="categoryModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <div class="form-container">
                        <div class="form-container">
                            <h2>Cadastrar Categoria</h2>
                            <form id="form-categoria" action="" method="POST" enctype="multipart/form-data">
                                <div class="img-box">
                                    <figure class="profile-photo">
                                        <img src="asset/img/image-1.png" class='imgpreview' alt="Imagem de perfil" srcset="">
                                        <input type="file" class='imgprofile' name="profileImg" require hidden>
                                    </figure>
                                </div>
              
                                <div class="form-group">
                                    <input type="text" id="nome-categoria" name="categoria" placeholder="Categoria"  required>
                                    <input type='text' id="idCategoria" name="idCategoria" value="" hidden>
                                </div>
                                <div class="form-group">
                                 <button type="submit" name="submit-categoria" class="btn-submit">Salvar Categoria</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

     

    
       <script src="./asset/js/categoria.js"></script>
    </body>
</html>
