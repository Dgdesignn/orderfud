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
                if (!isset($produto['idProduto']) || !isset($produto['quantity']) || !isset($produto['price'])) {
                    throw new Exception("Dados do produto incompletos");
                }

                $stmtProdutos->execute([
                    ':pedido_id' => $pedidoId,
                    ':produto_id' => intval($produto['idProduto']), // Mudado de 'id' para 'idProduto'
                    ':quantidade' => intval($produto['quantity']),
                    ':preco' => floatval($produto['price'])
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
            $statusPermitidos = ['pendente', 'em_preparo', 'pronto', 'entregue', 'cancelado'];
            
            if (!in_array($novoStatus, $statusPermitidos)) {
                throw new Exception("Status inválido");
            }

            $sql = "UPDATE pedido SET status = :status WHERE idPedido = :pedido_id";
            $stmt = $this->connection->prepare($sql);
            
            return $stmt->execute([
                ':status' => $novoStatus,
                ':pedido_id' => $pedidoId
            ]);
        } catch (Exception $e) {
            error_log("Erro ao atualizar status: " . $e->getMessage());
            return false;
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
}
?>
   