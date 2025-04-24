<?php
if(isset($_GET["idEditarCliente"])){
    $id= $_GET["idEditarCliente"];
    $cliente = new ClientController();
    $resultado =  $cliente->deletar($id);
    if($resultado){
        echo"
            <script>
                window.location.href = 'dashboarbadmin.php?rota=cliente';
            </script>
        ";
    }else{
        echo "há algo de errado";
    }
    
}

?>