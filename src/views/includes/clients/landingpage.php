
    <!-- Hero Section -->
    <section class="hero" id="home">
      <div class="container">
        <div class="hero-content">
          <p class="hero-subtitle">Bom aproveito!</p>
          <h1 class="hero-title">
          Menos Filas. <span>Menos Desperdício.</span> Mais Eficiência.  
          </h1>
          <p class="hero-description">
          Oferecemos uma experiência única, onde conveniência e sabor se encontram.
          </p>
          <div class="hero-buttons">
            
            <a href="#menu" class="btn hero-btn-outline">Ver Menu</a>
          </div>
        </div>
      </div>
      <div class="hero-scroll">
        <i class="fas fa-chevron-down"></i>
        Deslize Para Baixo
      </div>
    </section>
   
    <!-- About Section -->
    <section class="about" id="about">
      <div class="container">
        <div class="about-grid">
          <div class="about-content">
            <p class="section-subtitle">OrderFüd</p>
            <h2 class="section-title">Sobre Nós</h2>
            <p class="about-text">
            Somos uma plataforma digital que permite aos pais e encarregados de educação encomendar e pagar refeições escolares online, 
            poupando tempo e evitando filas. As escolas ganham controlo sobre a gestão de pedidos, 
            reduzindo desperdícios e otimizando recursos.
            </p>
            <p class="about-text">
             você encontrará um ambiente simples e acolhedor,
             com todas as ferramentas que você precisa para personalizar a sua refeição de forma rápida e eficaz. Desde opções saudáveis até pratos mais indulgentes, 
             todas as refeições são preparadas por uma equipe dedicada,
             que prioriza qualidade, frescor e sabor.
            </p>
            <div class="about-features">
              <div class="about-feature">
                <div class="about-feature-icon">
                  <i class="fas fa-leaf"></i>
                </div>
                <div>
                  <h4 class="about-feature-title">Ingredientes de Alta Qualidade</h4>
                  <p class="about-feature-text">
                   Ingredientes e carnes de alta qualidade
                  </p>
                </div>
              </div>
              <div class="about-feature">
                <div class="about-feature-icon">
                  <i class="fas fa-utensils"></i>
                </div>
                <div>
                  <h4 class="about-feature-title">Preparado com o cuidado</h4>
                  <p class="about-feature-text">
                   Receitas desenvolvidas por funcionarios
                  </p>
                </div>
              </div>
              <div class="about-feature">
                <div class="about-feature-icon">
                  <i class="fas fa-bolt"></i>
                </div>
                <div>
                  <h4 class="about-feature-title">Serviço Rápido</h4>
                  <p class="about-feature-text">
                  Feito na hora, sem perder tempo!
                  </p>
                </div>
              </div>
              <div class="about-feature">
                <div class="about-feature-icon">
                  <i class="fas fa-heart"></i>
                </div>
                <div>
                  <h4 class="about-feature-title">Feito com amor</h4>
                  <p class="about-feature-text">
                    Paixao e cuidado ao preparar.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="about-image">
            <div class="about-img"></div>
            <div class="about-badge">Desde 2025</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Menu Section -->
    <section class="menu" id="menu">
      <div class="container">
        <div class="menu-header">
          <p class="menu-subtitle">Nosso Menu</p>
          <h2 class="menu-title">Selecção de Produtos</h2>
          <p class="menu-description">
            Explore nossa seleção com curadoria de opções de Comidas, elaboradas
            com ingredientes premium e experiência culinária.
          </p>
        </div>
        
        <!-- Tabs de categorias dinâmicas 
        <div class="menu-tabs">
          <div class="menu-tab active">Tudo</div>
          <?php 
            //foreach($listaCategoria as $categoria) {
              //echo "<div class='menu-tab'>{$categoria['categoria']}</div>";
           // }
          ?>
        </div>-->

        <div class="menu-grid">
          <?php 
            // Buscar 6 produtos do banco de dados
            $listaProdutos = $produtos->buscarCategoria();
            $contador = 0;
            
            foreach($listaProdutos as $produto) {
              if($contador >= 6) break; // Limita a 6 produtos
              
              $badge = '';
             // if($contador == 0) $badge = '<div class="menu-item-badge">Bestseller</div>';
              //else if($contador == 2) $badge = '<div class="menu-item-badge">New</div>';
              //else if($contador == 5) $badge = '<div class="menu-item-badge">Popular</div>';
          ?>
            <div class="menu-item">
              <div class="menu-item-img" style="background-image: url('<?php echo $produto['imagem']; ?>')">
                <div class="menu-item-fav">
                  <i class="fas fa-star"></i>
                </div>
              </div>
              <?php echo $badge; ?>
              <div class="menu-item-content">
                <p class="menu-item-category"><?php echo $produto['Categoria']; ?></p>
                <h3 class="menu-item-name"><?php echo $produto['nome']; ?></h3>
                <p class="menu-item-description">
                  <?php echo $produto['descricao']; ?>
                </p>
                <div class="menu-item-bottom">
                  <div class="menu-item-price"><?php echo number_format($produto['preco'], 2, ',', '.') . ' Kz'; ?></div>
                  <div class="menu-item-btn" 
                       data-id="<?php echo $produto['idProduto']; ?>"
                       data-name="<?php echo $produto['nome']; ?>"
                       data-price="<?php echo $produto['preco']; ?>"
                       data-img="<?php echo $produto['imagem']; ?>">
                    <i class="fas fa-plus"></i> 
                  </div>
                </div>
              </div>
            </div>
          <?php 
              $contador++;
            } 
          ?>
        </div>

        <div class="text-center mt-5">
          <a href="?rota=produtos" class="btn btn-primary">Ver Menu Completo</a>
        </div>
      </div>
    </section>

    <!-- Special Section -->
    <section class="special" id="special">
      <div class="container special-container">
        <div class="special-header">
          <p class="special-subtitle"> Novidade na cantina!</p>
          <h2 class="special-title">Especiais da Cantina</h2>
          <p class="special-description">
          Delicie-se com as criações da nossa cantina, 
          feitas com ingredientes frescos e selecionados no auge do sabor. 
          Essas opções  trazem combinações de sabores criativas e irresistíveis.
          </p>
        </div>
        <div class="special-grid">
          <!-- Special Item 1 -->
          <div class="special-item">
            <div class="special-item-header">
              <div>
                <h3 class="special-item-title">Burger Especial </h3>
                <p class="special-item-subtitle">
                Perfeito para compartilhar
                </p>
              </div>
              <div class="special-item-price">3000kz</div>
            </div>
            <div class="special-item-features">
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span> Hambúrguer de frango grelhado</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Queijo mussarela</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Tomate fresquinho e um toque de molho especial com ervas do verão</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Alfase crocante</span>
              </div>
            </div>
            <div class="special-item-footer">
              <a href="?rota=produtos" class="btn btn-secondary">Encomendar Agora</a>
              <div class="special-item-badge">Sabores Exclusivos</div>
            </div>
          </div>
          <!-- Special Item 2 -->
          <div class="special-item">
            <div class="special-item-header">
              <div>
                <h3 class="special-item-title">Burger Especial</h3>
                <p class="special-item-subtitle">Perfeito para compartilhar</p>
              </div>
              <div class="special-item-price">3000kz</div>
            </div>
            <div class="special-item-features">
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Contem duas carnes</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Batata Palha</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Queijo mussarela</span>
              </div>
              <div class="special-item-feature">
                <i class="fas fa-check"></i>
                <span>Batata frita</span>
              </div>
            </div>
            <div class="special-item-footer">
              <a href="?rota=produtos" class="btn btn-secondary">Encomendar Agora</a>
              <div class="special-item-badge">Melhor preco</div>
            </div>
          </div>
        </div>
      </div>
    </section>
   
    <!-- Order Section -->
    <section class="order">
      <div class="container">
        <h2 class="order-title">Está pronto para viver a experiência do OrderFüd de alto nível?</h2>
        <p class="order-text">
        Encomende seu lanche com antecedência e garanta mais tempo pra curtir o recreio.
        Evite filas e aproveite uma refeição feita com carinho.
        </p>
        <a href="?rota=produtos" class="order-btn">Encomendar Agora</a>
      </div>
    </section>
