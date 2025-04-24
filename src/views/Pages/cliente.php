<?php
echo "<h1>Clienteee!</h1>";


// Verifica se há ação de bloquear cliente
if (isset($_GET['idBloquear'])) {
    $id = (int)$_GET['idBloquear'];
    $cliente = new ClientController();
    
    if ($cliente->bloquearCliente($id)) {
        $_SESSION['mensagem'] = "Status do cliente alterado com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao alterar status do cliente!";
        $_SESSION['tipo_mensagem'] = "error";
    }
    
    header("Location: dashboarbadmin.php?rota=cliente");
    exit();
}


if (isset($_SESSION['mensagem'])) {
    echo "<div class='alert alert-{$_SESSION['tipo_mensagem']}'>{$_SESSION['mensagem']}</div>";
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
} 


?>
<body>
    <style>
        .status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}

.status.active {
    background-color: #28a745; /* Verde */
}

.status.blocked {
    background-color: #dc3545; /* Vermelho */
}




/* Estilo base para todos os botões de ação */
.btn {
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    color: white !important;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

/* Botão principal (Bloquear/Desbloquear) */
.btn-warning, .btn-success {
    background-color: #ff7f00 !important; /* Laranja principal */
    box-shadow: 0 2px 5px rgba(255, 127, 0, 0.2);
}

.btn-warning:hover, .btn-success:hover {
    background-color: #e67e22 !important; /* Laranja mais escuro no hover */
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(230, 126, 34, 0.3);
}

/* Botão de Remover */
.btn-danger {
    background-color:  #ff7f00 !important; /* Vermelho (mantido para destaque) */
    box-shadow: 0 2px 5px rgba(231, 76, 60, 0.2);
}

.btn-danger:hover {
    background-color:  #e67e22 !important; /* Vermelho mais escuro */
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(192, 57, 43, 0.3);
}

/* Ícones dentro dos botões */
.btn i {
    font-size: 14px;
}
    </style>
</body>
 <div class="table-data">
    <div class="order">
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMAGEM</th>
                    <th>NOME</th>
                    <th>TELEFONE</th> 
                    <th>STATUS</th> 
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $cliente = new ClientController();
                $clientes = $cliente->buscarClientes();
                echo "<pre>";
                //var_dump($produtos);
                
                echo "</pre>";

                    foreach ($clientes as $cliente) {
                        $bloqueado = $cliente['bloqueado'] ?? 0; // Trata NULL como 0
                        $statusBloqueio = $bloqueado ? 'Desbloquear' : 'Bloquear';
                        $iconeBloqueio = $bloqueado ? 'bx bx-lock-open-alt' : 'bx bx-lock-alt';
                        $classeBotao = $bloqueado ? 'btn-success' : 'btn-warning';
                                        
                        echo "<tr>
                                <td>{$cliente['id']}</td>
                                <td><a href='#' class='profile'><img src='{$cliente['imagem']}'></a></td>
                                <td>{$cliente['nome']}</td>
                                <td>{$cliente['telefone']}</td>
                                <td>
                                    <span class='status " . ($bloqueado ? 'blocked' : 'active') . "'>"
                                        . ($bloqueado ? 'Bloqueado' : 'Ativo') .
                                    "</span>
                                </td>
                                <td>
                                    <a href='dashboarbadmin.php?rota=cliente&idBloquear={$cliente['id']}' class='btn {$classeBotao}' onclick='return confirm(\"Deseja realmente " . strtolower($statusBloqueio) . " este cliente?\")'>
                                        <i class='{$iconeBloqueio}'></i> {$statusBloqueio}
                                    </a>
                                    <a href='dashboarbadmin.php?rota=cliente&idEditarCliente={$cliente['id']}' class='btn btn-danger' onclick='return confirm(\"Deseja realmente remover este cliente?\")'>
                                        <i class='bx bx-trash'></i> Remover
                                    </a>
                                </td>
                                     
                                
                            </tr>";
                    }
                    include "eliminarClient.php";
                ?>
            </tbody>

        </table>
    </div>