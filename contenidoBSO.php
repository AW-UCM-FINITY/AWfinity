<?php
require_once __DIR__.'/includes/config.php';
require __DIR__.'/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Bandas Sonoras';
$contenidoPrincipal = "";


<<<<<<< HEAD
$contenidoPrincipal .=  "<div class='contenidoBSO'>";
=======

$contenidoPrincipal .=  "<div class='contenidoPelis'>";
>>>>>>> e01492e79207e0cf8db869e4bda7d5e870e31b06

$contenidoPrincipal .= "<div class='encabezado encabezado-bg'> ";
$contenidoPrincipal .= 
"<div class='tituloIndex'>
    <h2>AWfinity </h2>
	<h1>Tus <span>Bandas Sonoras</span> favoritas y más </h1>";
if(esEditor()){
	//Antes de modificar
<<<<<<< HEAD
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaBSO.php'> Nueva BSO</a> </div>";
	
=======
	$contenidoPrincipal .= "<div class='butonGeneral'> <a href='creaBSO.php'> Nueva Banda Sonora</a> </div>";
>>>>>>> e01492e79207e0cf8db869e4bda7d5e870e31b06
}
$contenidoPrincipal .= "</div>";//cierra div tituloIndex
$contenidoPrincipal .= "</div> "; //cierra encabezado encabezado-bg


$contenidoPrincipal .= "<div class='wrap'>";
$contenidoPrincipal .= "<h1>Catálogo</h1>";
$contenidoPrincipal .= "<div class='store-wrapper'>";
$contenidoPrincipal .= "<div class='category_list'>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='all'>Todo</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='accion'>Accion</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='anime'>Anime</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='ciencia ficcion'>Ciencia ficcion</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='comedia'>Comedia</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='drama'>Drama</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='fantasia'>Fantasia</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='musiacal'>Musical</a>";
    $contenidoPrincipal .= "<a href='#' class='category_item' category='terror'>Terror</a>";
$contenidoPrincipal .= "</div>"; //cierra store-wrapper

$contenidoPrincipal .= "<section class='products-list'>";

$arrayGeneros = path\BSO::getGenerosBSO(); //Obtenemos todos los generos disponibles
foreach ($arrayGeneros as $key => $genero) {
    $contenidoPrincipal .= "<div class='product-item' category='$genero'>";
    $arrayBSO = path\BSO::ordenarPor($genero);
    foreach ($arrayBSO as $key => $value) {
		$id_bso = $value->getId();
        $ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
        $titulo = $value->getTitulo();
        $contenidoPrincipal .= "<a href=\"".RUTA_APP."/bsoVista.php?id_bso=$id_bso\"><img src='$cadena' alt='' ></a>";
        // $contenidoPrincipal .= "<a href='#'>$titulo</a>";
    }
    $contenidoPrincipal .= "</div>";
}
$contenidoPrincipal .= "</section>";
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>"; 


$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$contenidoPrincipal .= "<script src='js/catalogo.js'></script>";

$claseArticle = 'contenidoBSO';

require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>