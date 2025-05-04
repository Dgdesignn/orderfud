document.addEventListener('DOMContentLoaded', function() {
    const cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
    const cartItemsSummary = document.getElementById('cart-items-summary');
    const cartTotalSummary = document.getElementById('cart-total-summary');
    const checkoutForm = document.getElementById('checkout-form');
    
    function formatKz(value) {
        return parseFloat(value).toFixed(2).replace('.', ',') + ' Kz';
    }

    function updateSummary() {
        let total = 0;
        cartItemsSummary.innerHTML = '';

        cartProducts.forEach(product => {
            const productTotal = product.price * product.quantity;
            total += productTotal;

            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            itemElement.innerHTML = `
                <span>${product.name} x ${product.quantity}</span>
                <span>${formatKz(productTotal)}</span>
            `;
            cartItemsSummary.appendChild(itemElement);
        });

        cartTotalSummary.textContent = formatKz(total);
        document.getElementById('produtos-input').value = JSON.stringify(cartProducts);
        document.getElementById('total-input').value = total.toFixed(2);
    }

    updateSummary();

    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (cartProducts.length === 0) {
            alert('Seu carrinho está vazio!');
            return;
        }

        const formData = new FormData(this);

        fetch('../controllers/processar_pedido.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('cartProducts');
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Erro ao processar pedido');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar pedido. Tente novamente.');
        });
    });
}); 