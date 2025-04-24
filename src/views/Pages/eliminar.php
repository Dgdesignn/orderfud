<?php 
if(isset($_GET["idEditarFuncionario"])){
    $id = $_GET["idEditarFuncionario"];
    $funcionario = new EmployeeController();    
    $resultado = $funcionario->deletarFuncionario($id);
    if($resultado){
        echo"
            <script>
                window.location.href = 'dashboarbadmin.php?rota=funcionario';
            </script>
        ";
    }else{
        echo "há algo de errado";
    }

    
}
?>