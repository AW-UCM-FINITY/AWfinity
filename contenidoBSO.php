<?php
require_once __DIR__.'/includes/config.php';
require __DIR__.'/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Bandas Sonoras';
$contenidoPrincipal = "";


$contenidoPrincipal .=  "<div class='contenidoBSO'>";

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1>Tus <span>Bandas Sonoras</span> favoritas y más </h1>";
    
if(esEditor()){
	//Antes de modificar
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaBSO.php'> Nueva BSO</a> </div>";
	
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg

$arrayGeneros = path\BSO::getGenerosBSO(); //Obtenemos todos los generos disponibles

//Recorremos array de generos y mostramos las películas
foreach ($arrayGeneros as $key => $genero) {
	$contenidoPrincipal .="<div class='pelisIndex'>";
	$contenidoPrincipal.= "<div class='tituloPeliIndex'> <h3>BANDAS SONORAS DE $genero </h3> </div>";
	$contenidoPrincipal .= "<div class='peliLista'>";
	$arrayBSO = path\BSO::ordenarPor($genero);
	foreach ($arrayBSO as $key => $value) {
		$ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
		$id_bso = $value->getId();
		$contenidoPrincipal.= "<a href=\"".RUTA_APP."/bsoVista.php?id_bso=$id_bso\"><img alt='imgBSO' src=$cadena></a>";
   }
   $contenidoPrincipal .= "</div>";
   $contenidoPrincipal .= "</div>";
}

$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$claseArticle = 'contenidoBSO';

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>