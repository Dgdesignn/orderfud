

<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(isset($_POST['editarFuncionario'])){
        $idFuncionario =$_POST['idFuncionario'];
        $nome =$_POST['nome'];
        $telefone =$_POST['telefone'];
        $senhaCriptografada=$_POST['senha'];
        $imagem=$_FILES['imagem'];
        $tipo=$_POST['tipo'];
        $funcionario->editarFuncionario($idFuncionario, $nome, $telefone, $senhaCriptografada, $imagem, $tipo);

    }else{
        $nome =$_POST['nome'];
        $telefone =$_POST['telefone'];
        $senhaCriptografada=$_POST['senha'];
        $tipo=$_POST['tipo'];
        $imagem =$_FILES['imagem'];
        


        if (empty($nome) || empty($telefone) || empty($senhaCriptografada)) {
            echo "<p style='color: #f00;'>Necessário preencher todos os campos!</>";
        }elseif(!is_numeric($telefone) || strlen($telefone) < 9){
            echo "<p style='color: #f00;'>Erro: O número de telefone deve ter pelo menos 9 dígitos</p>";
        }elseif(strlen($senhaCriptografada) != 6){
            echo "<p style='color: #f00;' >Erro: A senha deve possuir apenas 6 dígitos</p>";
        }else{
            
                
            $resultado=$funcionario->cadastrar($nome,$telefone,$senhaCriptografada,$imagem,$tipo);
            
            if ($resultado) {
                // Se for um array e tiver elementos, redireciona para a página
                echo '<script>alert("Cadastro feito com sucesso")</script>';
                
                // Importante adicionar o exit após redirecionamento
            }else{
                // Caso contrário, exibe mensagem de erro
              
            }
        }    
    }
} 
                                                                                                                                                                    
?>
 Funcionarios
<button class="btn-cadastro" id="btn-cadastro" onclick="openModal('Cadastro do Funcionário')">
    <i class='bx bx-plus'></i>
    Cadastrar
</button>
<div id="funcionario-apge">
    <div class="table-data">
        <div class="order">
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IMAGEM</th>
                        <th>NOME</th>
                        <th>TELEFONE</th>
                        <th>TIPO</th> 
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>   
                    <?php
                        $funcionarios = $funcionario->buscarFuncionarios();
                        foreach ( $funcionarios as $funcionario){
                        $dadosjs = json_encode($funcionario);
                       
                    ?>
                    <tr>
                        <td><?=$funcionario['idFuncionario']?></td>
                        <td><a href='#' class='profile'><img src=<?=$funcionario["imagem"]?>></a></td>
                        <td><?=$funcionario['nome']?></td>
                        <td><?=$funcionario['telefone']?></td>
                        <td><?=$funcionario['tipo']?></td>
                        <td class='actions'>
                            <a href='#' class="btn btn-edit" onclick='openModal(<?=$dadosjs?>)' ><i class='bx bx-edit-alt'></i>Editar</a>
                            <a href="dashboarbadmin.php?rota=funcionario&idEditarFuncionario=<?=$funcionario['idFuncionario']?>" class='btn btn-delete'><i class='bx bx-trash'></i>Eliminar</a>
                        </td>
                    </tr>
                    <?php } 
                    include "eliminar.php";
                    ?>
                </tbody>

            </table>
        </div>


        <div id="employeeModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Cadastro de Funcionários</h2>
                <form id="employeeForm" action="" method="POST" enctype="multipart/form-data">
                    <div class="img-box">
                        <figure class="profile-photo">
                            <img src="asset/img/image-1.png" class='imgpreview' alt="Imagem de perfil" srcset="">
                            <input type="file" class='imgprofile' name="imagem" require hidden>
                        </figure>
                    </div>
                    
                    <input type="text" id="name" name="nome"  required placeholder="Digite o seu nome">
                    <input type="text" id="phone" name="telefone" required placeholder="Ex.: 932234321">
                    
                    <div class="box col-2">
                        <div class="input-box">
                            <input type="text" id="senha" name="senha" placeholder="Digite a sua senha">
                            <input type='text' id="idfuncionario" name="idFuncionario" value="" hidden>
                        </div>
                        <div>
                            <select  name="tipo">
                                <option value="administrador">Administrador</option>
                                <option value="Funcionária">Funcionária</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" >Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

</div>

















<body><script src="./asset/js/ap.js"></script></body>
