<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Películas';
$contenidoPrincipal = "";
$claseArticle = 'contenidoPeli';
//no se si funciona el link a css contenidoPelis.css
$contenidoPrincipal .= "<link rel='stylesheet' type='text/css' href=\"".RUTA_CSS."/contenidoPelis.css\" />";

$contenidoPrincipal .= 
"<div class='tituloIndex' id ='tituloIndexPeli>
    <h1>AWfinity Películas</h1>
    <h2>Todos los géneros y más </h2>
</div>";


$contenidoPrincipal .=  "<div class='contenidoPelis' id='contenido'>";

/**MOSTRAMOS PELICULAS GENERO ACCION */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE ACCIÓN</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("accion");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO ANIME */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE ANIME</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("anime");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO CIENCIA FICCION */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE CIENCIA FICCIÓN</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("ciencia ficcion");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO COMEDIA */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE COMEDIA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("comedia");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO DRAMA */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE DRAMA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("drama");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO FANTASIA */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE FANTASÍA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("fantasia");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO MUSICAL */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE MUSICAL</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("musical");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO TERROR */
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE TERROR</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("TERROR");
foreach ($arrayPelis as $key => $value) {
	$titulo = $value->getTitulo();
 	$ruta = $value->getRutaImagen();
 	 $cadena = substr($ruta,25); //restamos 25 pa quitar de delante lo de C://........
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?titulo=$titulo\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

$contenidoPrincipal .= "</div>";

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>