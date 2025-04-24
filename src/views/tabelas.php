<?php
require "../controllers/productController.php";
require "../controllers/categoryController.php";

// Instanciar controladores
$categoriasController = new CategoryController();
$categorias = $categoriasController->buscarCategoria();


$produtosController = new ProductController();
$produtos = $produtosController->buscar();

?>


<!-- funcionarios.html -->
<div class="head-title">
    <div class="left">
        <h1>Visualizar</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Pedidos</a>
            </li>
        </ul>
    </div>
</div>

<!-- <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Lista de Pedidos</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMAGEM DO PRODUTO</th>
                    <th>NOME DO PRODUTO</th>
                    <th>NOME DO CLIENTE</th>
                    <th>QUANTIDADE</th>
                    <th>PREÇO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <a href="#" class="profile">
                            <img src="../assets/icon/433087.png">
                        </a>
                    </td>
                    <td>Fanta</td>
                    <td>Danilo Tese</td>
                    <td>3</td>
                    <td>124kzs</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <a href="#" class="profile">
                            <img src="../assets/icon/433087.png">
                        </a>
                    </td>
                    <td>Magoga</td>
                    <td>Bernardo Valdir</td>
                    <td>5</td>
                    <td>124654kzs</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> -->

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Lista de Produtos</h3>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMAGEM</th>
                    <th>NOME</th>
                    <th>DESCRIÇÃO</th>
                    <th>PREÇO</th>
                </tr>
            </thead>
            <tbody>
                
            <?php
            echo "<pre>";
            //var_dump($produtos);
            echo "</pre>";
                foreach ($produtos as $produto) {
                    echo "<tr>
                            <td>{$produto['idProduto']}</td>
                            <td><a href='#' class='profile'><img src='{$produto['imagem']}'></a></td>
                            <td>{$produto['nome']}</td>
                            <td>{$produto['descricao']}</td>
                            <td>{$produto['preco']} kzs</td>
                            <td>
                                    <a href='editar_produto.php?id={$produto['idProduto']}' class='btn btn-edit'>Editar</a>
                                    <a href='eliminar_produto.php?id={$produto['idProduto']}' class='btn btn-delete' onclick='return confirm(\"Tem certeza que deseja eliminar este produto?\")'>Eliminar</a>
                                </td>
                        </tr>";
                }
                ?>
                </tbody>

        </table>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Lista de Categorias</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMAGEM</th>
                    <th>NOME</th>
                </tr>
            </thead>
            <tbody>
                
            <?php
            echo "<pre>";
            //var_dump($produtos);
            echo "</pre>";
                foreach ($categorias as $categoria) {
                    echo "<tr>
                            <td>{$categoria['idCategoria']}</td>
                            <td><a href='#' class='profile'><img src='{$categoria['imagem']}'></a></td>
                            <td>{$categoria['categoria']}</td>
                            <td>
                                    <a href='editar_produto.php?id={$produto['idProduto']}' class='btn btn-edit'>Editar</a>
                                    <a href='eliminar_produto.php?id={$produto['idProduto']}' class='btn btn-delete' onclick='return confirm(\"Tem certeza que deseja eliminar este produto?\")'>Eliminar</a>
                                </td>
                            
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <ul class="side-menu">
		<li>
			<a href="dashboarbadmin.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
</div>
<style>
    .btn {
        display: inline-block;
        padding: 5px 10px;
        margin: 2px;
        text-decoration: none;
        border-radius: 5px;
    }
    .btn-edit {
        background-color: #4CAF50;
        color: white;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
</style>



