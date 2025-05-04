<?php
if(isset($_GET['idStatusProduto']) && isset($_GET['estado'])) {
    $idProduto = intval($_GET['idStatusProduto']);
    $novoEstado = intval($_GET['estado']);
    
    try {
        if($produto->alterarStatusProduto($idProduto,$novoEstado)) {
            echo "<script>
                alert('Estado do produto alterado com sucesso!');
                window.location.href = 'dashboarbadmin.php?rota=produto';
            </script>";
        } else {
            throw new Exception('Falha ao alterar estado do produto');
        }
    } catch(Exception $e) {
        echo "<script>
            alert('Erro: " . addslashes($e->getMessage()) . "');
            window.location.href = 'dashboarbadmin.php?rota=produto';
        </script>";
    }
}
?> 