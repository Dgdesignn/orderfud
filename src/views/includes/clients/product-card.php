<div class="product-card">
    <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
    <div class="product-info">
        <h3><?php echo $produto['nome']; ?></h3>
        <p><?php echo $produto['descricao']; ?></p>
        <div class="product-price">
            <?php echo number_format($produto['preco'], 2, ',', '.'); ?> Kz
        </div>
        <button onclick="addToCart(
            <?php echo $produto['idProduto']; ?>, 
            '<?php echo addslashes($produto['nome']); ?>', 
            <?php echo $produto['preco']; ?>
        )" class="btn btn-primary">
            Adicionar ao Carrinho
        </button>
    </div>
</div> 