<?php
session_start();
if (isset($_GET['remover']) && $_GET['remover'] == 'carrinho' && isset($_GET['id'])) {
    $idProduto = (int)$_GET['id'];

    
    if (isset($_SESSION['carrinho'][$idProduto])) {
        unset($_SESSION['carrinho'][$idProduto]);
        header('Location:shopping.php');
       exit();
    } else {
        echo '<script>
                alert("Item rnão encontrado!");
                window.location.href = document.referrer;
              </script>';
        //window.location.href="index.php";
    }
} else {
    echo '<script>window.location.reload();</script>';
}
?>
