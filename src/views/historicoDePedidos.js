function repetirPedido(idPedido) {
    
    const pedidos = [
      {
        id: 1,
        data: '2025-04-08',
        status: 'Concluído',
        total: '25.00',
        itens: [
          { nome: 'Arroz com Feijão', quantidade: 2, preco: 5.00 },
          { nome: 'Fruta', quantidade: 1, preco: 10.00 },
        ],
      },
      {
        id: 2,
        data: '2025-04-09',
        status: 'Pendente',
        total: '15.00',
        itens: [
          { nome: 'Sanduíche', quantidade: 1, preco: 5.00 },
          { nome: 'Suco', quantidade: 1, preco: 10.00 },
        ],
      },
    ];
  
    const pedido = pedidos.find(p => p.id === idPedido);  
    if (pedido) {
      alert(`Pedido repetido: ${pedido.itens.map(item => `${item.quantidade}x ${item.nome}`).join(', ')}`);
      
    }
  }
  