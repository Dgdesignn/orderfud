<?php // Verifica se há ação de bloquear cliente
if (isset($_GET['idBloquear'])) {
    $idCliente = (int)$_GET['idBloquear'];
    $clienteController = new ClientController();
    
    if ($clienteController->bloquearCliente($idCliente)) {
        $_SESSION['mensagem'] = "Status do cliente alterado com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao alterar status do cliente!";
        $_SESSION['tipo_mensagem'] = "error";
    }
    
    // Redireciona para evitar reenvio do formulário
    header("Location: dashboarbadmin.php?rota=cliente");
    exit();
}
?>