<div class="head-title">
    <div class="left">
        <h1>Meu Perfil</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Perfil</a></li>
        </ul>
    </div>
</div>

<div class="perfil-box">
    <div class="perfil-info">
        <div class="user-avatar">
            <i class='bx bxs-user'></i>
        </div>
        <form class="perfil-form">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" value="<?php echo $_SESSION['client']['nome']; ?>" readonly>
            </div>
          
            <div class="form-group">
                <label>Telefone</label>
                <input type="tel" value="<?php echo $_SESSION['client']['telefone']; ?>" readonly>
            </div>
            <button type="button" class="btn-primary">
                <i class='bx bxs-edit'></i>
                Editar Perfil
            </button>
        </form>
    </div>
</div> 