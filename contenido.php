<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Contenido';

$contenidoPrincipal = '';
if (!isset($_SESSION['login'])){
	$contenidoPrincipal .= <<< EOS
	<h1>Usuario no registrado!</h1>
	<p>Debes iniciar sesión para ver el contenido.</p>
	EOS;
}else{
	$contenidoPrincipal .= <<< EOS
	<h1>PRÓXIMAMENTE.......</h1>
	EOS;
}

require __DIR__. '/includes/vistas/plantillas/plantilla.php';
?>

