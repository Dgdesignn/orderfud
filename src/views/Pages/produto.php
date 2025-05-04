<?php

if (!isset($category)) {
    require_once "../controllers/categoryController.php";
    $category = new CategoryController();
}

if (!isset($produto)) {
    require_once "../controllers/productController.php";
    $produto = new ProductController();
}

$listaCategoria = $category->buscarCategoria();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Processamento do status
    if (isset($_POST['alterarStatus'])) {
        try {
            $idProduto = intval($_POST['idProduto']);
            $status = intval($_POST['status']);
            
            if ($produto->alterarStatusProduto($idProduto, $status)) {
                echo 'success';
            } else {
                echo 'error';
            }
            exit;
        } catch (Exception $e) {
            echo 'error';
            exit;
        }
    }
    
    try {
        error_log("Dados do upload:");
        error_log("POST: " . print_r($_POST, true));
        error_log("FILES: " . print_r($_FILES, true));

        // Validações
        if (empty($_POST['nome']) || empty($_POST['preco']) || 
            empty($_POST['categoria']) || empty($_POST['descricao'])) {
            throw new Exception('Todos os campos são obrigatórios!');
        }

        if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload da imagem');
        }

        // Sanitiza e prepara os dados
        $nome = trim(strip_tags($_POST['nome']));
        $descricao = trim(strip_tags($_POST['descricao']));
        $preco = floatval(str_replace(',', '.', $_POST['preco']));
        $categoria = intval($_POST['categoria']);
        
        // Cadastra o produto
        $resultado = $produto->cadastrarProduto(
            $nome,
            $descricao,
            $preco,
            $categoria,
            $_FILES['imagem']
        );
        if ($resultado) {
            error_log("Produto cadastrado com sucesso");
            echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        } else {
            error_log("Falha ao cadastrar produto");
            throw new Exception('Erro ao cadastrar produto!');
        }
    } catch (Exception $e) {
        error_log("Erro: " . $e->getMessage());
        echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Produtos</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div id="produto-page">
        <!-- Botão para abrir o modal -->
        <div>
            <button class="btn-add-produto" onclick="openModalProduto()">
                <i class='bx bx-plus'></i>
                Novo Produto
            </button>
        </div>

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
                            $estadoAtual = isset($produto['estado']) ? $produto['estado'] : 1;
                            $statusText = $estadoAtual ? 'Desativar' : 'Ativar';
                            $statusClass = $estadoAtual ? 'ativo' : 'inativo';
                        ?>
                            <tr class="<?= $statusClass ?>">
                                <td><?=$produto['idProduto']?></td>
                                <td><img src=<?=$produto["imagem"]?>></td>
                                <td><?=$produto['nome']?></td>
                                <td><?=$produto['descricao']?></td>
                                <td><?=$produto['preco']?></td>
                                <td><?=$produto['Categoria']?></td>
                                <td class='actions'>
                                    <a href="#" class='btn btn-edit' onclick='openModal(<?=$dadosjs?>)'>
                                        <i class='bx bx-edit-alt'></i>Editar
                                    </a>
                                    <a href="dashboarbadmin.php?rota=produto&idEditarProduto=<?=$produto['idProduto']?>" 
                                       class='btn btn-delete' 
                                       onclick='return confirm("Tem certeza que deseja eliminar este produto?")'>
                                        <i class='bx bx-trash'></i>Eliminar
                                    </a>
                                    <a href="dashboarbadmin.php?rota=produto&idStatusProduto=<?=$produto['idProduto']?>&estado=<?=$estadoAtual ? '0' : '1'?>" 
                                       class='btn btn-status <?=$statusClass?>'
                                       onclick='return confirm("Tem certeza que deseja <?=$statusText?> este produto?")'>
                                        <i class='bx bx-power-off'></i><?=$statusText?>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                            include "eliminarProduct.php";
                            include "alterarStatusProduto.php";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inclua o modal usando caminho absoluto -->
        <?php require __DIR__ . '/components/produto-modal.php'; ?>
    </div>

    <script>
    console.log('Página carregada');
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM carregado');
        const modal = document.getElementById('modalForm');
        console.log('Modal encontrado:', modal);
        const btn = document.querySelector('.btn-add-produto');
        console.log('Botão encontrado:', btn);
    });

    function openModalProduto() {
        const modal = document.getElementById('modalProduto');
        if (modal) {
            modal.style.display = 'block';
        } else {
            console.error('Modal não encontrado');
        }
    }

    function closeModalProduto() {
        const modal = document.getElementById('modalProduto');
        if (modal) {
            modal.style.display = 'none';
            document.getElementById('formProduto').reset();
            const previewImg = document.getElementById('previewImg');
            const uploadText = document.querySelector('.upload-text');
            if (previewImg) previewImg.style.display = 'none';
            if (uploadText) uploadText.style.display = 'block';
        }
    }

    </script>
</body>
</html>

<style>
.btn-add-produto {
    background: #ff7f00;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-add-produto:hover {
    background: #e67300;
    transform: translateY(-2px);
}

.btn-status {
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: none;
}

.btn-status.ativo {
    background-color: #4CAF50;
    color: white;
}

.btn-status.inativo {
    background-color: #f44336;
    color: white;
}

tr.inativo {
    opacity: 0.7;
    background-color: #f5f5f5;
}
</style>