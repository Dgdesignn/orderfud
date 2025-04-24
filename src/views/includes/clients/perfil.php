<h1>fperfil</h1>
<div class="profile-section">
      <h1>Editar Perfil</h1>

      <!-- Formulário de Edição de Perfil -->
      <form action="#" method="POST" enctype="multipart/form-data">
          <div class="profile-form">
              <div class="img-box">
                  <figure class="profile-photo">
                      <img src="user1.jpg" class="imgpreview" alt="Imagem de perfil" />
                      <input type="file" class="imgprofile" name="profileImg" required hidden>
                  </figure>
              </div>

              <div class="form-group">
                  <label for="name">Nome</label>
                  <input type="text" id="name" placeholder="Digite seu nome" required>
              </div>

              <div class="form-group">
                  <label for="phone">Telefone</label>
                  <input type="text" id="phone" placeholder="Digite seu telefone" required>
              </div>

              <div class="form-group">
                  <label for="password">Senha</label>
                  <input type="password" id="password" placeholder="Digite sua senha" required>
              </div>

              <button id="save-btn" type="submit">Salvar Edição</button>
          </div>
      </form>
    </div>