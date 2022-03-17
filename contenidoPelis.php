<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Películas';
$contenidoPrincipal = "";


$contenidoPrincipal .=  "<div class='contenidoPelis' id='contenidoPelis'>";

$contenidoPrincipal .= 
"<div class='tituloIndex' id ='tituloIndexPeliculas'>
    <h2>AWfinity </h2>
	<h1><span>Películas</span> todos los géneros y más </h1>";
    

if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true){
	//Antes de modificar
	/*$contenidoPrincipal .= "<a href='creaPeli.php'> Nueva Película</a> ";*/

	$contenidoPrincipal.=<<<EOS
	<form action="./creaPeli.php" method="POST">
	<div>
	<button type="submit" name="creaPeli">Nueva Película</button>
	</div>
	</form>

EOS;
	
}
$contenidoPrincipal .= "</div>";
//$formC = new path\FormEditorEditPeli();
//$htmlFormEditPeli = $formC->gestiona();



/**MOSTRAMOS PELICULAS GENERO ACCION */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE ACCIÓN</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("accion");
foreach ($arrayPelis as $key => $value) {
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_pelicula = $value->getId();
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$ruta></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO ANIME */
$contenidoPrincipal .="<div class='pelisIndex'>"; 
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE ANIME</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("anime");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO CIENCIA FICCION */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE CIENCIA FICCIÓN</h3> </div>";$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("ciencia ficcion");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO COMEDIA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE COMEDIA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("comedia");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";


/**MOSTRAMOS PELICULAS GENERO DRAMA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE DRAMA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("drama");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO FANTASIA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE FANTASÍA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("fantasia");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";


/**MOSTRAMOS PELICULAS GENERO MUSICAL */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE MUSICAL</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("musical");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS PELICULAS GENERO TERROR */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex' id='lista-peli'> <h3>PELÍCULAS DE TERROR</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista' id='pelis'>";
$arrayPelis = path\Pelicula::ordenarPor("TERROR");
foreach ($arrayPelis as $key => $value) {
	$id_pelicula = $value->getId();
 	$ruta = $value->getRutaImagen();
	 $cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$claseArticle = 'contenidoPeli';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>