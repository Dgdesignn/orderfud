document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.getElementById('cart-icon');
    const cart = document.getElementById('cart');
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const addButtons = document.querySelectorAll('.menu-item-btn');

    let cartProducts = [];
    let isCartOpen = false;

    // Formatar valor para Kwanza (ex: 1500.50 → "1.500,50 Kz")
    function formatKz(value) {
        const number = parseFloat(value);
        if (isNaN(number)) return "0,00 Kz";
        return number.toFixed(2)
                     .replace('.', ',')
                     .replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' Kz';
    }
    

    // Função para abrir/fechar o carrinho
    function toggleCart(event) {
        if (event) {
            event.preventDefault();
            if (event.target.closest('.menu-item-btn') || event.target.closest('.btn-remove')) {
                return;
            }
        }

        isCartOpen = !isCartOpen;
        if (isCartOpen) {
            cart.classList.add('show');
            document.addEventListener('click', handleClickOutside);
        } else {
            cart.classList.remove('show');
            document.removeEventListener('click', handleClickOutside);
        }
    }

    // Fechar carrinho quando clicar fora
    function handleClickOutside(event) {
        if (!cart.contains(event.target) && event.target !== cartIcon && !cartIcon.contains(event.target)) {    
            toggleCart();
        }
    }

    // Adicionar produto ao carrinho
    function addToCart(name, price, img) {
        const existingProduct = cartProducts.find(item => item.name === name);

        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cartProducts.push({
                name: name,
                price: parseFloat(price),
                img: img,
                quantity: 1
            });
        }

        updateCart();
        if (!isCartOpen) toggleCart();
    }

    // Remover produto do carrinho
    function removeFromCart(index) {
        cartProducts.splice(index, 1);
        updateCart();
    }

    // Atualizar visualização do carrinho
    function updateCart() {
        cartItems.innerHTML = '';
        let total = 0;
        let totalItems = 0;

        cartProducts.forEach((product, index) => {
            const productTotal = product.price * product.quantity;
            total += productTotal;
            totalItems += product.quantity;

            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            itemElement.innerHTML = `
                <div class="cart-item-img">
                    <img src="${product.img}" alt="${product.name}">
                </div>
                <div class="cart-item-info">
                    <span class="cart-item-name">${product.name}</span>
                    <span class="cart-item-price">${formatKz(product.price)} x ${product.quantity}</span>
                </div>
                <div class="cart-item-actions">
                    <span class="cart-item-total">${formatKz(productTotal)}</span>
                    <button class="btn-remove" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            cartItems.appendChild(itemElement);
        });

        // Atualizar totais
        cartTotal.textContent = formatKz(total);
        cartCount.textContent = totalItems;

        // Eventos para botões de remover
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                removeFromCart(parseInt(this.getAttribute('data-index')));
            });
        });

        if (cartProducts.length === 0) {
            cartItems.innerHTML = '<p class="empty-cart">Seu carrinho está vazio</p>';
        }
    }

    // Eventos
    cartIcon.addEventListener('click', toggleCart);

    // Delegação de eventos para botões dinâmicos
    document.addEventListener('click', function(e) {
        const addButton = e.target.closest('.menu-item-btn');
        if (addButton) {
            e.preventDefault();
            e.stopPropagation();
            addToCart(
                addButton.getAttribute('data-name'),
                addButton.getAttribute('data-price'),
                addButton.getAttribute('data-img')
            );
            // Efeito visual
            addButton.classList.add('added');
            setTimeout(() => addButton.classList.remove('added'), 500);
        }
    });

    // Finalizar compra
    checkoutBtn.addEventListener('click', function() {
        if (cartProducts.length > 0) {
            alert(`Compra finalizada! Total: ${formatKz(cartTotal.textContent.replace(' Kz', ''))}`);
            cartProducts = [];
            updateCart();
            toggleCart();
        } else {
            alert('Seu carrinho está vazio!');
        }
    });

    // Favoritos (opcional)
    document.querySelectorAll('.menu-item-fav').forEach(fav => {
        fav.addEventListener('click', (e) => {
            e.stopPropagation();
            fav.classList.toggle('active');
            const icon = fav.querySelector('i');
            icon.classList.toggle('fas');
            icon.classList.toggle('far');
        });
    });
});


/* document.addEventListener('click', function (e) {
        // Verifica se o clique foi em um botão de adicionar
        const addButton = e.target.closest('.menu-item-btn');
        if (addButton) {
            e.preventDefault();
            e.stopPropagation();
            
            const name = addButton.getAttribute('data-name');
            const price = parseFloat(addButton.getAttribute('data-price'));
            const img = addButton.getAttribute('data-img');
            
            addToCart(name, price, img);

            // Efeito visual de adicionado
            addButton.classList.add('added');
            setTimeout(() => {
                addButton.classList.remove('added');
            }, 500);
        }
    });

*/