<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $idFuncionario = $_POST['idFuncionario'];
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $senha = $_POST['senha']; 
  $imagem = $_POST['imagem'];
  $tipo = $_POST['tipo'];

 
  if (!empty($senha)) {
    $novaSenha = password_hash($senha, PASSWORD_DEFAULT);
  } else {
    $novaSenha = null; 
  }

 
  $funcionario = new EmployeeController();
  $resultado = $funcionario->editarFuncionario($idFuncionario, $nome, $telefone, $novaSenha, $imagem, $tipo);

  if ($resultado) {
    echo "Registro atualizado com sucesso!";
  } else {
    echo "Erro ao atualizar o registro.";
  }
}?>