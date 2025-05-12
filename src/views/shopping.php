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
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="shopping.css?=123">
  <link rel="stylesheet" href="asset/css/cart.css">
</head>

<body>
  <!-- Cabeçalho -->
  <header class="header">
    <div class="container">
      <nav class="navbar">
        <a href="?rota=home" class="logo">OrderFüd</a>
        <ul class="nav-menu">
          <form action="#">
            <div class="form-input">
              <input type="search" placeholder="Buscar no sistema..." id="searchInput">
              <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
          </form>
        </ul>
        <div class="nav-buttons">
          <a href="#" class="nav-icon" id="cart-icon">
            <i class='bx bxs-cart'></i>
            <span class="cart-count" id="cart-count">0</span>
          </a>
          <a href="dashboard-client.php" class="nav-icon">
            <i class='bx bxs-user'></i>
          </a>
        </div>
      </nav>
    </div>
  </header>

  <!-- Carrinho de compras 
  <div id="cart" class="cart">
    <div class="cart-header">
        <h3>Seu Pedido</h3>
        <button class="cart-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div id="cart-items" class="cart-items">
     Items serão adicionados dinamicamente 
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            Total: <span id="cart-total">0,00 Kz</span>
        </div>
        <button id="checkout-btn" class="btn btn-primary">Finalizar Pedido</button>
    </div>
  </div>
  -->


  <!-- Seção Home imagem-->
  <div class="hero">
    <div class="hero-content">
      <h2>Explora Sabores Autênticos</h2>
    </div>
  </div>

  <!-- Seção Menu -->
  <section class="menu" id="menu">
    <!--categorias-->
    <div class="menu-tabs">
      <div class="menu-tab active" data-category="all">Tudo</div>
      <?php foreach ($listaCategoria as $categoria): ?>
        <div class="menu-tab" data-category="<?= $categoria['idCategoria'] ?>">
          <?= $categoria['categoria'] ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!--cards dos produtos-->
    <div class="container">
        <?php foreach ($listaCategoria as $categoria): 
            // Busca produtos específicos desta categoria
            $produtosPorCategoria = $produtos->buscarPorCategoria($categoria['idCategoria']);
        ?>
            <div class="category-section" id="category-<?= $categoria['idCategoria'] ?>" style="display: none;">
                <div class="category-header">
                    <h3><?= $categoria['categoria'] ?></h3>
                    <div class="arrow-group">
                        <button class="arrow round" onclick="scrollCategory('<?= $categoria['idCategoria'] ?>', 'left')">←</button>
                        <button class="arrow round" onclick="scrollCategory('<?= $categoria['idCategoria'] ?>', 'right')">→</button>
                    </div>
                </div>

                <div class="menu-grid" id="grid-<?= $categoria['idCategoria'] ?>">
                    <?php if (!empty($produtosPorCategoria)): ?>
                        <?php foreach ($produtosPorCategoria as $produto): ?>
                            <div class="menu-item">
                                <div class="menu-item-img" style="background-image: url(<?= $produto['imagem'] ?>)">
                                    <div class="menu-item-fav">
                                        <i class="fas fa-star"></i>
                                    </div> 
                                </div>
                                <div class="menu-item-content">
                                    <p class="menu-item-category"><?= $produto['Categoria'] ?></p>
                                    <h3 class="menu-item-name"><?= $produto['nome'] ?></h3>
                                    <p class="menu-item-description"><?= $produto['descricao'] ?></p>
                                    <div class="menu-item-bottom">
                                        <div class="menu-item-price"><?= number_format($produto['preco'], 2, ',', '.') ?> Kz</div>
                                        <div class="menu-item-btn" 
                                             data-id="<?= $produto['idProduto'] ?>"
                                             data-name="<?= htmlspecialchars($produto['nome']) ?>"
                                             data-price="<?= $produto['preco'] ?>"
                                             data-img="<?= $produto['imagem'] ?>">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum produto encontrado nesta categoria.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Seção "Todos" que será mostrada por padrão -->
        <div class="category-section" id="category-all">
            <div class="menu-grid">
                <?php 
                // Busca todos os produtos
                $todosProdutos = $produtos->buscarCategoria();
                foreach ($todosProdutos as $produto): 
                ?>
                    <div class="menu-item">
                        <div class="menu-item-img" style="background-image: url(<?= $produto['imagem'] ?>)">
                            <div class="menu-item-fav">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="menu-item-content">
                            <p class="menu-item-category"><?= $produto['Categoria'] ?></p>
                            <h3 class="menu-item-name"><?= $produto['nome'] ?></h3>
                            <p class="menu-item-description"><?= $produto['descricao'] ?></p>
                            <div class="menu-item-bottom">
                                <div class="menu-item-price"><?= number_format($produto['preco'], 2, ',', '.') ?> Kz</div>
                                <div class="menu-item-btn" 
                                     data-id="<?= $produto['idProduto'] ?>"
                                     data-name="<?= htmlspecialchars($produto['nome']) ?>"
                                     data-price="<?= $produto['preco'] ?>"
                                     data-img="<?= $produto['imagem'] ?>">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </section>

</body>

</html>