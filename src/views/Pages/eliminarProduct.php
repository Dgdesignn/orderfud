<?php 
if(isset($_GET["idEditarProduto"])){
    $idProduto = $_GET["idEditarProduto"];
    $produto = new  ProductController();    
    $resultado = $produto->deletar( $idProduto);
    if($resultado){
        echo"
            <script>
                window.location.href = 'dashboarbadmin.php?rota=produto';
            </script>
        ";
    }else{
        echo "há algo de errado";
    }

    
}
?>