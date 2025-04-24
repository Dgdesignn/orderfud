<?php

    $tipoUsuario = $_SESSION["user"]["tipo"];

?>
<nav>
	<i class='bx bx-menu'></i>
	<?php
        if ($tipoUsuario == "administrador") {
            echo '<a href="#" class="nav-link">Administrador</a>';
		} else {
            echo '<a href="#" class="nav-link"> Área do Funcionário</a>';
		}
    ?>
	<form action="#">
		<div class="form-input">
			<input type="search" placeholder="Buscar no sistema...">
			<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
		</div>
	</form>
	<input type="checkbox" id="switch-mode" hidden>
	<label for="switch-mode" class="switch-mode"></label>
	<a href="#" class="notification">
		<i class='bx bxs-bell'></i>
		<span class="num">10</span>
	</a>
	<a href="userPerfil.php" class="profile">
		<img src="user1.jpg">
	</a>
</nav>