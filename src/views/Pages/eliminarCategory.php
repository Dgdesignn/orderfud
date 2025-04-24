<?php
if(isset($_GET["idEditarCategoria"])){
    $idCategoria= $_GET["idEditarCategoria"];
    $categoria = new CategoryController();    
    $resultado = $categoria->deletar($idCategoria);
    if($resultado){
        echo"
            <script>
                window.location.href = 'dashboarbadmin.php?rota=categoria';
            </script>
        ";
    }else{
        echo "há algo de errado";
    }
    
}

?>