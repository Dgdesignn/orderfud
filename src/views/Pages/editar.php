<?php

  if (isset($_GET['idFuncionario'])) {
    $idFuncionario = $_GET['idFuncionario'];  // Ou $_POST['idFuncionario'] se o formulário foi enviado com método POST

    // Supondo que você tenha uma classe para buscar dados no banco
    $funcionario = new EmployeeController();
    $dadosFuncionario = $funcionario->buscarFuncionarios(); // Método para obter os dados do funcionário

    // Agora você pode definir as variáveis com os dados retornados
    $nome = $dadosFuncionario['nome'];
    $telefone = $dadosFuncionario['telefone'];
    $imagem = $dadosFuncionario['imagem'];
    $tipo = $dadosFuncionario['tipo'];
  } else {
    // Caso o ID não seja passado corretamente, redirecionar ou dar um erro
    echo "ID do funcionário não encontrado.";
  }
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>editar funcionarios</h2>
    <form id="employeeForm" action="salvarEdit.php" method="POST" enctype="multipart/form-data">
                <div class="img-box">
                    <figure class="profile-photo">
                        <img src="asset/img/image-1.png" class='imgpreview' alt="Imagem de perfil" srcset="">
                        <input type="file" class='imgprofile' name="profileImg" require hidden>
                    </figure>
                </div>
              
                <input type="hidden" name="idFuncionario" value="<?php echo $idFuncionario ?>">
                <input type="text" id="name" name="nome" value="<?php echo $nome ?>" required placeholder="Digite o seu nome">
                <input type="text" id="phone" name="telefone" value="<?php echo $telefone ?>" required placeholder="Ex.: 932234321">
                
                <div class="box col-2">
                    <div class="input-box">
                        <input type="text" id="senha" name="senha" placeholder="Digite a sua senha">
                    </div>
                    <div>
                        <select name="tipo" id="">
                        <option value="administrador" <?php echo ($tipo == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="Funcionária" <?php echo ($tipo == 'Funcionária') ? 'selected' : ''; ?>>Funcionária</option>
                        </select>
                    </div>
                </div>

                <button type="submit" >Cadastrar</button>
            </form>
    
</body>
</html>

 