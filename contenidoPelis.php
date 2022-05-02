<?php
require_once __DIR__.'/includes/config.php';
require __DIR__.'/includes/helpers/autorizacion.php';


use es\ucm\fdi\aw as path;

$tituloPagina = 'Películas';
$contenidoPrincipal = "";

$opcion = isset($_GET['opcion']) ? htmlspecialchars(trim(strip_tags($_GET["opcion"]))) : 0;


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

$arrayGeneros = path\Pelicula::getGenerosPeli(); //Obtenemos todos los generos disponibles
$arrayPeliculas = path\Pelicula::getPeliculas(); //Obtenemos todas las peliculas


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

foreach ($arrayGeneros as $key => $genero) {
    $contenidoPrincipal .= "<div class='product-item' category='$genero'>";
    $arrayPelis = path\Pelicula::ordenarPor($genero);
    foreach ($arrayPelis as $key => $value) {
		$id_pelicula = $value->getId();
        $ruta = $value->getRutaImagen();
		$cadena = substr($ruta,2); //restamos 2 pa quitar de delante ./
        $titulo = $value->getTitulo();
        $contenidoPrincipal .= "<a href=\"".RUTA_APP."/peliVista.php?id_pelicula=$id_pelicula\"><img src='$cadena' alt='' ></a>";
        // $contenidoPrincipal .= "<a href='#'>$titulo</a>";
    }
    $contenidoPrincipal .= "</div>";
}
$contenidoPrincipal .= "</section>";
$contenidoPrincipal .= "</div>";
$contenidoPrincipal .= "</div>"; 


$contenidoPrincipal .= "</div>"; //Cierre de div = contenidoPelis

$contenidoPrincipal .= "<script src='js/catalogo.js'></script>";

$claseArticle = 'contenidoPeli';
require __DIR__. '/includes/vistas/plantillas/plantilla.php';

?>