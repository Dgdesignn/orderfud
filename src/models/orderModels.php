<?php 
class OrderModel {
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    } 
 
    public function criarPedido($clienteId, $produtos, $observacoes, $total) {
        try {
            $this->connection->beginTransaction();

            // Debug dos dados recebidos 
            error_log("Produtos recebidos: " . print_r($produtos, true));

            // Inserir o pedido principal
            $sql = "INSERT INTO pedido (fk_Cliente_idCliente, data_pedido, status, total, observacoes) 
                   VALUES (:cliente_id, CURRENT_TIMESTAMP, 'pendente', :total, :observacoes)";
            
            $stmt = $this->connection->prepare($sql);
           $result =  $stmt->execute([
                ':cliente_id' => $clienteId,
                ':total' => floatval($total),
                ':observacoes' => $observacoes ?? ''
            ]);
 
            //var_dump($produtos['idProduto']);
            
            $pedidoId = $this->connection->lastInsertId();
            //echo $pedidoId;     
            // Inserir os produtos do pedido
            $sqlProdutos = "INSERT INTO pedido_produto 
                          (fk_Pedido_idPedido, fk_Produto_idProduto, quantidade, preco_unitario) 
                          VALUES (:pedido_id, :produto_id, :quantidade, :preco)";
            
            $stmtProdutos = $this->connection->prepare($sqlProdutos);
            foreach ($produtos as $produto) {
                // Validar se todas as chaves necessárias existem
                if (!isset($produto['idProduto']) || !isset($produto['quantidade']) || !isset($produto['preco'])) {
                    throw new Exception("Dados do produto incompletos");
                }
                   
                $stmtProdutos->execute([
                    ':pedido_id' => $pedidoId,
                    ':produto_id' => intval($produto['idProduto']), // Mudado de 'id' para 'idProduto'
                    ':quantidade' => intval($produto['quantidade']),
                    ':preco' => floatval($produto['preco'])
                ]);
               
            }

            $this->connection->commit();
            return [
                'success' => true,
                'pedido_id' => $pedidoId
            ];

        } catch (Exception $e) {
            $this->connection->rollBack();
            error_log("Erro ao criar pedido: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return [
                'success' => false,
                'message' => "Erro ao criar pedido: " . $e->getMessage()
            ];
        }
    }

    public function buscarPedidosCliente($clienteId) {
        try {
            $sql = "SELECT 
                        p.idPedido,
                        p.data_pedido,
                        p.status,
                        p.total,
                        p.observacoes,
                        GROUP_CONCAT(
                            CONCAT(pp.quantidade, 'x ', pr.nome, ' (', 
                            FORMAT(pp.preco_unitario, 2), ' Kz)') 
                            SEPARATOR ', '
                        ) as items,
                        GROUP_CONCAT(pp.subtotal) as subtotais
                    FROM pedido p
                    LEFT JOIN pedido_produto pp ON p.idPedido = pp.fk_Pedido_idPedido
                    LEFT JOIN produto pr ON pp.fk_Produto_idProduto = pr.idProduto
                    WHERE p.fk_Cliente_idCliente = :cliente_id
                    GROUP BY p.idPedido
                    ORDER BY p.data_pedido DESC";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':cliente_id' => $clienteId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function atualizarStatusPedido($pedidoId, $novoStatus) {
        try {
            $this->connection->beginTransaction();

            // Verificar se o pedido existe e pegar status atual
            $sqlVerificar = "SELECT status FROM pedido WHERE idPedido = :pedido_id FOR UPDATE";
            $stmtVerificar = $this->connection->prepare($sqlVerificar);
            $stmtVerificar->execute([':pedido_id' => $pedidoId]);
            
            $pedido = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            if (!$pedido) {
                throw new Exception('Pedido não encontrado');
            }

            // Validar transição de status
            $statusValido = $this->validarTransicaoStatus($pedido['status'], $novoStatus);
            if (!$statusValido) {
                throw new Exception('Transição de status não permitida');
            }

            // Atualizar status
            $sql = "UPDATE pedido SET 
                    status = :status,
                    data_atualizacao = CURRENT_TIMESTAMP
                    WHERE idPedido = :pedido_id";
                    
            $stmt = $this->connection->prepare($sql);
            $resultado = $stmt->execute([
                ':status' => $novoStatus,
                ':pedido_id' => $pedidoId
            ]);

            if (!$resultado) {
                throw new Exception("Erro ao atualizar status no banco de dados");
            }

            $this->connection->commit();
            
            return [
                'success' => true,
                'message' => 'Status atualizado com sucesso'
            ];

        } catch (Exception $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            error_log("Erro no modelo ao atualizar status: " . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function buscarDetalhesPedido($pedidoId) {
        try {
            $sql = "SELECT 
                        p.idPedido,
                        p.data_pedido,
                        p.status,
                        p.total,
                        p.observacoes,
                        pp.quantidade,
                        pp.preco_unitario,
                        pp.subtotal,
                        pr.nome as produto_nome,
                        pr.descricao as produto_descricao
                    FROM pedido p
                    JOIN pedido_produto pp ON p.idPedido = pp.fk_Pedido_idPedido
                    JOIN produto pr ON pp.fk_Produto_idProduto = pr.idProduto
                    WHERE p.idPedido = :pedido_id";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':pedido_id' => $pedidoId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar detalhes do pedido: " . $e->getMessage());
            return [];
        }
    }

    public function totalPedidos() {
        try {
            $sql = "SELECT COUNT(*) AS total FROM pedido";
            $query = $this->connection->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['total'] : 0;
        } catch (PDOException $e) {
            error_log('Erro ao contar pedidos: ' . $e->getMessage());
            return 0;
        }
    }

    public function pedidosPorStatus() {
        try {
            $sql = "SELECT status, COUNT(*) as quantidade 
                   FROM pedido 
                   GROUP BY status";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar pedidos por status: " . $e->getMessage());
            return [];
        }
    }

    public function buscarTodosPedidos() {
        try {
            $sql = "SELECT 
                        p.idPedido,
                        p.data_pedido,
                        p.status,
                        p.total,
                        p.observacoes,
                        c.nome as nome_cliente,
                        GROUP_CONCAT(
                            CONCAT(pp.quantidade, 'x ', pr.nome, ' (', 
                            FORMAT(pp.preco_unitario, 2), ' Kz)') 
                            SEPARATOR ', '
                        ) as items
                    FROM pedido p
                    JOIN cliente c ON p.fk_Cliente_idCliente = c.idCliente
                    JOIN pedido_produto pp ON p.idPedido = pp.fk_Pedido_idPedido
                    JOIN produto pr ON pp.fk_Produto_idProduto = pr.idProduto
                    GROUP BY p.idPedido
                    ORDER BY p.data_pedido DESC";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function getNewOrders() {
        try {
            $sql = "SELECT 
                        p.idPedido,
                        p.data_pedido,
                        p.total,
                        p.status,
                        p.observacoes,
                        c.nome as nome_cliente,
                        GROUP_CONCAT(
                            CONCAT(pp.quantidade, 'x ', pr.nome)
                            SEPARATOR ', '
                        ) as items
                    FROM pedido p
                    JOIN cliente c ON p.fk_Cliente_idCliente = c.idCliente
                    JOIN pedido_produto pp ON p.idPedido = pp.fk_Pedido_idPedido
                    JOIN produto pr ON pp.fk_Produto_idProduto = pr.idProduto
                    WHERE p.notificado = 0
                    GROUP BY p.idPedido
                    ORDER BY p.data_pedido DESC";
                    
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar novos pedidos: " . $e->getMessage());
            throw new Exception("Erro ao buscar novos pedidos");
        }
    }

    public function marcarPedidoComoNotificado($idPedido) {
        try {
            $sql = "UPDATE pedido SET notificado = 1 WHERE idPedido = :id";
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute([':id' => $idPedido]);
        } catch (PDOException $e) {
            error_log("Erro ao marcar pedido como notificado: " . $e->getMessage());
            throw new Exception("Erro ao atualizar notificação");
        }
    }

    public function getStatusUpdates($clientId = null) {
        $sql = "SELECT * FROM pedidos WHERE status_atualizado = 1";
        if ($clientId) {
            $sql .= " AND idCliente = ?";
        }
        
        $stmt = $this->connection->prepare($sql);
        if ($clientId) {
            $stmt->execute([$clientId]);
        } else {
            $stmt->execute();
        }
        
        // Resetar flag de atualização
        $this->resetStatusUpdateFlag($stmt->fetchAll(PDO::FETCH_ASSOC));
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function resetStatusUpdateFlag($orders) {
        if (empty($orders)) return;
        
        $ids = array_column($orders, 'idPedido');
        $sql = "UPDATE pedidos SET status_atualizado = 0 WHERE idPedido IN (" . implode(',', $ids) . ")";
        $this->connection->exec($sql);
    }
}
?>
   

    private function validarTransicaoStatus($statusAtual, $novoStatus) {
        $transicoesPermitidas = [
            'pendente' => ['em_preparo', 'cancelado'],
            'em_preparo' => ['pronto', 'cancelado'],
            'pronto' => ['entregue', 'cancelado'],
            'entregue' => [],
            'cancelado' => []
        ];

        return isset($transicoesPermitidas[$statusAtual]) && 
               in_array($novoStatus, $transicoesPermitidas[$statusAtual]);
    }
