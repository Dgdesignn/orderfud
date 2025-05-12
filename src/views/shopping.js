document.addEventListener('DOMContentLoaded', function () {

    // Seletor mais genérico para o ícone do carrinho (funciona em ambos os layouts)
    const cartIcon = document.querySelector('.fa-shopping-cart') || document.querySelector('.bxs-cart');
    const cartIconParent = cartIcon ? cartIcon.parentElement : null;
    const cart = document.getElementById('cart');
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.querySelector('.cart-count');
    const cartTotal = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const closeCartBtn = document.querySelector('.cart-close');
    const addButtons = document.querySelectorAll('.menu-item-btn');
    let cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
    let isCartOpen = false;

    // Atualizar carrinho ao carregar a página
    updateCart();

    // Formatar valor para Kwanza
    function formatKz(value) {
        const number = parseFloat(value);
        if (isNaN(number)) return "0,00 Kz";
        return number.toFixed(2)
                     .replace('.', ',')
                     .replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' Kz';
    }
    

    // Função para fechar carrinho quando clicar fora
    function handleClickOutside(event) {
        // Verifica se o clique foi em algum elemento do carrinho ou controles
        const isCartControl = event.target.closest('.quantity-btn') || 
                            event.target.closest('.quantity-input') ||
                            event.target.closest('.menu-item-btn') ||
                            event.target.closest('.btn-remove');
                            
        if (!cart.contains(event.target) && 
            event.target !== cartIcon && 
            !cartIcon.contains(event.target) && 
            !isCartControl) {    
            toggleCart();
        }
    }

    // Função para abrir/fechar o carrinho
    function toggleCart(event) {
        if (event) {
            event.preventDefault();
            // Verifica se o clique foi em algum controle do carrinho
            if (event.target.closest('.menu-item-btn') || 
                event.target.closest('.btn-remove') ||
                event.target.closest('.quantity-btn') ||
                event.target.closest('.quantity-input')) {
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

    // Fechar carrinho quando clicar no botão de fechar
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleCart();
        });
    }

    // Função para adicionar ao carrinho
    function addToCart(name, price, img, id) {
        const existingProduct = cartProducts.find(item => item.name === name);
        console.log(cartProducts);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cartProducts.push({
                id: id,
                name: name,
                price: parseFloat(price),
                img: img,
                quantity: 1
            });
        }

        localStorage.setItem('cartProducts', JSON.stringify(cartProducts));
        updateCart();
        if (!isCartOpen) toggleCart();
    }

    // Remover produto do carrinho
    function removeFromCart(index) {
        cartProducts.splice(index, 1);
        localStorage.setItem('cartProducts', JSON.stringify(cartProducts));
        updateCart();
    }

    // Atualizar visualização do carrinho
    function updateCart() {
        if (!cartItems) return; // Verifica se o elemento existe

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
                    <span class="cart-item-price">${formatKz(product.price)}</span>
                    <input type="hidden" value="${product.id}"> <!-- Campo oculto para ID -->
                    <div class="cart-item-quantity">
                        <button class="quantity-btn minus" data-index="${index}">-</button>
                        <input type="number" class="quantity-input" value="${product.quantity}" 
                               min="1" max="99" data-index="${index}">
                        <button class="quantity-btn plus" data-index="${index}">+</button>
                    </div>
                </div>
                <div class="cart-item-actions">
                    <span class="cart-item-total">${formatKz(productTotal)}</span>
                    <button class="btn-remove" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            cartItems.appendChild(itemElement);

            // Adicionar eventos aos controles de quantidade
            const quantityInput = itemElement.querySelector('.quantity-input');
            const minusBtn = itemElement.querySelector('.minus');
            const plusBtn = itemElement.querySelector('.plus');

            quantityInput.addEventListener('change', function() {
                const newQuantity = parseInt(this.value) || 1;
                updateQuantity(index, newQuantity);
            });

            minusBtn.addEventListener('click', () => {
                if (product.quantity > 1) {
                    updateQuantity(index, product.quantity - 1);
                }
            });

            plusBtn.addEventListener('click', () => {
                updateQuantity(index, product.quantity + 1);
            });
        });

        // Atualizar totais
        if (cartTotal) cartTotal.textContent = formatKz(total);
        if (cartCount) cartCount.textContent = totalItems;

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

    // Função para atualizar quantidade
    function updateQuantity(index, newQuantity) {
        if (newQuantity > 0 && newQuantity <= 99) {
            cartProducts[index].quantity = newQuantity;
            localStorage.setItem('cartProducts', JSON.stringify(cartProducts));
            updateCart();
        }
    }
 
    // Eventos
    if (cartIconParent) {
        cartIconParent.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleCart();
        });
    }

    // Delegação de eventos para botões dinâmicos
    document.addEventListener('click', function(e) {
        const addButton = e.target.closest('.menu-item-btn');
        if (addButton) {
            e.preventDefault();
            e.stopPropagation();
            addToCart(
                addButton.getAttribute('data-name'),
                addButton.getAttribute('data-price'),
                addButton.getAttribute('data-img'),
                addButton.getAttribute('data-id')
            );
            // Efeito visual
            addButton.classList.add('added');
            setTimeout(() => addButton.classList.remove('added'), 500);
        }
    });

    // Finalizar compra
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (cartProducts.length === 0) {
                alert('Seu carrinho está vazio!');
                return;
            }

            // Fazer uma requisição para verificar o login
            fetch('check_login.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = 'checkout.php';
                    } else {
                        // Salvar a página atual para redirecionamento após o login
                        window.location.href = 'loginClient.php';
                    }
                });
        });
    }

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

// FILTRAR PRODUTOS PELO NOME
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const produtos = document.querySelectorAll('.menu-item');

    searchInput.addEventListener('input', function () {
        const termo = searchInput.value.toLowerCase().trim();

        produtos.forEach(produto => {
            const nomeProduto = produto.querySelector('.menu-item-name').textContent.toLowerCase();
            const descricaoProduto = produto.querySelector('.menu-item-description').textContent.toLowerCase();

            if (nomeProduto.includes(termo) || descricaoProduto.includes(termo)) {
                produto.style.display = 'block';
            } else {
                produto.style.display = 'none';
            }
        });
    });
});

// Função para scroll horizontal das categorias
function scrollCategory(categoryId, direction) {
    const grid = document.getElementById(`grid-${categoryId}`);
    const scrollAmount = 300;
    
    if (direction === 'left') {
        grid.scrollLeft -= scrollAmount;
    } else {
        grid.scrollLeft += scrollAmount;
    }
}

// Filtro de categorias
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar "Todos" por padrão
    document.getElementById('category-all').style.display = 'block';

    // Adicionar evento de clique para todas as abas
    document.querySelectorAll('.menu-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remover classe active de todas as abas
            document.querySelectorAll('.menu-tab').forEach(t => t.classList.remove('active'));
            
            // Adicionar classe active na aba clicada
            this.classList.add('active');
            
            // Pegar o ID da categoria
            const categoryId = this.getAttribute('data-category');
            
            // Esconder todas as seções
            document.querySelectorAll('.category-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Mostrar a seção apropriada
            if (categoryId === 'all') {
                document.getElementById('category-all').style.display = 'block';
            } else {
                document.getElementById(`category-${categoryId}`).style.display = 'block';
            }
        });
    });
});

// Adicionar animações de transição
const animateSection = (section, action) => {
    section.style.opacity = action === 'show' ? '0' : '1';
    section.style.display = action === 'show' ? 'block' : 'none';
    setTimeout(() => {
        section.style.opacity = action === 'show' ? '1' : '0';
    }, 50);
};

// Melhorar filtro de pesquisa
const filterProducts = (term) => {
    const produtos = document.querySelectorAll('.menu-item');
    const noResults = document.getElementById('no-results');
    let found = false;

    produtos.forEach(produto => {
        const nome = produto.querySelector('.menu-item-name').textContent.toLowerCase();
        const categoria = produto.querySelector('.menu-item-category').textContent.toLowerCase();
        const descricao = produto.querySelector('.menu-item-description').textContent.toLowerCase();

        if (nome.includes(term) || categoria.includes(term) || descricao.includes(term)) {
            produto.style.display = 'block';
            found = true;
        } else {
            produto.style.display = 'none';
        }
    });

    noResults.style.display = found ? 'none' : 'block';
};
