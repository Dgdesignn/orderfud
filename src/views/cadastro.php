<?php
 require "../controllers/employeeController.php";
 session_start();

 if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome =$_POST['nome'];
    $telefone =$_POST['telefone'];
    $senhaCriptografada=$_POST['senha'];
    $imagem =$_FILES;


    if (empty($nome) || empty($telefone) || empty($senhaCriptografada)) {
        echo "<p style='color: #f00;'>Necessário preencher todos os campos!</>";
    }elseif(!is_numeric($telefone) || strlen($telefone) < 9){
        echo "<p style='col or: #f00;'>Erro: O número de telefone deve ter pelo menos 9 dígitos</p>";
    }elseif(strlen($senhaCriptografada) != 6){
        echo "<p style='color: #f00;' >Erro: A senha deve possuir apenas 6 dígitos</p>";
    }else{
      
        
        $funcionario= new employeeController();
        $resultado=$funcionario->cadastrar($nome,$telefone,$senhaCriptografada,$imagem);
        
         
        
        if ($resultado) {
           // Se for um array e tiver elementos, redireciona para a página
           echo '<script>alert("Cadastro feito com sucesso")</script>';
           header("location: login.php");
           exit();
           // Importante adicionar o exit após redirecionamento
        } else {
           // Caso contrário, exibe mensagem de erro
           echo "Erro: Não foi possível realizar o cadastro.";
        }
        }    
       
 }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<!-- <img class="wave" src="../../img/wave.png"> -->
	<div class="container">
		
		<div class="img">
			<img src="../../img/bg.svg">
		</div>
		
		<div class="login-content">
			<form action="" method="POST">
			<ul class="side-menu">
		        <li>
			       <a href="dashboarbadmin.php" class="logout">
				   <i class='bx bxs-log-out-circle'></i>
				   <span class="text">Sair</span>
			       </a>
		        </li>
	        </ul>
				<img src="../../img/avatar.svg">
				<h2 class="title">Welcome Funcionario</h2>
                <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Nome</h5>
           		   		<input type="text" class="input" name="nome" required>
           		   </div>
           		</div>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>numero</h5>
           		   		<input type="text" class="input" name="telefone" required>
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="text" class="input" name="senha" required>
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Cadastrar">
            </form>
			
        </div>
		
    </div>
	
    <script type="text/javascript" src="../../js/main.js"></script>
</body>
</html>
