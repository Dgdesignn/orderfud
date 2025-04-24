<?php
require "../controllers/clientController.php";
//include "./processamento.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome=$_POST["nome"];
    $telefone=$_POST["telefone"];
    $senha=$_POST["senha"];
    $tipoCliente=$_POST["tipoCliente"];
    $imagem =$_FILES;


    if( empty($nome)|| empty($telefone) || empty($senha) || empty($tipoCliente)){
        echo "<p style='color: #f00;'>Erro: Necessário preencher todos os campos</p>";
    }elseif(!is_numeric($telefone) || strlen($telefone) < 9){
        echo "<p style='color: #f00;'>Erro: O número de telefone deve ter pelo menos 9 dígitos</p>";
    }elseif(strlen($senha) != 6){
        echo "<p style='color: #f00;' >Erro: A senha deve possuir apenas 6 dígitos</p>";
    }else{
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        /*$storedHash = $user['password'];
        print_r($senhaCriptografada);
        if(password_verify($senhaCriptografada,  $storedHash)){
            echo "Login bem-sucedido!";

        }else{
            echo "senha não confere";
        }
        $cliente= new ClientController();
        $resultado=$cliente->cadastro($nome, $telefone, $senha, $tipoCliente, $imagem);
        print_r($resultado);*/
        $cliente= new ClientController();
        $resultado=$cliente->cadastro( $nome, $telefone, $senha, $tipoCliente, $imagem);
        
         print_r($resultado);
         //echo"chegou aqui";
        

        if($resultado){
            echo '<script>alert("Cadastro feito com sucesso")</script>';
            header('location: ../views/Pages/Login/loginfront.php');
            exit(); 
        }else{
            echo "Erro: Não foi possível realizar o cadastro.";
        }
    }

}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuários</title>
</head>
<body>
    <form action="#"  method="POST" enctype="multipart/form-data">
        <h1>Cadastro de Usuários</h1>
        <label for="">Nome:</label>
        <input type="text" name="nome" placeholder="digite o seu nome">
        <br><br>
        <label for="">Telefone:</label>
        <input type="number" name="telefone" placeholder="digite o seu número">
        <br><br>
        <label for="">Senha:</label>
        <input type="password" name="senha" placeholder="digite a sua senha" >
        <br><br>
        <label for="tipoCliente">Tipo de Cliente:</label>
        <select id="tipoCliente" name="tipoCliente">
        <option value="aluno">Aluno</option>
        <option value="professor">Professor</option>
        <option value="outro">Outro</option>
        </select>
        <br><br> 
        <label for="imagem">Escolha uma imagem:</label>
        <input type="file" name="imagem" id="imagem" > 
        <br><br>
        <button type="Submit">Cadastrar</button>
    </form>
    
</body>
</html>