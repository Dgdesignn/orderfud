// Atualiza status do toggle de notificações
document.getElementById("notificacoes").addEventListener("change", function () {
    const status = this.checked ? "Ativadas" : "Desativadas";
    document.getElementById("notificacao-status").textContent = status;
  });
  
  function salvarPerfil() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const telefone = document.getElementById("telefone").value;
    alert(`Perfil atualizado:\nNome: ${nome}\nEmail: ${email}\nTelefone: ${telefone}`);
  }
  
  function confirmarEliminacao() {
    if (confirm("Tem certeza que deseja eliminar sua conta? Esta ação é irreversível!")) {
      alert("Conta eliminada com sucesso!");
      // Aqui você pode redirecionar ou chamar a API para eliminar a conta
    }
  }
  