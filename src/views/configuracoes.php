<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurações do Usuário</title>
  <link rel="stylesheet" href="configuracoes.css">
</head>
<body>
  <div class="config-container">
    <h2>⚙️ Configurações da Conta</h2>

   

    <!-- Notificações -->
    <section class="config-section">
      <h3>🔔 Notificações</h3>
      <label class="switch">
        <input type="checkbox" id="notificacoes" checked>
        <span class="slider round"></span>
      </label>
      <span id="notificacao-status">Ativadas</span>
    </section>

    <!-- Idioma -->
    <section class="config-section">
      <h3>🌐 Idioma da Plataforma</h3>
      <select id="idioma">
        <option value="pt" selected>Português</option>
        <option value="en">Inglês</option>
        <option value="fr">Francês</option>
      </select>
    </section>

    <!-- Eliminar conta -->
    <section class="config-section danger-zone">
      <h3>⚠️ Eliminar Conta</h3>
      <button class="delete-btn" onclick="confirmarEliminacao()">Eliminar Conta</button>
    </section>
  </div>


  <ul class="side-menu">
		<li>
			<a href="userPerfil.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Sair</span>
			</a>
		</li>
	</ul>
  <script src="configuracoes.js"></script>

</body>
</html>
