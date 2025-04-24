<?php
session_start();

if (isset($_GET['finalizar'])) {

    if (!empty($_SESSION['carrinho'])) {
       
        echo '<script>
                alert("Pedido finalizado com sucesso");
                window.location.href = document.referrer;
              </script>';
        // Limpa o carrinho após finalizar o pedido
        unset($_SESSION['carrinho']);
       
    } else {
        echo '<script>
                alert("Seu carrinho está vazio!");
                window.location.href = document.referrer;
              </script>';
    }
}
?>