<?php
require_once __DIR__.'/includes/config.php';
require __DIR__. '/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Series';
$contenidoPrincipal = "";


$contenidoPrincipal .=  "<div class='contenidoPelis'>";

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Series</span> todos los géneros y más </h1>";
    
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaPeli.php'> Nueva Película</a> </div>";
	
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg


$arrayGeneros = path\Serie::getGenerosSerie(); //Obtenemos todos los generos disponibles
//Recorremos array de generos y mostramos las series
foreach ($arrayGeneros as $key => $genero) {
	$contenidoPrincipal .="<div class='pelisIndex'>";
	$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>SERIES DE $genero </h3> </div>";
	$contenidoPrincipal .= "<div class='peliLista'>";
	$arraySeries = path\Serie::ordenarPor($genero);
	foreach ($arraySeries as $key => $value) {
		$ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
	   $id_serie = $value->getId();
	   $contenidoPrincipal.= "<a href=\"".RUTA_APP."/serieVista.php?id_serie=$id_serie\"><img alt='imgSerie' src=$ruta></a>";
   }
   $contenidoPrincipal .= "</div>";
   $contenidoPrincipal .= "</div>";
}

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoseries

$claseArticle = 'contenidoSerie';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>