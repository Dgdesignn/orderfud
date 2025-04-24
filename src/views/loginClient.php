<?php
    require "../controllers/clientController.php";

    session_start();
	$cliente= new ClientController();
	if(isset($_SESSION["user"])){
        
      }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];

        if (empty($telefone) || empty($senha)) {
			// crie uma função que valide apenas numero no input
            // echo "<p style='color: #f00;'>Todos os campos são obrigatórios!</>";
        } else{
            
             $resultado=$cliente->login($telefone, $senha);
             
            
            //   var_dump($resultado);
            //   echo"chegou aqui";
                
            if ($resultado){
                // Se for um array e tiver elementos, redireciona para a página
                //header("location: ../../public/index.php");
                //exit(); // Importante adicionar o exit após redirecionamento
                header("location:shopping.php");
                exit();
            } else {
                // Caso contrário, exibe mensagem de erro
				echo "<script>alert('Senha ou número de telefone ínvalidos.')</script>";
                // echo "<p style='color: #f00;'>Erro: Senha ou número de telefone ínvalidos.</>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginClient.css">
</head>
<body>
        <div class="container">
                <div class="login">
                    <form action="#" method="POST">
                        <h1>Login</h1>
                        <hr>
                        <p>loga para acessar ao perfil!</p>
                        <label>TELEFONE</label>
                        <input type="text" name="telefone" placeholder="Digite o seu número">
                        <label>SENHA</label>
                        <input type="text" name="senha" placeholder="Digite a sua senha!">
                        <button>Entrar</button>
                        <p>
                            <a href="cadastro1.php">Ainda não tem conta? Cadastre-se!</a>
                        </p>
                    </form>
                </div>
                <div class="pic">
                    <img src="food.jpg">
                    <div class="letra">
                       Bem-vindo(a) de volta!
                    </div>
                </div>
            </div>

</body>
</html>