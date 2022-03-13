<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Página Inicial';
$contenidoPrincipal = "";
$claseArticle = 'Index';

$arrayPelis = path\Pelicula::ordenarPor("anime");


foreach ($arrayPelis as $key => $value) {
 	$ruta = $value->getRutaImagen();
	$id = $value->getId();
	print("he pasao por getId");
	$id_p = strval($id);
	print($id_p);

	//$pelicula = $value->buscaPeliID($id);
 	$cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	$contenidoPrincipal.= <<< EOS
	<div id ="cartelera">
		<a href="peliVista.php?id_pelicula=<?php echo $id_p; ?>"><img src="$cadena" /></a>
	</div>
	EOS;
}

$contenidoPrincipal .= <<< EOS
<section class ="bloque-area">	
	<h1> AWfinity </h1>	
	<h2> Página principal </h2>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
</section>
EOS;

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>
