
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

  
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="stela.css" />
    <link rel="stylesheet" href="asset/css/checkout.css?dd=1">
</head>
<body>

    <div class="container">
        <div class="checkout-container">
            <div class="cart-section">
                <h2>Carrinho de Comparas<span id="items-count">0 Items</span></h2>
                
                <div class="cart-items" id="cart-items-container">
                    <!-- Cart items will be dynamically added here -->
                </div>

                <a href="shopping.php" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> 
                    Continuar a Comprar
                </a>
            </div>

            <div class="order-summary-section">
                <h2>Resumo do pedido</h2>
                
                <div class="summary-details">
                    <div class="summary-row">
                        <span>ITENS</span>
                        <span id="items-total">0,00 Kz</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Forma de pagamento</span>
                        <div class="shipping-select" id="payment-info">
                            <div>
                                <select id="shipping-method" onchange="handlePaymentMethod(this.value)">
                                    <option value="">Selecionar</option>
                                    <option value="cash">Cash</option>
                                    <option value="carteira">Carteira</option>
                                </select>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                 
                    
                    <div class="total-cost">
                        <span>TOTAL</span>
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
                           Finalizar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let userWalletBalance = 400000; // Substitua pelo valor real da carteira do usuário

        function handlePaymentMethod(method) {
            const paymentInfo = document.getElementById('payment-info');
            const total = parseFloat(document.getElementById('total-input').value);
            const sm = document.querySelector('.payment-message')
            if(sm){
                sm.forEach(el => el.remove());
            }

            if (method === 'cash') {

                let element = '<p class="payment-message">O pagamento deve ser feito no momento da entrega.</p>';
                paymentInfo.insertAdjacentHTML('afterend', element)
            } else if (method === 'carteira') {
                if (userWalletBalance < total) {
                    showInsufficientFundsModal();
                } else {
                   
                    let elemento = `
                    <p class="payment-message">Saldo disponível:</p>
                    <p class="payment-message"> ${userWalletBalance}</p>
                    <p class="payment-message">Valor a Debita:  </p>
                    <p class="payment-message">-${total}</p>
                    <p class="payment-message">Saldo Actual:</p>
                    <p class="payment-message">  ${userWalletBalance}</p>
                    `;
                    paymentInfo.insertAdjacentHTML('afterend', elemento)
                }
            } else {
                let spn = "<span></span> <span></span>"
                 paymentInfo.insertAdjacentHTML('afterend', spn)
            }
        }

        function showInsufficientFundsModal() {
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <h3>Saldo Insuficiente</h3>
                    <p>Você não possui saldo suficiente para realizar esta compra.</p>
                    <button onclick="closeModal(this)">Fechar</button>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function closeModal(button) {
            button.closest('.modal').remove();
            document.getElementById('shipping-method').value = '';
        }

        function updateItemQuantity(productId, change) {
            const cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
            const product = cartProducts.find(p => p.id === productId);
            
            if (product) {
                product.quantity = Math.max(1, product.quantity + change);
                localStorage.setItem('cartProducts', JSON.stringify(cartProducts));
                updateOrderSummary(cartProducts);
            }
        }

        function removeItem(productId) {
            let cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
            cartProducts = cartProducts.filter(p => p.id !== productId);
            localStorage.setItem('cartProducts', JSON.stringify(cartProducts));
            
            if (cartProducts.length === 0) {
                window.location.href = 'shopping.php';
            } else {
                updateOrderSummary(cartProducts);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
            
            if (cartProducts.length === 0) {
                alert('Seu carrinho está vazio!');
                window.location.href = 'shopping.php';
                return;
            }

            console.log(cartProducts)

            const formattedProducts = cartProducts.map(product => ({
                idProduto: parseInt(product.id),
                quantidade: parseInt(product.quantity),
                preco: parseFloat(product.price),
                nome: product.name,
                imagem: product.img
            }));

            console.log(formattedProducts)
            
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
                                <button class="remove-btn">Remover</button>
                            </div>
                        </div>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="updateItemQuantity(${product.idProduto}, -1)">-</button>
                            <input type="number" value="${product.quantidade}" readonly>
                            <button class="quantity-btn" onclick="updateItemQuantity(${product.idProduto}, 1)">+</button>
                        </div>
                       
                       
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
