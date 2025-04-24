<?php echo $rota;?>

<div class="container">
        <nav class="navbar">
          <a href="#" class="logo">OrderFüd</a>
          <ul class="nav-menu">
<?php echo $rota;?>
<li><a href="#home" class="nav-link active">Home </a></li>
            <li><a href="#about" class="nav-link">Sobre</a></li>
            <li><a href="#menu" class="nav-link">Menu</a></li>
            <li><a href="#special" class="nav-link">Especiais</a></li>
            <li><a href="#contact" class="nav-link">Contacto</a></li>
          </ul>
          <div class="nav-buttons">
            <a href="#" class="nav-icon">
              <i class="fas fa-search"></i>
            </a>
            <a href="#" class="nav-icon">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-count">3</span>
            </a>
            <a href="?rota=login" class="btn btn-primary">Encomendar Agora!</a>
          </div>
          <div class="mobile-toggle">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </nav>
</div>