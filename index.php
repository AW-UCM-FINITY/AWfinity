<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Página Inicial';
$contenidoPrincipal = "";
$claseArticle = 'Index';

$contenidoPrincipal .= <<< EOS
<section class ="bloque-area">	
	<h1> AWfinity </h1>	
	<h2> Página principal </h2>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
</section>
EOS;
$arrayPelis = path\Pelicula::ordenarPor("anime");

foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........

	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"> 
	 							<img src=$cadena> 
	 					</a>";
}


require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>
