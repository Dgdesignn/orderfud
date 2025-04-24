<?php
require "../controllers/clientController.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome=$_POST["nome"];
    $telefone=$_POST["telefone"];
    $senha=$_POST["senha"];
    $imagem =$_FILES;


    if( empty($nome)|| empty($telefone) || empty($senha)){
        echo "<script>alert('Erro: Necessário preencher todos os campos');</script>";
    }elseif(!is_numeric($telefone) || strlen($telefone) < 9){
        echo "<script>alert('Erro: O número de telefone deve ter pelo menos 9 dígitos');</script>";
    }elseif(strlen($senha) != 6){
        echo "<script>alert('Erro: A senha deve possuir apenas 6 dígitos');</script>";
    }else{
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        
        $cliente= new ClientController();
        $resultado=$cliente->cadastro( $nome, $telefone, $senha, $imagem);
        
         print_r($resultado);
    
        if($resultado){
            echo '<script>alert("Cadastro feito com sucesso")</script>';
        }else{
            echo '<script>alert("Erro: Nao foi possivel realizar cadastro")</script>';
        }
    }

}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css?">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   
</head>
    <body>
  
        <div class="container">
            <div class="login">    
                <form action="#" method="POST">
                    <h1>Cadastro</h1>
                    <hr>
                    <p>Seija bem vindo!</p>
                    <label>NOME</label>
                    <input type="text" name="nome" placeholder="Digite o seu nome" required>
                    <label>TELEFONE</label>
                    <input type="text" name="telefone" placeholder="Digite o seu número" required>
                    <label>SENHA</label>
                    <input type="text" name="senha" placeholder="Digite a sua senha" required>
                    <button>Entrar</button>
                    <p>
                        <a href="loginClient.php">já tem conta? Login</a>
                    </p>
                </form>
                </div>                  
                    <div class="pic">
                       <img src="food.jpg">
                    <div class="letra">Dinheiro é bom, malta!  
                </div>
            </div>
        </div>
    </body>
</html>