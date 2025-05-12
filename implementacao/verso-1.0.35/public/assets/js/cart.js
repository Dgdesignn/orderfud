class Cart {
    constructor() {
        this.items = JSON.parse(localStorage.getItem('cart')) || [];
        this.total = 0;
        this.init();
    }

    init() {
        this.updateTotal();
        this.renderCart();
        this.bindEvents();
    }

    bindEvents() {
        // Toggle carrinho
        $('.cart-toggle').addEventListener('click', () => {
            $('.cart-container').classList.toggle('active');
        });

        // Fechar carrinho
        $('.cart-close').addEventListener('click', () => {
            $('.cart-container').classList.remove('active');
        });

        // Finalizar pedido
        $('#checkout-btn').addEventListener('click', () => {
            if (this.items.length === 0) {
                toast.show('Seu carrinho está vazio', 'warning');
                return;
            }
            window.location.href = '/checkout';
        });
    }

    addItem(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            this.items.push(product);
        }

        this.updateCart();
        toast.show('Produto adicionado ao carrinho', 'success');
    }

    removeItem(id) {
        this.items = this.items.filter(item => item.id !== id);
        this.updateCart();
    }

    updateQuantity(id, quantity) {
        const item = this.items.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.updateCart();
        }
    }

    updateTotal() {
        this.total = this.items.reduce((sum, item) => {
            return sum + (item.price * item.quantity);
        }, 0);
    }

    updateCart() {
        this.updateTotal();
        this.saveCart();
        this.renderCart();
        this.updateCartCount();
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    }

    updateCartCount() {
        const count = this.items.reduce((sum, item) => sum + item.quantity, 0);
        $('.cart-count').textContent = count;
    }

    renderCart() {
        const cartItems = $('.cart-items');
        const cartTotal = $('.cart-total strong');

        cartItems.innerHTML = this.items.map(item => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    <p>${item.price.toFixed(2)} Kz</p>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn minus" data-id="${item.id}">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn plus" data-id="${item.id}">+</button>
                    </div>
                </div>
                <button class="remove-item" data-id="${item.id}">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        `).join('') || '<p class="empty-cart">Seu carrinho está vazio</p>';

        cartTotal.textContent = `${this.total.toFixed(2)} Kz`;

        this.bindItemEvents();
    }

    bindItemEvents() {
        $$('.remove-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.removeItem(e.target.dataset.id);
            });
        });

        $$('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.target.dataset.id;
                const item = this.items.find(item => item.id === id);
                if (item) {
                    if (btn.classList.contains('plus')) {
                        this.updateQuantity(id, item.quantity + 1);
                    } else {
                        this.updateQuantity(id, item.quantity - 1);
                    }
                }
            });
        });
    }
}

// Inicializa o carrinho
const cart = new Cart(); 