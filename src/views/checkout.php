<?php
session_start();
if(!isset($_SESSION["client"])){
    header("location: loginClient.php");
    exit;
}

require "../controllers/orderController.php";
$orderController = new OrderController();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - OrderFüd</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="asset/css/checkout.css">
</head>
<body>
    <div class="container">
        <div class="checkout-container">
            <h1>Finalizar Pedido</h1>
            
            <?php if(isset($_SESSION['erro'])): ?>
                <div class="alert alert-error">
                    <?php 
                        echo $_SESSION['erro'];
                        unset($_SESSION['erro']);
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="order-summary">
                <h2>Resumo do Pedido</h2>
                <div id="cart-items-summary"></div>
                <div class="total">
                    <span>Total:</span>
                    <span id="cart-total-summary">0,00 Kz</span>
                </div>
            </div>

            <form method="POST" action="../controllers/processar_pedido.php">
                <div class="form-group">
                    <label for="observacoes">Observações do Pedido:</label>
                    <textarea id="observacoes" name="observacoes" 
                        placeholder="Ex: Sem cebola, ponto da carne, etc..."></textarea>
                </div>

                <input type="hidden" name="produtos" id="produtos-input">
                <input type="hidden" name="total" id="total-input">
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check"></i>
                    Confirmar Pedido
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
            
            if (cartProducts.length === 0) {
                alert('Seu carrinho está vazio!');
                window.location.href = 'shopping.php';
                return;
            }
            console.log(cartProducts);
            // Formatar os produtos com o ID correto
            const formattedProducts = cartProducts.map(product => ({
                idProduto: product.id, // Garantindo que o ID do produto seja enviado
                quantity: product.quantity,
                price: product.price,
                name: product.name
            }));
            
            updateOrderSummary(formattedProducts);
        });

        function updateOrderSummary(products) {
            const summaryContainer = document.getElementById('cart-items-summary');
            const totalElement = document.getElementById('cart-total-summary');
            let total = 0;

            summaryContainer.innerHTML = '';
            
            products.forEach(product => {
                const itemTotal = product.price * product.quantity;
                total += itemTotal;

                summaryContainer.innerHTML += `
                    <div class="summary-item">
                        <span>${product.name} x ${product.quantity}</span>
                        <span>${formatCurrency(itemTotal)}</span>
                    </div>
                `;
            });

            // Atualizar total e campos hidden com os dados formatados
            totalElement.textContent = formatCurrency(total);
            document.getElementById('total-input').value = total.toFixed(2);
            document.getElementById('produtos-input').value = JSON.stringify(products); // Enviando produtos formatados
        }

        function formatCurrency(value) {
            return value.toFixed(2).replace('.', ',') + ' Kz';
        }

        // Adicionar log para debug
        document.querySelector('form').addEventListener('submit', function(e) {
            const produtos = document.getElementById('produtos-input').value;
            console.log('Produtos sendo enviados:', JSON.parse(produtos));
        });
    </script>
</body>
</html> 