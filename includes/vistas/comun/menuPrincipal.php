<nav id="menuP">
	<ul class="nav">
		<li><a href="<?= RUTA_APP ?>/index.php">HOME</a></li>
		<li><a href="<?= RUTA_APP ?>/contenidoPelis.php">PELÍCULAS</a></li>
		<li><a href="<?= RUTA_APP ?>/contenidoSeries.php">SERIES</a></li>
		<li><a href="<?= RUTA_APP ?>/contenido.php">BSO</a></li>
		<li><a href="<?= RUTA_APP ?>/retoVista.php">RETOS</a></li>
		<li><a href="<?= RUTA_APP ?>/blog.php">BLOG</a></li>
		<li><a href="<?= RUTA_APP ?>/contenido.php">CONTACTO</a></li>
		<?php 
		if(esAdmin()){
			$s=RUTA_APP;
			echo "<li><a href=\"$s/vistaAdminGestionUser.php\">ADMIN</a></li>";
		}
		
		?>
	</ul>
</nav>
