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

function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    
    if (count($words) >= 2) {
        $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
    } else {
        $initials = strtoupper(substr($name, 0, 2));
    }
    
    return $initials;
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

.profile {
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-initials {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #ff7f00;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
}

.pedidos-count {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    color: #666;
}

.pedidos-count i {
    color: #ff7f00;
    font-size: 18px;
}

.pedidos-count span {
    background: #f0f0f0;
    padding: 2px 8px;
    border-radius: 12px;
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
                    <th>PEDIDOS</th>
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
                        $bloqueado = $cliente['bloqueado'] ?? 0;
                        $statusBloqueio = $bloqueado ? 'Desbloquear' : 'Bloquear';
                        $iconeBloqueio = $bloqueado ? 'bx bx-lock-open-alt' : 'bx bx-lock-alt';
                        $classeBotao = $bloqueado ? 'btn-success' : 'btn-warning';
                        
                        // Gerar o HTML para a foto ou iniciais
                        $profileHtml = '';
                        if (!empty($cliente['imagem']) && $cliente['imagem'] !== 'null') {
                            $profileHtml = "<img src='{$cliente['imagem']}' alt='{$cliente['nome']}'>";
                        } else {
                            $initials = getInitials($cliente['nome']);
                            $profileHtml = "<div class='profile-initials'>{$initials}</div>";
                        }
                                        
                        echo "<tr>
                                <td>{$cliente['idCliente']}</td>
                                <td><a href='#' class='profile'>{$profileHtml}</a></td>
                                <td>{$cliente['nome']}</td>
                                <td>{$cliente['telefone']}</td>
                                <td>
                                    <div class='pedidos-count'>
                                        <i class='bx bx-shopping-bag'></i>
                                        <span>{$cliente['total_pedidos']}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class='status " . ($bloqueado ? 'blocked' : 'active') . "'>"
                                        . ($bloqueado ? 'Bloqueado' : 'Ativo') .
                                    "</span>
                                </td>
                                <td>
                                    <a href='dashboarbadmin.php?rota=cliente&idBloquear={$cliente['idCliente']}' class='btn {$classeBotao}' onclick='return confirm(\"Deseja realmente " . strtolower($statusBloqueio) . " este cliente?\")'>
                                        <i class='{$iconeBloqueio}'></i> {$statusBloqueio}
                                    </a>
                                    <a href='dashboarbadmin.php?rota=cliente&idEditarCliente={$cliente['idCliente']}' class='btn btn-danger' onclick='return confirm(\"Deseja realmente remover este cliente?\")'>
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