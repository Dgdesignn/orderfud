alert('teste'); 

// Função para adicionar produto ao carrinho
function addToCart(id, name, price) {
    let cart = JSON.parse(localStorage.getItem('cartProducts')) || [];
    
    // Verifica se o produto já existe no carrinho
    let existingProduct = cart.find(item => item.id === id);
    
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            quantity: 1
        });
    }
    
    localStorage.setItem('cartProducts', JSON.stringify(cart));
    updateCartDisplay();
}

// Função para atualizar a exibição do carrinho
function updateCartDisplay() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const cart = JSON.parse(localStorage.getItem('cartProducts')) || [];
    let total = 0;
    
    cartItems.innerHTML = '';
     
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        cartItems.innerHTML += `
            <div class="cart-item">
                <div class="item-info">
                    <span class="item-name">${item.name}</span>
                    <span class="item-price">${formatCurrency(itemTotal)}</span>
                </div>
                <div class="item-quantity">
                    <button onclick="updateQuantity(${item.id}, -1)">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
                <button onclick="removeFromCart(${item.id})" class="remove-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
    });
    
    cartTotal.textContent = formatCurrency(total);
}

// Função para atualizar quantidade
function updateQuantity(id, change) {
    let cart = JSON.parse(localStorage.getItem('cartProducts')) || [];
    const index = cart.findIndex(item => item.id === id);
    
    if (index !== -1) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        localStorage.setItem('cartProducts', JSON.stringify(cart));
        updateCartDisplay();
    }
}

// Função para remover item do carrinho
function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cartProducts')) || [];
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cartProducts', JSON.stringify(cart));
    updateCartDisplay();
}

// Função para formatar moeda
function formatCurrency(value) {
    return value.toFixed(2).replace('.', ',') + ' Kz';
}

// Inicializar carrinho
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
    
    // Adicionar evento ao botão de checkout
    document.getElementById('checkout-btn').addEventListener('click', function() {
        const cart = JSON.parse(localStorage.getItem('cartProducts')) || [];
        console.log(cart);
        
        if (cart.length > 0) {
            window.location.href = 'checkout.php';
        } else {
            alert('Seu carrinho está vazio!');
        }

    });
}); 