<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bebidas Naturais</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }

    /* Menu */
    header {
      background-color: #006241;
      padding: 20px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    nav {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }

    nav h1 {
      color: white;
      font-size: 24px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #d4f1e6;
    }

    /* Hero */
    .hero {
      background-image: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1600&q=80');
      background-size: cover;
      background-position: center;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;

      max-width: 1200px;
      margin: 40px auto;
      border-radius: 16px;
      overflow: hidden;
    }

    .hero-content {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 20px 40px;
      border-radius: 12px;
      text-align: center;
    }

    .hero h2 {
      font-size: 3em;
    }

    /* Seções */
    section {
      max-width: 1200px;
      margin: 60px auto;
      padding: 0 20px;
    }

    .category-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .category-header h3 {
      font-size: 2em;
      color: #006241;
      margin: 0;
    }

    .arrow-group {
      display: flex;
      gap: 10px;
    }

    .arrow.round {
      width: 40px;
      height: 40px;
      background-color: #e6f0ec;
      border: none;
      border-radius: 50%;
      font-size: 1.2em;
      color: #006241;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.3s ease;
    }

    .arrow.round:hover {
      background-color: #cce3d9;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .product {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
      padding: 15px;
      transition: transform 0.3s ease;
    }

    .product:hover {
      transform: translateY(-5px);
    }

    .product img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .product img:hover {
      transform: scale(1.05);
    }

    .product h4 {
      margin: 15px 0 5px;
    }

    .product p {
      color: #666;
    }

    .product button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #006241;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .product button:hover {
      background-color: #004c32;
    }

    /* Linha divisora */
    .divider {
      border: none;
      height: 2px;
      background-color: #ccc;
      margin: 60px 0;
      width: 100%;
      opacity: 0.5;
      border-radius: 2px;
    }
  </style>
</head>
<body>

  <!-- Menu -->
  <header>
    <nav>
      <h1>Bebidas Naturais</h1>
      <ul>
        <li><a href="#cafes">Cafés</a></li>
        <li><a href="#chas">Chás</a></li>
        <li><a href="#frias">Bebidas Frias</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero -->
  <div class="hero">
    <div class="hero-content">
      <h2>Explora Sabores Autênticos</h2>
    </div>
  </div>

  <!-- Cafés -->
  <section id="cafes">
    <div class="category-header">
      <h3>Cafés</h3>
      <div class="arrow-group">
        <button class="arrow round">←</button>
        <button class="arrow round">→</button>
      </div>
    </div>
    <div class="products">
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?espresso" alt="Espresso">
        <h4>Espresso Intenso</h4>
        <p>Rico e encorpado.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?latte" alt="Latte">
        <h4>Latte Cremoso</h4>
        <p>Com um toque suave de leite.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
    </div>
    <hr class="divider" />
  </section>

  <!-- Chás -->
  <section id="chas">
    <div class="category-header">
      <h3>Chás</h3>
      <div class="arrow-group">
        <button class="arrow round">←</button>
        <button class="arrow round">→</button>
      </div>
    </div>
    <div class="products">
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?green-tea" alt="Chá Verde">
        <h4>Chá Verde</h4>
        <p>Refrescante e saudável.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?herbal-tea" alt="Chá de Ervas">
        <h4>Chá de Ervas</h4>
        <p>Aroma natural e relaxante.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
    </div>
    <hr class="divider" />
  </section>

  <!-- Bebidas Frias -->
  <section id="frias">
    <div class="category-header">
      <h3>Bebidas Frias</h3>
      <div class="arrow-group">
        <button class="arrow round">←</button>
        <button class="arrow round">→</button>
      </div>
    </div>
    <div class="products">
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?iced-coffee" alt="Café Gelado">
        <h4>Café Gelado</h4>
        <p>Refrescante e energizante.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
      <div class="product">
        <img src="https://source.unsplash.com/400x300/?smoothie" alt="Smoothie">
        <h4>Smoothie de Frutas</h4>
        <p>Naturalmente doce.</p>
        <button>Adicionar ao Carrinho</button>
      </div>
    </div>
    <hr class="divider" />
  </section>


  <script>
  const scrollAmount = 300; // distância que vai rolar

  document.querySelectorAll('.scroll-left').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const container = document.getElementById(targetId);
      container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
  });

  document.querySelectorAll('.scroll-right').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.getAttribute('data-target');
      const container = document.getElementById(targetId);
      container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
  });
</script>


</body>
</html>










<div class="container">
            <div class="container" id="FastFood">
            <div class="menu-grid">
              <!-- Menu Item 1 -->
            <?php 
                require "../controllers/productController.php";
                $produtos = new ProductController();
                $resultado =$produtos->buscarCategoria();
              

            ?>

              <!-- Menu Item 4 -->

            <?php 

                foreach($resultado as $produto){

                
            ?>
                <div class="menu-item">
                  <div class="menu-item-img" style="background-image: url('https://img.freepik.com/free-photo/french-fries-with-ketchup-mayonnaise_23-2148290655.jpg')"></div>
                  <div class="menu-item-content">
                    <p class="menu-item-category">Sides</p>
                    <h3 class="menu-item-name"><?=$produto['nome']?></h3>
                    <p class="menu-item-description">
                      <?=$produto['descricao']?>
                    </p>
                    <div class="menu-item-bottom">
                      <div class="menu-item-price"><?=$produto['preco']?>Kz</div>
                      <div class="menu-item-btn" data-name="Truffle Parmesan Fries" data-price="8.95" data-img="https://img.freepik.com/free-photo/french-fries-with-ketchup-mayonnaise_23-2148290655.jpg">
                        <i class="fas fa-plus"></i>
                      </div>
                    </div>
                  </div>
                </div>
            <?php } ?>       
          </div>
            
          </div>

















          <?php 
			
			$rota = $_GET["rota"];
			switch($rota){
				case "historicoDePedidos":
				case "/":
					include "./historicoDePedidos.php";
					break;
				case "saldoCarteira":
					include "./pages/saldoCarteira.php";
					break;
				case "Favoritos":
					include "./Favoritos.php";
					break;
				case "configuracoes":
					include "./configuracoes.php";
					break;
			
				default :
					echo "Pagina nao encontrada";

		}
    ?>













<?php
session_start();
require "../controllers/categoryController.php";
require "../controllers/productController.php";

$categorias = new CategoryController();
$listaCategoria = $categorias->buscarCategoria();
$produtos = new ProductController();
$resultado = $produtos->buscarCategoria();

// Lógica do carrinho
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_GET['adicionar'])) {
    $idProduto = (int) $_GET['adicionar'];
    $produtoEncontrado = null;
    
    // Encontrar o produto pelo ID
    foreach ($resultado as $key => $produto) {
        if ($key == $idProduto) {
            $produtoEncontrado = $produto;
            break;
        }
    }
    
    if ($produtoEncontrado) {
        if (isset($_SESSION['carrinho'][$idProduto])) {
            $_SESSION['carrinho'][$idProduto]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$idProduto] = [
                'quantidade' => 1,
                'nome' => $produtoEncontrado['nome'],
                'preco' => $produtoEncontrado['preco'],
                'imagem' => $produtoEncontrado['imagem']
            ];
        }
        
        // Redireciona para evitar reenvio do formulário
        header("Location: ".str_replace('?adicionar='.$idProduto, '', $_SERVER['REQUEST_URI']));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=Outfit:wght@200;300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="shopping.css?=123">
    <style>
        /* Estilos para o carrinho flutuante */
        .cart {
            position: fixed;
            top: 0;
            right: -400px;
            width: 350px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000;
        }
        .cart.show {
            right: 0;
        }
        .cart-item {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .cart-item-img {
            width: 50px;
            margin-right: 10px;
        }
        .cart-item-img img {
            width: 100%;
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .btn-remove {
            background: #ff4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .empty-cart {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
  <!-- Cabeçalho -->
  <header class="header">
    <div class="container">
      <nav class="navbar">
        <a href="#" class="logo">OrderFüd</a>
        <ul class="nav-menu">
          <form action="#">
            <div class="form-input">
              <input type="search" placeholder="Buscar no sistema...">
              <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
          </form>
        </ul>
        <div class="nav-buttons">
          <a href="#" class="nav-icon" id="cart-icon">
            <i class='bx bxs-cart'></i>
            <span class="cart-count" id="cart-count"><?php echo array_sum(array_column($_SESSION['carrinho'], 'quantidade')); ?></span>
          </a>
          <a href="cadastro1.php" class="nav-icon">
            <i class='bx bxs-user'></i>
            <span class="cart-count">0</span>
          </a>
        </div>
      </nav>
    </div>
  </header>
    
  <!-- Carrinho de compras -->
  <div id="cart" class="cart">
    <h3>Produtos no Carrinho</h3>
    <div id="cart-items">
        <?php
        $totalCarrinho = 0;
        foreach($_SESSION['carrinho'] as $key => $value) {
            $total = $value['quantidade'] * $value['preco'];
            $totalCarrinho += $total;
            echo '
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="'.$value['imagem'].'" alt="'.$value['nome'].'">
                </div>
                <div class="cart-item-info">
                    <span class="cart-item-name">'.$value['nome'].'</span>
                    <span class="cart-item-price">'.$value['preco'].' Kz x '.$value['quantidade'].'</span>
                </div>
                <div class="cart-item-actions">
                    <span class="cart-item-total">'.($value['quantidade'] * $value['preco']).' Kz</span>
                    <a href="remover.php?remover=carrinho&id='.$key.'" class="btn-remove">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>';
        }
        
        if (empty($_SESSION['carrinho'])) {
            echo '<p class="empty-cart">Seu carrinho está vazio</p>';
        }
        ?>
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total:</span>
            <span id="cart-total"><?php echo $totalCarrinho; ?> Kz</span>
        </div>
        <a href="finalizar.php?finalizar=true" class="btn-orange" id="checkout-btn">Finalizar Compra</a>
    </div>
  </div>

  <!-- Restante do seu HTML... -->
  <div class="hero">
    <div class="hero-content">
      <h2>Explora Sabores Autênticos</h2>
    </div>
  </div>

  <section class="menu" id="menu">
    <div class="menu-tabs">
      <div class="menu-tab active">Tudo</div>
      <div class="menu-tab">Fastfood</div>
      <div class="menu-tab">Frutas</div>
      <div class="menu-tab">Doces</div>
      <div class="menu-tab">Salgados</div>
      <div class="menu-tab">Bebidas</div>
    </div> 

    <div class="container">
      <div class="container" id="FastFood">
        <div class="category-header">
          <h3>FastFood</h3>
          <div class="arrow-group">
            <button class="arrow round">←</button>
            <button class="arrow round">→</button>
          </div>
        </div>
        <div class="menu-grid">
          <?php foreach($resultado as $key => $produto): ?>
          <div class="menu-item">
            <div class="menu-item-img" style="background-image: url(<?=$produto['imagem']?>)">
              <div class="menu-item-fav">
                <i class="fas fa-star"></i>
              </div>
            </div>
            <div class="menu-item-content">
              <p class="menu-item-category"><?=$produto['Categoria']?></p>
              <h3 class="menu-item-name"><?=$produto['nome']?></h3>
              <p class="menu-item-description"><?=$produto['descricao']?></p>
              <div class="menu-item-bottom">
                <div class="menu-item-price"><?=$produto['preco']?>Kz</div>
                <a href="?adicionar=<?=$key?>" class="menu-item-btn">
                  <i class="fas fa-plus"></i>
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>  
        </div>      
      </div>
      <hr class="divider" />
    </div>
  </section>
  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartIcon = document.getElementById('cart-icon');
        const cart = document.getElementById('cart');
        let isCartOpen = false;

        // Função para abrir/fechar o carrinho
        function toggleCart(event) {
            if (event) {
                event.preventDefault();
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

        // Evento para o ícone do carrinho
        cartIcon.addEventListener('click', toggleCart);

        // Efeito visual ao adicionar itens
        document.querySelectorAll('.menu-item-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                this.classList.add('added');
                setTimeout(() => {
                    this.classList.remove('added');
                }, 500);
            });
        });

        // Favoritos
        document.querySelectorAll('.menu-item-fav').forEach(fav => {
            fav.addEventListener('click', () => {
                fav.classList.toggle('active');
                fav.querySelector('i').classList.toggle('fas');
                fav.querySelector('i').classList.toggle('far');
            });
        });
    });
  </script>
</body>
</html>