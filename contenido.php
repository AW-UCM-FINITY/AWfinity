<?php

require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php'; //Para hacer comprobaciones de login y esEditor


$tituloPagina = 'Contenido';

$contenidoPrincipal = '';
if (!estaLogado()){
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

