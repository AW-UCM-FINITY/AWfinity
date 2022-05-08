<?php
require_once(RAIZ_APP.'/helpers/autorizacion.php');
function mostrarSaludo() {
	if (estaLogado()) {
		return "¡Bienvenido {$_SESSION['nombreUsuario']}!    <a class = 'perfil' href='perfil.php'><i class='fas icon-user'> </i></a><a href='logout.php'><i class='fas icon-switch'> </i></a>";
		
	} else {
		return "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}
}
?>
<header>
	<?php
		$saludo ='';
		require(RAIZ_APP.'/vistas/comun/menuPrincipal.php');
	?>	
	<div class="saludo">
		<div>
			<?= $saludo = mostrarSaludo(); ?>
		</div>
	</div>
</header>
