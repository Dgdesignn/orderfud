document.querySelector('.btn-recarga').addEventListener('click', () => {
    const valor = prompt('Quanto deseja adicionar à sua carteira?');
    if (valor && !isNaN(valor)) {
      alert(`R$ ${parseFloat(valor).toFixed(2)} será adicionado à sua carteira!`);
      // Aqui você pode chamar uma função para salvar isso no banco
    }
  });
  