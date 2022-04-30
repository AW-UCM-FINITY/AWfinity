<?php
require_once __DIR__.'/includes/config.php';
require __DIR__.'/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Películas';
$contenidoPrincipal = "";

$opcion = isset($_GET['opcion']) ? htmlspecialchars(trim(strip_tags($_GET["opcion"]))) : 0;



$formP = new path\FormCatalogoPelis(); //Botones de los filtros
$htmlFormCatalogo = $formP->gestiona();


$contenidoPrincipal .=  "<div class='contenidoPelis'>";

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Películas</span> todos los géneros y más </h1>";
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaPeli.php'> Nueva Película</a> </div>";
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg


$contenidoPrincipal .= "<div class='seccion-pelis'>";

$contenidoPrincipal .= "<div class='intro'>";
$contenidoPrincipal .= "<div class='intro-titulo'><h1>Catálogo</h1></div>";
$contenidoPrincipal .= "<div class='intro-botones'> $htmlFormCatalogo</div>"; //cierra intro-botones
$contenidoPrincipal .= "</div>"; //cierra intro

if(!isset($opcion) || $opcion == 0){
	$arrayPeliculas = path\Pelicula::getPeliculas(); //Obtenemos todas las peliculas
	$contenidoPrincipal .= "<div class='listaPelis catalogo'>";
	foreach ($arrayPeliculas as $key => $value) {
		$ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
		$id_pelicula = $value->getId();
		$contenidoPrincipal .= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img alt='imgPeli' src=$ruta></a>";
	}
	$contenidoPrincipal .= "</div>";//cierra listaPelis
}
else{
	$arrayPelis = path\Pelicula::ordenarPor($opcion);
	$contenidoPrincipal .= "<div class='listaPelis catalogo'>";
	foreach ($arrayPelis as $key => $value) {
		$ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
		$id_pelicula = $value->getId();
		$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img alt='imgPeli' src=$ruta></a>";
	}
	$contenidoPrincipal .= "</div>";//cierra listaPelis
}
$contenidoPrincipal .= "</div>"; //cierra seccion-pelis

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$claseArticle = 'contenidoPeli';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>