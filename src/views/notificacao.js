
// Usando JavaScript para atualização automática
setInterval(() => {
  fetch('/notificacoes/atualizar')
     .then(response => response.json())
     .then(data => {
         // Atualizar a lista de notificações
     });
}, 30000); // Atualiza a cada 30 segundos