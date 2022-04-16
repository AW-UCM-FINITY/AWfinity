<?php
require_once __DIR__.'/includes/config.php';
require __DIR__.'/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Películas';
$contenidoPrincipal = "";


$contenidoPrincipal .=  "<div class='contenidoPelis'>";

$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1><span>Películas</span> todos los géneros y más </h1>";
    
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaPeli.php'> Nueva Película</a> </div>";
	
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex

$arrayGeneros = path\Pelicula::getGenerosPeli(); //Obtenemos todos los generos disponibles

//Recorremos array de generos y mostramos las películas
foreach ($arrayGeneros as $key => $genero) {
	$contenidoPrincipal .="<div class='pelisIndex'>";
	$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>PELÍCULAS DE $genero </h3> </div>";
	$contenidoPrincipal .= "<div class='peliLista'>";
	$arrayPelis = path\Pelicula::ordenarPor($genero);
	foreach ($arrayPelis as $key => $value) {
		$ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
		$id_pelicula = $value->getId();
		$contenidoPrincipal.= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img alt='imgPeli' src=$ruta></a>";
   }
   $contenidoPrincipal .= "</div>";
   $contenidoPrincipal .= "</div>";
}

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$claseArticle = 'contenidoPeli';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>