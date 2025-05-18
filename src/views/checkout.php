
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
            <div class="cart-section">
                <h2>Shopping Cart <span id="items-count">0 Items</span></h2>
                
                <div class="cart-items" id="cart-items-container">
                    <!-- Cart items will be dynamically added here -->
                </div>

                <a href="shopping.php" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> 
                    Continue Shopping
                </a>
            </div>

            <div class="order-summary-section">
                <h2>Order Summary</h2>
                
                <div class="summary-details">
                    <div class="summary-row">
                        <span>ITEMS</span>
                        <span id="items-total">0,00 Kz</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>SHIPPING</span>
                        <div class="shipping-select">
                            <select id="shipping-method">
                                <option value="0">Standard Delivery - 0,00 Kz</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="promo-code">
                        <span>PROMO CODE</span>
                        <input type="text" placeholder="Enter your code">
                        <button class="apply-btn">APPLY</button>
                    </div>
                    
                    <div class="total-cost">
                        <span>TOTAL COST</span>
                        <span id="cart-total-summary">0,00 Kz</span>
                    </div>
                    
                    <form method="POST" action="../controllers/processar_pedido.php">
                        <div class="form-group">
                            <label for="observacoes">Observações do Pedido:</label>
                            <textarea id="observacoes" name="observacoes" 
                                placeholder="Ex: Sem cebola, ponto da carne, etc..."></textarea>
                        </div>

                        <input type="hidden" name="produtos" id="produtos-input">
                        <input type="hidden" name="total" id="total-input">
                        
                        <button type="submit" class="checkout-btn">
                            CHECKOUT
                        </button>
                    </form>
                </div>
            </div>
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

            const formattedProducts = cartProducts.map(product => ({
                idProduto: parseInt(product.id),
                quantidade: parseInt(product.quantity),
                preco: parseFloat(product.price),
                nome: product.name,
                imagem: product.image
            }));
            
            updateOrderSummary(formattedProducts);
            document.getElementById('produtos-input').value = JSON.stringify(formattedProducts);
            document.getElementById('items-count').textContent = `${formattedProducts.length} Items`;
        });

        function updateOrderSummary(products) {
            const cartContainer = document.getElementById('cart-items-container');
            const totalElement = document.getElementById('cart-total-summary');
            const itemsTotalElement = document.getElementById('items-total');
            let total = 0;

            cartContainer.innerHTML = '';
            
            products.forEach(product => {
                const itemTotal = product.preco * product.quantidade;
                total += itemTotal;

                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <div class="product-details">
                            <img src="${product.imagem}" alt="${product.nome}">
                            <div class="product-info">
                                <h3>${product.nome}</h3>
                                <button class="remove-btn">Remove</button>
                            </div>
                        </div>
                        <div class="quantity-controls">
                            <button class="quantity-btn">-</button>
                            <input type="number" value="${product.quantidade}" readonly>
                            <button class="quantity-btn">+</button>
                        </div>
                        <div class="price">${formatCurrency(product.preco)}</div>
                        <div class="total">${formatCurrency(itemTotal)}</div>
                    </div>
                `;
            });

            itemsTotalElement.textContent = formatCurrency(total);
            totalElement.textContent = formatCurrency(total);
            document.getElementById('total-input').value = total.toFixed(2);
        }

        function formatCurrency(value) {
            return value.toFixed(2).replace('.', ',') + ' Kz';
        }
    </script>
</body>
</html>
