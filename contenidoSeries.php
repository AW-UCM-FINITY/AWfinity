<?php
require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw as path;

$tituloPagina = 'Series';
$contenidoPrincipal = "";


$contenidoPrincipal .=  "<div class='contenidoSeries'>";

$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Series</span> todos los géneros y más </h1>";
    

if(isset( $_SESSION['esEditor']) &&  $_SESSION['login']==true && $_SESSION['esEditor']==true){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaSerie.php'> Nueva Serie</a> </div>";
	
}
$contenidoPrincipal .= "</div>";




/**MOSTRAMOS SERIES GENERO ACCION */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE ACCIÓN</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arraySeries = path\Serie::ordenarPor("accion");
foreach ($arraySeries as $key => $value) {
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$id_serie = $value->getId();
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$ruta></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS SERIES GENERO ANIME */
$contenidoPrincipal .="<div class='pelisIndex'>"; 
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE ANIME</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("anime");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS SERIES GENERO CIENCIA FICCION */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE CIENCIA FICCIÓN</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("ciencia ficcion");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS SERIES GENERO COMEDIA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE COMEDIA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("comedia");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
 	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";


/**MOSTRAMOS SERIES GENERO DRAMA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE DRAMA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("drama");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS SERIES GENERO FANTASIA */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE FANTASÍA</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("fantasia");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";


/**MOSTRAMOS SERIES GENERO MUSICAL */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE MUSICAL</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("musical");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
	$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	$contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

/**MOSTRAMOS SERIES GENERO TERROR */
$contenidoPrincipal .="<div class='pelisIndex'>";
$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE TERROR</h3> </div>";
$contenidoPrincipal .= "<div class='peliLista'>";
$arrayseries = path\Serie::ordenarPor("TERROR");
foreach ($arrayseries as $key => $value) {
	$id_serie = $value->getId();
 	$ruta = $value->getRutaImagen();
	 $cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	 $contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$cadena></a>";
}
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>";

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoseries

$claseArticle = 'contenidoSerie';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>